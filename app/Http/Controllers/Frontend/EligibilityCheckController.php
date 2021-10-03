<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View; 

use App\Models\VisaServices;
use App\Models\ArrangeQuestions;
use App\Models\EligibilityQuestions;
use App\Models\ConditionalQuestions;
use App\Models\ComponentQuestionIds;
use App\Models\UserEligibilityCheck;
use App\Models\GuestEligibilityTest;
use App\Models\QuestionsGroups;
use App\Models\GroupQuestionIds;
use App\Models\GroupComponentIds;
use App\Models\QuestionCombination;
use App\Models\QuestionOptions;
use App\Models\ComponentQuestions;
use App\Models\ArrangeGroups;
use App\Models\GroupConditionalQuestions;
use App\Models\EligibilityPattern;
use App\Models\CombinationalOptions;
use App\Models\VisaServiceCutoff;
use App\Models\EligibilityScoreRanges;


class EligibilityCheckController extends Controller
{
    public function __construct()
    {
        
    }

    public function eligibilityCheck($visa_service_id){
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
    
        $question_sequence = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['pageTitle'] = "Eligibility Check of ".$visa_service->name;
        
        return view('frontend.eligibility-check.eligibility-check',$viewData);
    }

    public function groupEligibilityReport($report_id){
        $record = GuestEligibilityTest::where("unique_id",$report_id)->first();
        $visa_ids[] = $record->visa_service_id;
        if($record->match_pattern != ''){
            $match_pattern = json_decode($record->match_pattern,true);
            $visa_ids = array_merge($visa_ids,$match_pattern);
        }
        $cutoff_points = VisaServices::with('CutoffPoints')->whereHas('CutoffPoints')->whereIn("unique_id",$visa_ids)->get();
        $score_range = EligibilityScoreRanges::where("visa_service_id",$record->visa_service_id)->first();
        $viewData['record'] = $record;
        $viewData['score_range'] = $score_range;
        $viewData['cutoff_points'] = $cutoff_points;
        $viewData['pageTitle'] = "Eligibility Score";
        
        return view('frontend.eligibility-check.score',$viewData);
    }
    public function fetchConditional(Request $request){
        $question_id = $request->input("question_id");
        $option_value = $request->input("option_value");
        $questions = array();
        $record = ConditionalQuestions::with('GroupComponentIds')
                                ->where("question_id",$question_id)
                                ->where("option_id",$option_value)
                                // ->where("condition_type",'normal')
                                ->first();
     
        $is_component = 0;
        if(!empty($record)){
            if($record->component_id != 0){
                $component_ques_id = ComponentQuestionIds::where("component_id",$record->component_id)->pluck('question_id');
                if(!empty($component_ques_id)){
                    $is_component = 1;
                    $component = ComponentQuestions::where("unique_id",$record->component_id)->first();
                    $viewData['component'] = $component;
                    $component_ques_id = $component_ques_id->toArray();
                    $questions = EligibilityQuestions::whereIn("unique_id",$component_ques_id)
                                                    ->whereHas("ComponentQuestionIds",function($query){
                                                        $query->orderBy("sort_order","asc");
                                                    })
                                                    ->get();
                }
            }

            if($record->conditional_question_id != 0){
                $questions = EligibilityQuestions::where("unique_id",$record->conditional_question_id)->get();
            }
        }
        $viewData['condition_type'] = 'normal';
        $viewData['is_component'] = $is_component;
        $viewData['records'] = $questions;
        $viewData['question_id'] = $question_id;
        $viewData['conditional_question'] = $record;
        $view = View::make(roleFolder().'.eligibility-check.conditional-questions',$viewData);
        $contents = $view->render();
        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function fetchGroupConditional(Request $request){
        
        $question_id = $request->input("question_id");
        $group_id = $request->input("group_id");
        $component_id = $request->input("component_id");
        $option_value = $request->input("option_value");
        $component = array();
        $group = QuestionsGroups::where("unique_id",$group_id)->first();
        $record = GroupConditionalQuestions::where("parent_component_id",$component_id)
                                            ->where("group_id",$group_id)
                                            ->where("option_id",$option_value)
                                            ->first();  
        
        if(!empty($record)){
            $component = ComponentQuestions::with('Questions')
                                        ->where('unique_id',$record->component_id)
                                        ->first();
        
            $viewData['group'] = $group;
            $viewData['question_id'] = $question_id;
            $viewData['component_id'] = $component_id;
            $viewData['component'] = $component;
            $view = View::make('frontend.eligibility-check.group-conditional-questions',$viewData);
            $contents = $view->render();
            $response['status'] = true;
            $response['contents'] = $contents;
        }else{
            $response['status'] = false;
        }
        return response()->json($response);
    }

    public function saveEligibilityScore($visa_service_id,Request $request){
        
        $validator = Validator::make($request->all(), [
            'question'=> 'required',
        ]);
        
        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = '';
            
            foreach($error as $key => $err){
                $errMsg .= "<p>".$err[0]."</p>";
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $questions = $request->question;
        $score = 0;
        $option_ids = array();
        $question_score = array(); 
        $question_ids = array(); 
        foreach($questions as $key => $value){
            $question = EligibilityQuestions::where("unique_id",$key)->first();
            $option = $question->optionScore($value,"value",$key);
            if(!empty($option)){
                $score += $option->score;
                $option_ids[] = $option->id;
                $question_score[$option->question_id] = $option->score;
                $question_ids[] = $option->question_id;
            }
        }
        $question_combinations = QuestionCombination::where("visa_service_id",$visa_service_id)->get();
        foreach($question_combinations as $combination){
            $flag = 0;
            if(in_array($combination->option_id_one,$option_ids) && in_array($combination->option_id_two,$option_ids)){
                // pre($combination->toArray());
                if($combination->behaviour == 'add'){
                    $score += $combination->score;
                }
                if($combination->behaviour == 'substract'){
                    $score -= $combination->score;
                }

                if($combination->behaviour == 'overwrite'){
                    $optids = array($combination->option_id_one,$combination->option_id_two);
                    $opt_sum = QuestionOptions::whereIn("id",$optids)->sum("score");
                    $divide = $opt_sum/2;
                    $question_score[$combination->question_id_one] = $divide;
                    $question_score[$combination->question_id_two] = $divide;
                    $score -= $opt_sum;
                    $score += $combination->score;
                }
            }
        }
        $question_combinations = ComponentQuestions::with('Questions')->where("visa_service_id",$visa_service_id)->get();
        $combination_score = array();
        foreach($question_combinations as $combination){
            $comb_ques = $combination->Questions;
            $check_score = 0;
            $ques_exists = 0;
            foreach($comb_ques as $ques){
                if(isset($question_score[$ques->question_id])){
                    $ques_exists=1;
                    $check_score += $question_score[$ques->question_id];
                }
            }
            if($ques_exists == 1){
                // echo "<br>max_score: ".$combination->max_score;
                // echo "<br>before score: ".$score;
                if($check_score > $combination->max_score){
                    
                    $difference = $check_score - $combination->max_score;
                    // echo "<br>Difference: ".$difference;
                    $score -= $difference;
                }
                $combination_score[$combination->unique_id] = $combination->max_score;
                // echo "<br>check score: ".$check_score;
                // echo "<br>after score: ".$score;
            }
            // echo "check_score: ".$check_score."<Br>";
            // echo "ques_exists: ".$ques_exists."<Br>";
            
        }
        // pre($combination_score);
        $question_groups = QuestionsGroups::with(['Components'])->where("visa_service_id",$visa_service_id)->get();
        
        foreach($question_groups as $group){
           
            $comp_count = 0;
            $group_score = 0;
            $group_score_count = 0;
            foreach($group->Components as $comp){
             
                // pre($comp->toArray());
                if(isset($combination_score[$comp->component_id])){
                 
                    $group_score += $combination_score[$comp->component_id];
                    $group_score_count++;
                }
            }
           
            $score_difference = 0;
            if(!empty($group->Components)){
                if(count($group->Components) == $group_score_count){
                    if($group_score > $group->max_score){
                        $score_difference = $group_score - $group->max_score;
                        $score -= $score_difference;
                    }
                }
            }
        }
        // Comment by yash
        $unique_id = randomNumber();
        $object = new GuestEligibilityTest();
        // $object->user_email = "soni.yash7874@m.s";
        $object->unique_id = $unique_id;
        $object->visa_service_id = $visa_service_id;
        $object->response = json_encode($questions);
        $object->score = $score;
        $object->save();
        // pre($question_score);

        $response['status'] = true;
        $response['score'] = $score;
        $response['redirect_back'] = url("check-eligibility/report/".$unique_id);
        
        return response()->json($response);
    }

    public function allEligibility(){
        $viewData['pageTitle'] ="All Eligibility Check";
        return view(roleFolder().'.eligibility-check.all-check',$viewData);        
    }

    public function eligibilityForm(Request $request)
    {   
        $search = $request->input("search");
     
        $records = VisaServices::where(function($query) use($search){
                                if($search != ''){
                                    $query->where("name","LIKE","%".$search."%");
                                }
                            })
                            ->whereHas("ArrangeQuestions")
                            ->orderBy('id',"desc")
                            ->where("cv_type",\Auth::user()->UserDetail->cv_type)
                            ->paginate(1);
        
        $record = $records[0];
        $visa_service_id = $record->unique_id;
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
    
        $question_sequence = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['pageTitle'] = "Eligibility Check of ".$visa_service->name;
        $view = View::make(roleFolder().'.eligibility-check.eligibility-form',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function groupEligibilityCheck($visa_service_id){
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
    
        $question_sequence = ArrangeGroups::where("visa_service_id",$visa_service->unique_id)
                                        ->orderBy("sort_order","asc")
                                        ->get();
        $viewData['eligible_check'] = 'group';
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['action'] = 'single';
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();

        $view = View::make('frontend.eligibility-check.group-form',$viewData);
        $group_form =  $view->render();
        
        $viewData['group_form'] = $group_form;
        $viewData['pageTitle'] = "Eligibility Check of ".$visa_service->name;
        
        return view('frontend.eligibility-check.group-eligibility-check',$viewData);
    }

    public function allGroupEligibilityCheck(){
        
        $viewData['eligible_check'] = 'group';
        
        $viewData['pageTitle'] = "All Group Eligibility Check";
        

        return view('frontend.eligibility-check.all-group-eligibility',$viewData);
    }

    public function getGroupEligibilityForm(Request $request){
        
        $records = ArrangeGroups::orderBy("sort_order","asc")->paginate(1);
        $record = $records[0];
        $visa_service_id = $record->visa_service_id;
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
    
        $viewData['eligible_check'] = 'group';
        $viewData['question_sequence'] = $records;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['action'] = "multiple";
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();

        $view = View::make(roleFolder().'.eligibility-check.group-form',$viewData);
        $contents =  $view->render();
        
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
        
    }
    public function saveGroupEligibilityScore($visa_service_id,Request $request){
        $validator = Validator::make($request->all(), [
            'question'=> 'required',
        ]);
        
        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = '';
            
            foreach($error as $key => $err){
                $errMsg .= "<p>".$err[0]."</p>";
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        
        
        $questions = $request->input("question");
        
        $component_questions = array();
        $ques_response = array();
        foreach($questions as $group => $comp){
            foreach($comp as $comp_id => $ques_ids){
                $component_questions[$comp_id] = $ques_ids;
            }
        }
        $comp_ques_score = array();
        foreach($component_questions as $comp_id => $question_ids){
            
            foreach($question_ids as $key => $value){
                $question = EligibilityQuestions::where("unique_id",$key)->first();
                $option = $question->optionScore($value,"value",$key);
                if(!empty($option)){       
                    $option_ids[] = $option->id;
                    $comp_ques_score[$comp_id][$option->question_id]['score'] = $option->score;
                    $comp_ques_score[$comp_id][$option->question_id]['option_id'] = $option->id;
                    $ques_response[$option->question_id] = $option->option_value;
                }
            }
        }
        
        $comp_final_score = array();
        foreach($comp_ques_score as $comp_id => $question_ids){
            $component = ComponentQuestions::with('Questions')
                                ->where("unique_id",$comp_id)
                                ->first();
            $cqs_score = 0;
            $component_max_score = $component->max_score;
            $component_min_score = $component->min_score;
            $option_ids = array();
            foreach($question_ids as $qid => $opt_score){
                $cqs_score += $opt_score['score'];
                $option_ids[] = $opt_score['option_id'];
            }
            
            // pre($component->toArray());
            // echo "Component ID: ".$component->unique_id."<br>";
            // echo "Component: ".$component->component_title."<br>";
            // echo "Component Max Score: ".$component->max_score."<br>";
            // echo "Component Current Score: ".$cqs_score."<br>";
            
            $question_combinations = QuestionCombination::where("component_id",$component->unique_id)->get();
            // echo "Combination Exists: ".count($question_combinations)."<br>";
            if(count($question_combinations)>0){
                foreach($question_combinations as $combination){
                    if(in_array($combination->option_id_one,$option_ids) && in_array($combination->option_id_two,$option_ids)){
                        
                        
                        if($combination->behaviour == 'add'){
                            $cqs_score += $combination->score;
                        }
                        if($combination->behaviour == 'substract'){
                            $cqs_score -= $combination->score;
                        }
                        if($combination->behaviour == 'overwrite'){
                            $optids = array($combination->option_id_one,$combination->option_id_two);
                            $opt_sum = QuestionOptions::whereIn("id",$optids)->sum("score");
                            $divide = $opt_sum/2;
                            $question_score[$combination->question_id_one] = $divide;
                            $question_score[$combination->question_id_two] = $divide;
                            $cqs_score -= $opt_sum;
                            $cqs_score += $combination->score;
                        }
                        if($cqs_score > $component_max_score){
                            $diff = $cqs_score - $component_max_score;
                            $cqs_score = $cqs_score - $diff;
                        }
                        $comp_final_score[$component->unique_id] = $cqs_score;
                        // echo "Component AFTER Score: ".$cqs_score."<br>";
                       
                    }
                }
            }else{
                $comp_final_score[$component->unique_id] = $cqs_score;
            }
            // if($cqs_score < $component_min_score){
            //     $cqs_score = $component_min_score;
            // }
        }
        $scores = 0;
        
        foreach($comp_final_score as $key => $value){
            $group = GroupComponentIds::with('QuestionsGroups')->where("component_id",$key)->first();
            if(!empty($group)  && $group->QuestionsGroups->is_default != 1){
                $grp_max_score = $group->QuestionsGroups->max_score;
                if($value > $grp_max_score){
                    $value = $grp_max_score;
                }
            }
            $scores += $value;
        }
        
        // echo "Score Before: ".$scores."<br>";
        $checkPatterns = EligibilityPattern::where('visa_service_id',$visa_service_id)->get();
        $match_pattern = array();
        foreach($checkPatterns as $pattern){
            $elg_pattern = json_decode($pattern->response,true);
            $flag = 1;
            foreach($ques_response as $key => $value){
                if(isset($elg_pattern[$key]) && !in_array($value,$elg_pattern[$key])){
                    $flag = 0;
                }
            }
            if($flag == 1){
                $match_pattern[] = $pattern->sub_visa_service;
            }
        }
        // pre($ques_response);
        
        foreach($ques_response as $key => $ques){
            // echo "Ques: ".$key."<br>";
            $elg_question = EligibilityQuestions::where("unique_id",$key)->first();
            // pre($elg_question->toArray());
            if(!empty($elg_question) && $elg_question->linked_to_cv == 'yes' && $elg_question->cv_section == 'education'){
                // echo "<h1>EDU</h1>";
                $multipleOptions = CombinationalOptions::where("question_id",$key)->get();
                $user_education_id = \Auth::user()->Educations->pluck("degree_id");
                if(!empty($user_education_id)){
                    $user_education_id = $user_education_id->toArray();
                    // pre($user_education_id);
                    foreach($multipleOptions as $opt){
                        // pre($opt->toArray());
                        if(in_array($opt->option_one_value,$user_education_id) && in_array($opt->option_two_value,$user_education_id)){
                            // echo "Match";
                            $ques_opt = QuestionOptions::where("question_id",$key)->where("option_value",$ques)->first();
                            if($ques_opt->level < $opt->level){
                                $scores += $opt->score;
                            }
                        }
                    }
                }
            }
        }
        // echo "Score After: ".$scores."<br>";
        // pre($ques_response);
        // exit;
       
        //Comment by yash
        $unique_id = randomNumber();
        $object = new GuestEligibilityTest();
        $object->unique_id = $unique_id;
        $object->visa_service_id = $visa_service_id;
        $object->response = json_encode($questions);
        $object->score = $scores;
        $object->eligible_type = "group";
        if(!empty($match_pattern)){
            $object->match_pattern = json_encode($match_pattern);
        }
        $object->save();
        // pre($question_score);

        $response['status'] = true;
        $response['score'] = $scores;
        $html = "<div class='card-footer'>";
        $html .= "<div class='row'>";
        $html .= "<div class='col-md-6'><h2 class='text-danger mt-2'>Score: $scores</h2></div>";
        $download = '<a href="'.baseUrl('eligibility-check/download-report/'.base64_encode($object->id)).'" class="btn btn-primary"><i class="tio-download"></i> Download Report</a>';
        $html .= "<div class='col-md-6 text-right'>".$download."</div></div>";
        $html .= "</div>";

        $response['redirect_back'] = baseUrl("check-eligibility/g/report/".$unique_id);
        $response['html'] = $html;
        return response()->json($response);
    }
   


    public function downloadGroupReport($id){
        $id = base64_decode($id);
        $report = GuestEligibilityTest::where("id",$id)->first();
        $ques_response = json_decode($report->response,true);
        // pre($ques_response);
     
        // pre($report->toArray());exit;
        $questions = array();
        // echo "Ques:";
        foreach($ques_response as $group_id => $components){
            $temp = array();
            $group = QuestionsGroups::where("unique_id",$group_id)->first();
            $temp['group_title'] = $group->group_title;
            $temp['max_score'] = $group->max_score;
            // echo "<br><h1>Group:</h1>";
            // pre($group->toArray());
            $temp_questions = array();
            foreach($components as $component_id => $ques){
                foreach($ques as $question_id => $value){
                    $qs = EligibilityQuestions::where("unique_id",$question_id)->first();
                    $temp_questions[] = array("question"=>$qs->question,"selected_value"=>$value,'additional_notes'=>$qs->additional_notes);    
                }
            }
            $temp['questions'] = $temp_questions;
            $questions[] = $temp;
        }
        $viewData['questions'] = $questions;

        $visa_ids[] = $report->visa_service_id;
        if($report->match_pattern != ''){
            $match_pattern = json_decode($report->match_pattern,true);
            $visa_ids = array_merge($visa_ids,$match_pattern);
        }
        $cutoff_points = VisaServices::with('CutoffPoints')->whereHas('CutoffPoints')->whereIn("unique_id",$visa_ids)->get();
        
        $viewData['cutoff_points'] = $cutoff_points;
        // $view = View::make(roleFolder().'.eligibility-check.group-report',$viewData);
        // $contents = $view->render();
        // echo $contents;
        $viewData['score'] = $report->score;
        $viewData['report'] = $report;
        $pdf_doc = \PDF::loadView('frontend.eligibility-check.group-report', $viewData);
        return $pdf_doc->download('report.pdf');
    }
}
