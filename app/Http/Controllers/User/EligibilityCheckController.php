<?php

namespace App\Http\Controllers\User;

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
use App\Models\LanguageProficiency;
use App\Models\LanguageScoreChart;
use App\Models\LanguageScorePoints;
use App\Models\ComponentPreConditions;
use App\Models\VisaServiceGroups;
use App\Models\ProgramTypes;
use App\Models\GroupVisaIds;
use App\Models\MultipleOptionsGroups;
use App\Models\PrimaryDegree;

class EligibilityCheckController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function groupList()
    {
        $visa_services = VisaServices::get();
        $viewData['pageTitle'] ="Visa Groups";
        $viewData['activeTab'] = "eligibility-check";
        $program_types = ProgramTypes::get();
        $viewData['program_types'] = $program_types;
        return view(roleFolder().'.eligibility-check.visa-groups',$viewData);
    } 

    public function groupAjaxList(Request $request)
    {   
        $search = $request->input("search");
        $program_types = $request->input("program_types");
        $records = VisaServiceGroups::where(function($query) use($search,$program_types){
                                if($search != ''){
                                    $query->where("group_title","LIKE","%".$search."%");
                                }
                                if(!empty($program_types)){
                                    $query->whereIn("program_type",$program_types);
                                }
                            })
                            ->whereHas("VisaServices")
                            ->orderBy('id',"desc")
                            ->paginate();
       
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.eligibility-check.group-ajax-lists',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function list($visa_group_id)
    {
        $visa_services = VisaServices::get();
        $group = VisaServiceGroups::where("unique_id",$visa_group_id)->first();
        $viewData['record'] = $group;
        $viewData['visa_services'] = $visa_services;
        $viewData['visa_group_id'] = $visa_group_id;
        $viewData['pageTitle'] ="Group Programs of ".$group->group_title;
        $viewData['activeTab'] = "eligibility-check";
        return view(roleFolder().'.eligibility-check.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {   
        $search = $request->input("search");
        $visa_group_id = $request->input("visa_group_id");
        $records = GroupVisaIds::where("visa_group_id",$visa_group_id)
                            ->whereHas("VisaService",function($query) use($search){
                                if($search != ''){
                                    $query->where("name","LIKE","%".$search."%");
                                }
                            })
                            ->with("VisaService")
                            ->paginate();
        // $records = VisaServices::where(function($query) use($search){
        //                         if($search != ''){
        //                             $query->where("name","LIKE","%".$search."%");
        //                         }
        //                     })
        //                     // ->whereHas("ArrangeQuestions")
        //                     ->where("cv_type",\Auth::user()->UserDetail->cv_type)
        //                     ->where("parent_id",0)
        //                     ->orderBy('id',"desc")
        //                     ->paginate();
       
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.eligibility-check.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function eligibilityCheck($visa_service_id){
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
    
        $question_sequence = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $group = $visa_service->visaGroup;
        $viewData['group'] = $group;
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['pageTitle'] = "Eligibility Check of ".$visa_service->name;
        
        $viewData['activeTab'] = "eligibility-check";
        return view(roleFolder().'.eligibility-check.eligibility-check',$viewData);
    }
    public function eligibilityReport($report_id){
        $record = UserEligibilityCheck::where("unique_id",$report_id)->first();
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
        
        
        
        // Report 
        
        $questions = json_decode($record->response,true);
        if($record->final_score != ''){
            $final_score = json_decode($record->final_score,true);
        }else{
            $final_score = array();
        }
        
        $final_questions = array();
        
        if($record->eligible_type == 'group'){
            foreach($questions as $group_id => $component_ids){
                $temp = array();
                $group = QuestionsGroups::where("unique_id",$group_id)->first();
                // echo "Group ID: ".$group->group_title."<BR>";
                $temp['group_title'] = $group->group_title;
                $temp['max_score'] = $group->max_score;
                $temp['min_score'] = $group->min_score;
                $components = array();
                foreach($component_ids as $component_id => $question_ids){
                    $comp_temp = array();
                    $component = ComponentQuestions::where("unique_id",$component_id)->first();
                    $comp_temp['component_title'] = $component->component_title;
                    $comp_temp['unique_id'] = $component->unique_id;
                    $comp_temp['max_score'] = $component->max_score;
                    $comp_temp['min_score'] = $component->min_score;
                    foreach($question_ids as $q_id => $opt_value){
                        if($opt_value != ''){
                            $question = EligibilityQuestions::where("unique_id",$q_id)->first();
                            $comp_ques['question'] = $question->question;
                            $ques_option = QuestionOptions::where("question_id",$q_id)
                                                        ->where("option_value",$opt_value)->first();
                            $comp_ques['option_value'] = $ques_option->option_label;
                            $comp_ques['score'] = $ques_option->score;
                            $comp_ques['non_eligible'] = $ques_option->non_eligible;
                            $comp_ques['non_eligible_reason'] = $ques_option->non_eligible_reason;
                            $comp_temp['questions'][] = $comp_ques;
                        }
                    }
                    $components[] = $comp_temp;
                }
                $temp['components'] = $components;
                $final_questions[] = $temp;
            }
        }else{
            foreach($questions as $question_id => $ques_value){
                $temp = array();
                if($ques_value != ''){
                    $question = EligibilityQuestions::where("unique_id",$question_id)->first();
                    $temp['question'] = $question->question;
                    $ques_option = QuestionOptions::where("question_id",$question_id)
                                                ->where("option_value",$ques_value)->first();
                    $temp['option_value'] = $ques_option->option_label;
                    $temp['score'] = $ques_option->score;
                    $temp['non_eligible'] = $ques_option->non_eligible;
                    $temp['non_eligible_reason'] = $ques_option->non_eligible_reason;
                
                    $final_questions[] = $temp;
               }
            }   
        }
        $viewData['activeTab'] = "eligibility-check";
        $viewData['final_score'] = $final_score;
        $viewData['final_questions'] = $final_questions;
        return view(roleFolder().'.eligibility-check.score',$viewData);
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
                                            ->whereHas("Group")
                                            ->first();  
        
        if(!empty($record)){
            $component = ComponentQuestions::with('Questions')
                                        ->where('unique_id',$record->component_id)
                                        ->first();
        
            $viewData['group'] = $group;
            $viewData['question_id'] = $question_id;
            $viewData['component_id'] = $component_id;
            $viewData['component'] = $component;
            $view = View::make(roleFolder().'.eligibility-check.group-conditional-questions',$viewData);
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
            $lang_prof_id = '';
            if($question->language_type == 'first_official'){
                if(!empty(\Auth::user()->FirstProficiency)){
                    $lang_prof_id = \Auth::user()->FirstProficiency->proficency;
                }
            }
            if($question->language_type == 'second_official'){
                if(!empty(\Auth::user()->SecondProficiency)){
                    $lang_prof_id = \Auth::user()->SecondProficiency->proficency;
                }
            }
            $option = $question->optionScore($value,"value",$key,$lang_prof_id);
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
        $unique_id = randomNumber();
        $object = new UserEligibilityCheck();
        $object->user_id = \Auth::user()->unique_id;
        $object->unique_id = $unique_id;
        $object->response = json_encode($questions);
        $object->score = $score;
        $object->save();
        // pre($question_score);

        $response['status'] = true;
        $response['score'] = $score;
        $response['redirect_back'] = baseUrl("eligibility-check/report/".$unique_id);
        
        return response()->json($response);
    }

    public function allEligibility(){
        $viewData['pageTitle'] ="All Eligibility Check";
        $viewData['activeTab'] = "eligibility-check";
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
        if(count($records) == 0){
            $response['status'] = false;
            $response['message'] = "No eligibility check form available";
            $response['redirect_url'] = baseUrl("/eligibility-check");
            // return redirect()->back()->with("error","No eligibility check form available");
        }else{
            
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
            $response['status'] = true;
            $response['contents'] = $contents;
            $response['last_page'] = $records->lastPage();
            $response['current_page'] = $records->currentPage();
            $response['total_records'] = $records->total();
        }
        return response()->json($response);
    }

    public function groupEligibilityCheck($visa_service_id){
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
    
        $question_sequence = ArrangeGroups::where("visa_service_id",$visa_service->unique_id)
                                        ->orderBy("sort_order","asc")
                                        ->whereHas("Group")
                                        ->get();
        $group = $visa_service->visaGroup;
        $viewData['group'] = $group;
        $viewData['eligible_check'] = 'group';
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['action'] = 'single';
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();

        $view = View::make(roleFolder().'.eligibility-check.group-form',$viewData);
        $group_form =  $view->render();
        
        $viewData['group_form'] = $group_form;
        $viewData['pageTitle'] = "Eligibility Check of ".$visa_service->name;
        $viewData['activeTab'] = "eligibility-check";
        return view(roleFolder().'.eligibility-check.group-eligibility-check',$viewData);
    }

    public function allGroupEligibilityCheck(){
        
        $viewData['eligible_check'] = 'group';
        
        $viewData['pageTitle'] = "All Group Eligibility Check";
        

        return view(roleFolder().'.eligibility-check.all-group-eligibility',$viewData);
    }

    public function getGroupEligibilityForm(Request $request){
        
        $records = ArrangeGroups::orderBy("sort_order","asc")
                                ->whereHas("Group")
                                ->paginate(1);
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
        $is_minimum_score = 0;
        $component_questions = array();
        $ques_response = array();
        foreach($questions as $group => $comp){
            foreach($comp as $comp_id => $ques_ids){
                $component_questions[$comp_id] = $ques_ids;
            }
        }
        $comp_ques_score = array();
        // echo "Component Ques:";
        // pre($component_questions);
        
        
        foreach($component_questions as $comp_id => $question_ids){
            
            foreach($question_ids as $key => $value){
                $question = EligibilityQuestions::where("unique_id",$key)->first();
                if($question->linked_to_cv != 'no'){
                    $lang_prof_id = '';
                    // pre(\Auth::user()->FirstProficiency->toArray());
                    // pre(\Auth::user()->SecondProficiency->toArray());
                    if($question->language_type == 'first_official'){
                        if(!empty(\Auth::user()->FirstProficiency)){
                            $lang_prof_id = \Auth::user()->FirstProficiency->proficiency;
                        }
                    }
                    if($question->language_type == 'second_official'){
                        if(!empty(\Auth::user()->SecondProficiency)){
                            $lang_prof_id = \Auth::user()->SecondProficiency->proficiency;
                        }
                    }
                    // echo "lang_prof_id: ".$lang_prof_id."<br>";
                    $option = $question->optionScore($value,"value",$key,$lang_prof_id);
                }else{
                    $option = $question->optionScore($value,"value",$key);
                }
                // echo "OPTION SCORE:";
                // pre($option);
                if(!empty($option)){       
                    $option_ids[] = $option->id;
                    
                    $comp_ques_score[$comp_id][$option->question_id]['score'] = $option->score;
                    $comp_ques_score[$comp_id][$option->question_id]['option_id'] = $option->id;
                    // $ques_response[$option->question_id] = $option->option_value;
                    $ques_response[] = array("question_id"=>$option->question_id,"option_value"=>$option->option_value,"component_id"=>$comp_id);
                }
            }
        }
        // pre($comp_ques_score);
        // exit;
        $comp_final_score = array();
        foreach($comp_ques_score as $comp_id => $question_ids){
            $component = ComponentQuestions::with('Questions')
                                ->where("unique_id",$comp_id)
                                ->first();
            $cqs_score = 0;
            // pre($component->toArray());
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
                        // echo "Enter IF";
                        // pre($combination->toArray());
                        // echo "CQS Score: ".$cqs_score."<Br>";
;                       if($combination->behaviour == 'add'){
                            $cqs_score += $combination->score; 
                        }
                        if($combination->behaviour == 'substract'){
                            $cqs_score -= $combination->score;
                        }
                        if($combination->behaviour == 'overwrite'){
                            $optids = array($combination->option_id_one,$combination->option_id_two);
                            $opt_sum = QuestionOptions::whereIn("id",$optids)->sum("score");
                            if($opt_sum < $component_max_score){
                                $cqs_score -= $opt_sum;
                                $cqs_score += $combination->score;    
                            }else{
                                $cqs_score -= $component_max_score;
                                $cqs_score += $combination->score;    
                            }
                            // echo "sum: ".$opt_sum."<br>";
                            // $divide = $opt_sum/2;
                            // $question_score[$combination->question_id_one] = $divide;
                            // $question_score[$combination->question_id_two] = $divide;
                            
                        }
                        // echo "CQS Score AFter: ".$cqs_score."<Br>";
                        if($cqs_score > $component_max_score){
                            // $diff = $cqs_score - $component_max_score;
                            // $cqs_score = $cqs_score - $diff;
                            $cqs_score = $component_max_score;
                        }
                        if($cqs_score < $component_min_score){
                            $cqs_score = $component_min_score;
                            $is_minimum_score = 1;
                        }
                        // echo "CQS Score Final: ".$cqs_score."<Br>";
                        $comp_final_score[$component->unique_id] = $cqs_score;
                        // echo "Component AFTER Score: ".$cqs_score."<br>";
                       
                    }else{
                        // echo "BEFORE cqs_score: ".$cqs_score." comp max: ".$component_max_score."<br>";
                        if($cqs_score > $component_max_score){
                            $diff = $cqs_score - $component_max_score;
                            // $cqs_score = $cqs_score - $diff;
                            $cqs_score = $component_max_score;
                        }
                        if($cqs_score < $component_min_score){
                            $cqs_score = $component_min_score;
                            $is_minimum_score = 1;
                        }
                        // echo "AFTER cqs_score: ".$cqs_score." comp max: ".$component_max_score."<br><BR><BR><Hr>";
                        $comp_final_score[$component->unique_id] = $cqs_score;
                    }
                }
            }else{
                // echo "BEFORE cqs_score: ".$cqs_score." comp max: ".$component_max_score."<br>";
                if($cqs_score > $component_max_score){
                    $diff = $cqs_score - $component_max_score;
                    // $cqs_score = $cqs_score - $diff;
                    $cqs_score = $component_max_score;
                }
                if($cqs_score < $component_min_score){
                    $cqs_score = $component_min_score;
                    $is_minimum_score = 1;
                }
                // echo "AFTER cqs_score: ".$cqs_score." comp max: ".$component_max_score."<br><BR><BR><Hr>";
                $comp_final_score[$component->unique_id] = $cqs_score;
            }
         
         
            // Multiple Option Combination
            $multiple_option_groups = MultipleOptionsGroups::with(['CombinationalOption','QuestionOption'])
                                            ->where("component_id",$component->unique_id)
                                            ->whereHas("GroupQuestion")
                                            ->whereHas("Question")
                                            ->get();
            if(isset($comp_final_score[$component->unique_id])){
                $mog_score = $comp_final_score[$component->unique_id];
                // echo "<H1>MOG DATA: </H1>";
                foreach($multiple_option_groups as $mog){
                    if($mog->GroupQuestion->cv_section == 'education'){
                         $user_education_id = \Auth::user()->Educations->pluck("degree_id");
                        if(!empty($user_education_id)){
                                $user_education_id = $user_education_id->toArray();
                        }
                        if(in_array($mog->CombinationalOption->option_one_value,$user_education_id) && in_array($mog->CombinationalOption->option_two_value,$user_education_id) && in_array($mog->QuestionOption->id,$option_ids)){
                            // echo "<br>Match Found<br>";
                            
                            if(!empty($user_education_id)){
                                $primary_degree = PrimaryDegree::whereIn("id",$user_education_id)->pluck("level");
                                if(!empty($primary_degree)){
                                    $primary_degree_level = $primary_degree->toArray();
                                    $highest_level = max($primary_degree_level);
                                    // echo "HiGHEST: ".$highest_level."<br>";
                                    // echo "Mog LEvel: ".$mog->level."<br>";
                                    if($highest_level < $mog->level){
                                        if($mog->behaviour == 'add'){
                                            $mog_score += $mog->score;  
                                            // echo "added";
                                        }
                                        if($mog->behaviour == 'substract'){
                                            $mog_score -= $mog->score;
                                        }
                                        if($mog->behaviour == 'overwrite'){
                                            // $optids = array($combination->option_id_one,$combination->option_id_two);
                                            // $opt_sum = QuestionOptions::whereIn("id",$optids)->sum("score");
                                            $mques_ids = array($mog->group_question_id,$mog->question_id);
                                            $combques = QuestionCombination::where('component_id',$component->unique_id)->whereIn("question_id_one",$mques_ids)->whereIn("question_id_two",$mques_ids)->first();
                                            if(!empty($combques)){
                                                // if($combques->score < $mog->score){
                                                    $mog_score -= $combques->score;
                                                    $mog_score += $mog->score;    
                                                // }
                                            }
                                        }
                                        // // echo "CQS Score AFter: ".$cqs_score."<Br>";
                                        if($mog_score > $component_max_score){
                                            // $diff = $cqs_score - $component_max_score;
                                            // $cqs_score = $cqs_score - $diff;
                                            $mog_score = $component_max_score;
                                        }
                                        if($mog_score < $component_min_score){
                                            $mog_score = $component_min_score;
                                            $is_minimum_score = 1;
                                        }
                                        $comp_final_score[$component->unique_id] = $mog_score;
                                    }
                                }
                            }else{
                                $user_education_id = array();
                            }
                            // echo "UEDU:<br>";
                            // echo "COMP FINAL SCORE: ";
                            // pre($comp_final_score);
                            // pre($mog->toArray());
                            //   pre($mog->behaviour);
                            //   pre($mog->level);
                        }
                    }
                }
            }
            
        }
        // echo "<Br>Before Score: ";
        // pre($comp_final_score);
         
        $scores = 0;
      
        foreach($comp_final_score as $key => $value){
            $group = GroupComponentIds::with('QuestionsGroups')
                                    ->where("component_id",$key)
                                    ->first();
            if(!empty($group)  && $group->QuestionsGroups->is_default != 1){
                $grp_max_score = $group->QuestionsGroups->max_score;
                if($value > $grp_max_score){
                    $value = $grp_max_score;
                }
            }
            $scores += $value;
        }
        
        // echo "Score Before 1: ".$scores."<br>";
        $checkPatterns = EligibilityPattern::where('visa_service_id',$visa_service_id)->get();
        $match_pattern = array();
        foreach($checkPatterns as $pattern){
            $elg_pattern = json_decode($pattern->response,true);
            $flag = 1;
            foreach($ques_response as $value){
                $key = $value['question_id'];
                if(isset($elg_pattern[$key]) && !in_array($value['option_value'],$elg_pattern[$key])){
                    $flag = 0;
                }
            }
            if($flag == 1){
                $match_pattern[] = $pattern->sub_visa_service;
            }
        }
        
        // echo "<Br>Before Score: ".$scores."<br>";
        foreach($ques_response as $value){
            $key = $value['question_id'];
            $ques = $value['option_value'];
            $component_id = $value['component_id'];
            // echo "options: ".$ques."<br>";
            $elg_question = EligibilityQuestions::where("unique_id",$key)->first();
            // pre($elg_question->toArray());
            $current_option = QuestionOptions::where("question_id",$key)->where("option_value",$ques)->first();
           
            if(!empty($elg_question) && $elg_question->linked_to_cv == 'yes' && $elg_question->cv_section == 'education'){
                // echo "<h1>EDU: $key</h1>";
                $multipleOptions = CombinationalOptions::where('component_id',$component_id)->where("question_id",$key)->get();
                $component_ques = ComponentQuestions::where('unique_id',$component_id)->first();
                $user_education_id = \Auth::user()->Educations->pluck("degree_id");
                if(!empty($user_education_id)){
                    $user_education_id = $user_education_id->toArray();
                    // echo "<h1>Count MOP: ".count($multipleOptions)."</h1>";
                    foreach($multipleOptions as $opt){
                        // pre($opt->toArray());
                        if(in_array($opt->option_one_value,$user_education_id) && in_array($opt->option_two_value,$user_education_id)){
                            // echo "<br>Match";
                            // pre($opt->toArray());
                             
                            $ques_opt = QuestionOptions::where("question_id",$key)->where("option_value",$ques)->first();
                            if($ques_opt->level < $opt->level){
                                // echo "SSSS: ".$scores."<br>";
                                // echo "ccccSSSS: ".$current_option->score."<br>";
                                // echo "oooSSSS: ".$opt->score."<br>";
                                // pre($comp_ques_score);
                                $cs = 0;
                                foreach($comp_ques_score[$component_id] as $comid => $quesid){
                                  
                                   $cs+=$quesid['score'] ;
                                }
                                // echo "<H1>CS: ".$cs."<br>";
                                // echo "<H1>CSMAX:".$component_ques->max_score."</H1>";
                                // echo "<H1>scores: ".$scores."<br>";
                                if($cs < $component_ques->max_score){
                                    $scores -= $current_option->score;
                                    $scores += $opt->score;
                                }
                                
                                // echo "aaaaaSSSS: ".$scores."<br>";
                            }
                        }
                    }
                }
            }
            // echo "BEFORE LP: ".$scores."<br>";
            $first_official = \Auth::user()->FirstProficiency;
            if(!empty($elg_question) && $elg_question->linked_to_cv == 'yes' && $elg_question->cv_section == 'language_proficiency'){
                if($elg_question->score_count_type == 'range_matching'){
                    foreach($ques_response as $value){
                        if($value['question_id'] == $elg_question->unique_id){
                            $option_selected = $value['option_value'];
                            // echo "Lang Type: ".$elg_question->language_type."<br>";
                            if($elg_question->language_type == 'first_official'){
                                
                                if(!empty($first_official)){
                                    $language_proficiency = LanguageProficiency::where("unique_id",$first_official->proficiency)->first();
                                    // $clb_level = $language_proficiency->ClbLevels;
                                    if(!empty($first_official)){
                                        $language_proficiency = LanguageProficiency::where("unique_id",$first_official->proficiency)->first();
                                        // $clb_level = $language_proficiency->ClbLevels;
                                        $clb_level = LanguageScoreChart::where("language_proficiency_id",$first_official->proficiency)->orderBy("clb_level")->get();
                                       
                                        $lng_scores['reading'] = $first_official->reading;
                                        $lng_scores['writing'] = $first_official->writing;
                                        $lng_scores['listening'] = $first_official->listening;
                                        $lng_scores['speaking'] = $first_official->speaking;
                                        // pre($lng_scores);
                                        if($option_selected != ''){
                                            if(!empty($clb_level)){
                                                $final_match_count = 0;
                                                $next_level_clb = array();
                                                $current_level_clb = array();
                                                $clb_level_arr = $clb_level->toArray();
                                                //  pre($clb_level_arr);
                                                // pre($clb_level->toArray());
                                                // pre($clb_level_arr);
                                                foreach($clb_level as $c_key => $level){
                                                    
                                                    $current_match_count = 0;
                                                    foreach($lng_scores as $lkey => $score){
                                                        // echo $score." >= ".$level->$lkey."<br>";
                                                        if($score >= $level->$lkey){
                                                            $current_match_count++;
                                                        }
                                                    }
                                                    // echo "<br>clb_level: ".$level->clb_level." = ".$current_match_count;
                                                    if($current_match_count >= $final_match_count){
                                                        // echo "<br> > clb_level: ".$level->clb_level;
                                                        $final_match_count = $current_match_count;
                                                        // echo "KEY: ".$c_key."<br>";
                                                        if(isset($clb_level_arr[$c_key+1])){
                                                            $current_level_clb = $level;
                                                            $next_level_clb = array();
                                                            $next_level_clb[] = $clb_level_arr[$c_key+1];
                                                        }else{
                                                            $current_level_clb = array();
                                                            $next_level_clb = array();
                                                        }
                                                    }
                                                }
                                                // echo "CURRENT LEVEL:";
                                                // pre($current_level_clb->toArray());
                                                // echo "NEXT LEVEL:";
                                                // pre($next_level_clb);
        
                                                // echo "<br>final_match_count:".$final_match_count;
                                                // echo "<Br>Next Level:";
                                                $final_match_count = 0;
                                            //   pre($next_level_clb->toArray());
                                                foreach($next_level_clb as $c_key => $level){
                                                    $current_match_count = 0;
                                                    foreach($lng_scores as $lkey => $score){
                                                        if($score >= $level[$lkey]){
                                                            $current_match_count++;
                                                        }
                                                    }
                                                    if($current_match_count >= $final_match_count){
                                                        $final_match_count = $current_match_count;
                                                    }
                                                }
                                            
                                                if(!empty($next_level_clb) && !empty($match_scores)){
                                                    if($final_match_count == 1){
                                                        $scores += $match_scores->one_match;
                                                    }
                                                    if($final_match_count == 2){
                                                        $scores += $match_scores->two_match;
                                                    }
                                                    if($final_match_count == 3){
                                                        $scores += $match_scores->three_match;
                                                    }
                                                }
                                                // echo "AFTER: ".$scores."<BR>";
                                            }
                                        }
                                    }
                                }
                            }
                            $second_official = \Auth::user()->SecondProficiency;
                            if($elg_question->language_type == 'second_official'){
                                
                                if(!empty($second_official)){
                                    $lng_scores['reading'] = $second_official->reading;
                                    $lng_scores['writing'] = $second_official->writing;
                                    $lng_scores['listening'] = $second_official->listening;
                                    $lng_scores['speaking'] = $second_official->speaking;
                                    $language_proficiency = LanguageProficiency::where("unique_id",$second_official->proficiency)->first();
                                    // $clb_level = $language_proficiency->ClbLevels;
                                    $clb_level = LanguageScoreChart::where("language_proficiency_id",$first_official->proficiency)->orderBy("clb_level")->get();
                                    $match_scores = LanguageScorePoints::where("language_proficiency_id",$first_official->proficiency)
                                                    ->where("question_id",$elg_question->unique_id)
                                                    ->first();
                                    
                                    if($option_selected != ''){
                                        if(!empty($clb_level)){
                                            $final_match_count = 0;
                                            $next_level_clb = array();
                                            $current_level_clb = array();
                                            $clb_level_arr = $clb_level->toArray();
                                            //  pre($clb_level_arr);
                                            // pre($clb_level->toArray());
                                            // pre($clb_level_arr);
                                            foreach($clb_level as $c_key => $level){
                                                
                                                $current_match_count = 0;
                                                foreach($lng_scores as $key => $score){
                                                    // echo $score." >= ".$level->$key."<br>";
                                                    if($score >= $level->$key){
                                                        $current_match_count++;
                                                    }
                                                }
                                                // echo "<Br><br>";
                                                // echo "<br>clb_level: ".$level->clb_level." = ".$current_match_count;
                                                if($current_match_count >= $final_match_count){
                                                    // echo "<br> > clb_level: ".$level->clb_level;
                                                    $final_match_count = $current_match_count;
                                                    // echo "KEY: ".$c_key."<br>";
                                                    if(isset($clb_level_arr[$c_key+1])){
                                                        $current_level_clb = $level;
                                                        $next_level_clb = array();
                                                        $next_level_clb[] = $clb_level_arr[$c_key+1];
                                                    }else{
                                                        $current_level_clb = array();
                                                        $next_level_clb = array();
                                                    }
                                                }
                                            }
                                            // echo "CURRENT LEVEL:";
                                            // pre($current_level_clb->toArray());
                                            // echo "NEXT LEVEL:";
                                            // pre($next_level_clb);
        
                                            // echo "<hr><Br><br>";
                                            // echo "<br>final_match_count:".$final_match_count;
                                            // echo "<Br>Next Level:";
                                            $final_match_count = 0;
                                            //   pre($next_level_clb->toArray());
                                            foreach($next_level_clb as $c_key => $level){
                                                $current_match_count = 0;
                                                foreach($lng_scores as $lkey => $score){
                                                    if($score >= $level[$lkey]){
                                                        $current_match_count++;
                                                    }
                                                }
                                                if($current_match_count >= $final_match_count){
                                                    $final_match_count = $current_match_count;
                                                }
                                            }
                                           
                                            if(!empty($next_level_clb) && !empty($match_scores)){
                                                if($final_match_count == 1){
                                                    $scores += $match_scores->one_match;
                                                }
                                                if($final_match_count == 2){
                                                    $scores += $match_scores->two_match;
                                                }
                                                if($final_match_count == 3){
                                                    $scores += $match_scores->three_match;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // echo "<br>final_match_count:".$final_match_count;
        // 
        // exit;
        // echo "Final Score After: <br>";
        // pre($comp_final_score);
        // echo "<br>scores after:".$scores;
        // exit;
        $unique_id = randomNumber();
        $object = new UserEligibilityCheck();
        $object->user_id = \Auth::user()->unique_id;
        $object->unique_id = $unique_id;
        $object->visa_service_id = $visa_service_id;
        $object->response = json_encode($questions);
        $object->score = $scores;
        $object->final_score = json_encode($comp_final_score);
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

        $response['redirect_back'] = baseUrl("eligibility-check/report/".$unique_id);
        $response['html'] = $html;
        return response()->json($response);
    }
    public function saveGroupEligibilityScore2($visa_service_id,Request $request){
        
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
       
        // foreach($questions as $groups){
        //     foreach($groups as $ques){
        //         foreach($ques as $key => $value){
        //             $question = EligibilityQuestions::where("unique_id",$key)->first();
        //             $option = $question->optionScore($value,"value",$key);
        //             if(!empty($option)){       
        //                 $score += $option->score;
        //                 $option_ids[] = $option->id;
        //                 $question_score[$option->question_id] = $option->score;
        //                 $question_ids[] = $option->question_id;
        //             }
        //         }
        //     }
        // }
        // echo "<h1>Step 1: ".$score."</h1>";
        
        // Step 2 
        // echo "<h1>Step 2:</h1>";
        // Combination Score 1
        // pre($question_score);
        $question_combinations = QuestionCombination::where("visa_service_id",$visa_service_id)->get();
        $comp_score = array();
        // foreach($question_combinations as $combination){
        //     $flag = 0;
        //     if(in_array($combination->option_id_one,$option_ids) && in_array($combination->option_id_two,$option_ids)){
        //         $component = ComponentQuestions::with('Questions')->where("unique_id",$combination->component_id)->first();
        //         $component_max_score = $component->max_score;
        //         $com_ques_score = 0;
        //         foreach($component->Questions as $ques){
        //             // pre($ques->toArray());
        //             // echo "QUES: ".$ques->EligibilityQuestion->unique_id."<br>";
        //             if(isset($question_score[$ques->EligibilityQuestion->unique_id])){
        //                 $com_ques_score += $question_score[$ques->EligibilityQuestion->unique_id];
        //             }
        //         }
        //         echo "<h1> COMP QUES SCORE: ".$com_ques_score."</h1>";
        //         echo "<h1> COMP MAX SCORE: ".$component_max_score."</h1>";
                
        //         if($combination->behaviour == 'add'){
        //             $com_ques_score += $combination->score;
        //         }
        //         if($combination->behaviour == 'substract'){
        //             $com_ques_score -= $combination->score;
        //         }
        //         if($combination->behaviour == 'overwrite'){
        //             $optids = array($combination->option_id_one,$combination->option_id_two);
        //             $opt_sum = QuestionOptions::whereIn("id",$optids)->sum("score");
        //             $divide = $opt_sum/2;
        //             $question_score[$combination->question_id_one] = $divide;
        //             $question_score[$combination->question_id_two] = $divide;
        //             $com_ques_score -= $opt_sum;
        //             $com_ques_score += $combination->score;
        //         }
        //          echo "<h1> COMP AFT SCORE: ".$com_ques_score."</h1>";
        //         if($com_ques_score < $component_max_score){
        //             if(!isset($comp_score[$combination->component_id])){
        //                 $comp_score[$combination->component_id][] = $com_ques_score;
        //             }else{
        //                 $comp_score[$combination->component_id][] = $com_ques_score;
        //             }
        //         }else{
        //             $diff = $com_ques_score - $component_max_score;
        //             $com_ques_score = $com_ques_score - $diff;
        //             $comp_score[$combination->component_id][] = $com_ques_score;
        //         }
        //         echo "<h1> COMP FINAL SCORE: ".$com_ques_score."</h1>";
               
        //     }
        //     echo "<Hr>";
        // }
        // echo "<h1> ORG SCORE: ".$score."</h1>";
        // pre($comp_score);
        // exit;
        // $question_combinations = QuestionCombination::where("visa_service_id",$visa_service_id)->get();
        // foreach($question_combinations as $combination){
        //     $flag = 0;
        //     if(in_array($combination->option_id_one,$option_ids) && in_array($combination->option_id_two,$option_ids)){
        //         // pre($combination->toArray());
        //         $checkComponentQ1 = ComponentQuestionIds::with('Component')->where("question_id",$combination->question_id_one)->get();
        //         // if(!empty($checkComponentQ1)){
        //         //     echo "Q1:";
        //         //     pre($checkComponentQ1->toArray());
        //         // }
        //          $checkComponentQ2 = ComponentQuestionIds::with('Component')->where("question_id",$combination->question_id_two)->get();
        //         // if(!empty($checkComponentQ2)){
        //         //     echo "Q2:";
        //         //     // pre($checkComponentQ2->toArray());
        //         // }
        //         $comp_max_score = array();
        //         foreach($checkComponentQ1 as $q1){
        //             foreach($checkComponentQ2 as $q2){
        //                 if($q1->component_id == $q2->component_id){
        //                     $comp_group = GroupComponentIds::with('QuestionsGroups')
        //                                     ->where("component_id",$q2->component_id)
        //                                     ->whereHas("QuestionsGroups",function($query){
        //                                         $query->where("is_default",0);
        //                                     })
        //                                     ->first();
        //                     // $comp_max_score[] = $q2->Component->max_score;   
                            
        //                     if(!empty($comp_group)){
        //                         // pre($comp_group->toArray());
        //                         if($comp_group->QuestionsGroups->max_score > $q2->Component->max_score){
        //                             $comp_max_score[] = $q2->Component->max_score;        
        //                         }else{
        //                             $comp_max_score[] = $comp_group->QuestionsGroups->max_score;        
        //                         }
        //                     }else{
        //                         $comp_max_score[] = $q2->Component->max_score;        
        //                     }
                            
        //                 }
        //             }
        //         }
        //         $lowest_score= min($comp_max_score);

        //         // echo "LS: ";
        //         // pre($lowest_score);
        //         // echo "comp_max_score";
        //         // pre($comp_max_score);
                
        //         if($combination->behaviour == 'add'){
        //             // echo "CSS: ".$combination->score;
        //             // echo "<Br>SCR B4: ".$score;
        //             if($combination->score < $lowest_score){
        //                 $score += $combination->score;
        //             }
        //             // echo "<Br>SCR AFT: ".$score;
        //         }
        //         if($combination->behaviour == 'substract'){
        //             $score -= $combination->score;
        //         }
        //         if($combination->behaviour == 'overwrite'){
        //             if($combination->score < $lowest_score){
        //                 $optids = array($combination->option_id_one,$combination->option_id_two);
        //                 $opt_sum = QuestionOptions::whereIn("id",$optids)->sum("score");
        //                 $divide = $opt_sum/2;
        //                 $question_score[$combination->question_id_one] = $divide;
        //                 $question_score[$combination->question_id_two] = $divide;
        //                 $score -= $opt_sum;
        //                 $score += $combination->score;
        //             }
        //         }
        //     }
        // }
        // echo "<h1>Step 2: ".$score."</h1>";
        
        
        // Component
        
        
        
        $question_components = ComponentQuestions::with('Questions')
                                ->where("visa_service_id",$visa_service_id)
                                ->get();
        $combination_score = array();
        // pre($question_combinations);
        $score2 = 0;
        foreach($question_components as $combination){
            if($combination->is_default != 1){
                $comb_ques = $combination->Questions;
                // pre($combination->toArray());
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
                    // echo "<br>before check_score: ".$check_score;
                    // echo "<Hr><br>";
                    if($check_score > $combination->max_score){
                        
                        $difference = $check_score - $combination->max_score;
                        $check_score = $difference;
                        // echo "<br>Difference: ".$difference;
                        $score -= $difference;
                        echo "DFF: ".$score."<br>";
                    }
                    $combination_score[$combination->unique_id] = $check_score;
                    // echo "<br>check score: ".$check_score;
                    // echo "<br>after score: ".$score;
                }
            }
            // echo "check_score: ".$check_score."<Br>";
            // echo "ques_exists: ".$ques_exists."<Br>";
            
        }
        // echo "<h1>Step 3: ".$score."</h1>";
        
        // pre($combination_score);
        $question_groups = QuestionsGroups::with(['Components'])->where("visa_service_id",$visa_service_id)->get();
        // pre($question_groups->toArray());
        foreach($question_groups as $group){
            if($group->is_default != 1){
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
                echo  "<Br>group_score ::".$group_score;
                echo  "<Br>group_max_score ::".$group->max_score;
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
        }
        // echo "<h1>Step 4: ".$score."</h1>";
        // exit;
        $unique_id = randomNumber();
        $object = new UserEligibilityCheck();
        $object->user_id = \Auth::user()->unique_id;
        $object->unique_id = $unique_id;
        $object->response = json_encode($questions);
        $object->score = $score;
        $object->eligible_type = "group";
        $object->save();
        // pre($question_score);

        $response['status'] = true;
        $response['score'] = $score;
        $response['redirect_back'] = baseUrl("eligibility-check/report/".$unique_id);
        
        return response()->json($response);
    }


    public function downloadReport($id){
        $id = base64_decode($id);
        $report = UserEligibilityCheck::where("id",$id)->first();
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
        $pdf_doc = \PDF::loadView(roleFolder().'.eligibility-check.group-report', $viewData);
        return $pdf_doc->download('report.pdf');
    }

    public function checkPreCondition(Request $request){
        $option_id = $request->input("option_id");
        $question_id = $request->input("question_id");
        $option = QuestionOptions::where("option_value",$option_id)->where("question_id",$question_id)->first();
        $component = ComponentPreConditions::where("question_id",$question_id)->where("option_id",$option->id)->first();
        if(!empty($component)){
            $response['status'] = true;
            $response['component_id'] = $component->component_id;
        }else{
            $response['status'] = false;
        }

        return response()->json($response);
    }

    public function userEligibilityHistory()
    {
        $visa_services = VisaServices::get();
        $viewData['pageTitle'] ="Visa Groups";
        $viewData['activeTab'] = "eligibility-check";
        $program_types = ProgramTypes::get();
        $viewData['program_types'] = $program_types;
        return view(roleFolder().'.eligibility-check.eligibility-history',$viewData);
    } 

    public function eligibilityAjaxHistory(Request $request)
    {   
        $search = $request->input("search");
        $records = UserEligibilityCheck::where("user_id",\Auth::user()->unique_id)
                            ->whereHas("VisaService")
                            ->orderBy('id',"desc")
                            ->paginate();
        
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.eligibility-check.history-ajax-lists',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
}
