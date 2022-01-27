<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\VisaServices;
use App\Models\EligibilityQuestions;
use App\Models\QuestionOptions;
use App\Models\ComponentQuestions;
use App\Models\ComponentQuestionIds;
use App\Models\ConditionalQuestions;
use App\Models\ArrangeQuestions;
use App\Models\ArrangeGroups;
use App\Models\QuestionsGroups;
use App\Models\GroupQuestionIds;
use App\Models\GroupComponentIds;
use App\Models\QuestionCombination;
use App\Models\GroupConditionalQuestions;
use App\Models\PrimaryDegree;
use App\Models\LanguageProficiency;
use App\Models\EligibilityPattern;
use App\Models\CombinationalOptions;
use App\Models\LanguageScorePoints;
use App\Models\ComponentPreConditions;
use App\Models\MultipleOptionsGroups;

class EligibilityQuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function list($visa_service_id)
    {
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Eligibility Questions";
        return view(roleFolder().'.eligibility-questions.lists',$viewData);
    } 

    public function getAjaxList($visa_service_id,Request $request)
    {   
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        
        $keyword = $request->input("search");
        $records = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->where(function($query) use($keyword){
                                if($keyword != ''){
                                    $query->where("question","LIKE",$keyword."%");
                                }
                            })
                            ->orderBy('id',"desc")
                            ->paginate();
        
        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $viewData['visa_service'] = $visa_service;
        $view = View::make(roleFolder().'.eligibility-questions.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;
        $viewData['pageTitle'] = "Add Questions";
        $this->defaultComponent($visa_service->unique_id);
        $components = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                        ->where('is_default','0')
                                        ->get();
        $viewData['components'] = $components;
        $language_proficiencies = LanguageProficiency::get();
        $viewData['language_proficiencies'] = $language_proficiencies; 
        return view(roleFolder().'.eligibility-questions.add',$viewData);
    }

    public function save($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'option_type'=> 'required',
            'linked_to_cv'=> 'required',
            'options'=> 'required',
        ]);
        
        
        
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        // pre($request->all());
        
        $options = $request->options;

        
       
        $visa_service = VisaServices::where("id",$id)->first();
        $unique_id = randomNumber();
        $object =  new EligibilityQuestions();
        $object->unique_id = $unique_id;
        $object->visa_service_id = $visa_service->unique_id;
        $object->question = $request->input("question");
        $object->option_type = $request->input("option_type");
        $object->linked_to_cv = $request->input("linked_to_cv");
        $object->response_comment = $request->input("response_comment");
        $object->additional_notes = $request->input("additional_notes");
        if($request->input("linked_to_cv") == 'yes'){
            $object->cv_section = $request->input("cv_section");
        }
        if($request->input("language_proficiency")){
            $object->language_proficiency = $request->input("language_proficiency");
        }
        if($request->input("language_type")){
            $object->language_type = $request->input("language_type");
        }
        if($request->input("score_count_type")){
            $object->score_count_type = $request->input("score_count_type");
        }else{
            $object->score_count_type = '';
        }
        if($request->input("score_count_type") == 'range_matching'){
            if($request->input("one_match")){
                $object->one_match = $request->input("one_match");
            }else{
                $object->one_match = '';
            }

            if($request->input("two_match")){
                $object->two_match = $request->input("two_match");
            }else{
                $object->two_match = '';
            }

            if($request->input("three_match")){
                $object->three_match = $request->input("three_match");
            }else{
                $object->three_match = '';
            }
        }else{
            $object->one_match = '';
            $object->two_match = '';
            $object->three_match = '';
        }

        $object->added_by = \Auth::user()->unique_id;
        $object->save();

        foreach($options as $option){
            $obj = new QuestionOptions();
            $obj->question_id = $unique_id;
            $obj->option_label = $option['option_label'];
            $obj->option_value = $option['option_value'];
            if(isset($option['criteria'])){
                $obj->criteria = $option['criteria'];
            }
            $obj->score = $option['score'];
            if(isset($option['non_eligible'])){
                $obj->non_eligible = 1;
                $obj->non_eligible_reason = $option['non_eligible_reason'];
            }else{
                $obj->non_eligible = 0;
                $obj->non_eligible_reason = '';
            }
            if(isset($option['language_proficiency_id']) && $option['language_proficiency_id'] != ''){
                $obj->language_proficiency_id = $option['language_proficiency_id'];
            }
            if(isset($option['image'])){
                $file = $option['image'];
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $newName        = mt_rand(1,99999)."-".$fileName;
                $source_url = $file->getPathName();
                
                $destinationPath = public_path('/uploads/images/');
                $file->move($destinationPath, $newName);

                $obj->image = $newName;
            }
            $obj->save();
        }
        
        if($request->input("match_score")){
            $match_scores = $request->input("match_score");
            foreach($match_scores as $lang_prof_id => $lang_prof){
                $object_lang_prof = new LanguageScorePoints();
                $object_lang_prof->language_proficiency_id = $lang_prof_id;
                $object_lang_prof->question_id = $unique_id;
                foreach($lang_prof as $key => $score){     
                    $object_lang_prof->$key = $score;                                  
                }
                $object_lang_prof->save();
            }
        }
        if($request->input("components")){
            $components[] = $request->input("components");
            foreach($components as $component){
            
                $lastCount = ComponentQuestionIds::where("visa_service_id",$visa_service->unique_id)
                                    ->orderBy("sort_order","desc")
                                    ->first();
                if(!empty($lastCount)){
                    $new_count = $lastCount->sort_order+1;
                }else{
                    $new_count = 1;
                }
                $obj = new ComponentQuestionIds();
                $obj->question_id = $unique_id;
                $obj->component_id = $component;
                $obj->sort_order = $new_count;
                $obj->save();
            }
            
        }else{
            
            $default_component =  ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    ->where("is_default",1)
                                                    ->first();
            $obj = new ComponentQuestionIds();
            $obj->question_id = $unique_id;
            $obj->component_id = $default_component->unique_id;
            $obj->sort_order = 1;
            $obj->save();
            $lastCount = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                                  ->orderBy("sort_order","desc")
                                  ->first();
            if(!empty($lastCount)){
                $new_count = $lastCount->sort_order+1;
            }else{
                $new_count = 1;
            }
            $object = new ArrangeQuestions();
            $object->visa_service_id = $visa_service->unique_id;
            $object->question_id = $unique_id;
            $object->sort_order = $new_count;
            $object->save();
        }
        
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.$visa_service_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function edit($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);

        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = EligibilityQuestions::find($id);
        $language_proficiencies = LanguageProficiency::get();
        $viewData['language_proficiencies'] = $language_proficiencies; 
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Question";
        $this->defaultComponent($visa_service->unique_id);
        $components = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                        ->where('is_default','0')
                                        ->get();
        $component_ids = ComponentQuestionIds::where("question_id",$record->unique_id)->pluck("component_id");
        if(!empty($component_ids)){
            $component_ids = $component_ids->toArray();
        }else{
            $component_ids = array();
        }
        
        $viewData['components'] = $components;
        $viewData['component_ids'] = $component_ids;
        return view(roleFolder().'.eligibility-questions.edit',$viewData);
    }

    public function update($visa_service_id,$id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'option_type'=> 'required',
            'linked_to_cv'=> 'required',
            'options'=> 'required',
        ]);
        
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        
        $object =  EligibilityQuestions::find($id);
        $unique_id = $object->unique_id;
        $object->visa_service_id = $visa_service->unique_id;
        $object->question = $request->input("question");
        $object->option_type = $request->input("option_type");
        $object->linked_to_cv = $request->input("linked_to_cv");
        $object->response_comment = $request->input("response_comment");
        $object->additional_notes = $request->input("additional_notes");
        if($request->input("linked_to_cv") == 'yes'){
            $object->cv_section = $request->input("cv_section");
        }else{
            $object->cv_section = '';
        }
        if($request->input("language_proficiency")){
            $object->language_proficiency = $request->input("language_proficiency");
        }else{
            $object->language_proficiency = '';
        }

        if($request->input("language_type")){
            $object->language_type = $request->input("language_type");
        }else{
            $object->language_type = '';
        }

        if($request->input("score_count_type")){
            $object->score_count_type = $request->input("score_count_type");
        }else{
            $object->score_count_type = '';
        }
        if($request->input("score_count_type") == 'range_matching'){
            if($request->input("one_match")){
                $object->one_match = $request->input("one_match");
            }else{
                $object->one_match = '';
            }

            if($request->input("two_match")){
                $object->two_match = $request->input("two_match");
            }else{
                $object->two_match = '';
            }

            if($request->input("three_match")){
                $object->three_match = $request->input("three_match");
            }else{
                $object->three_match = '';
            }
        }else{
            $object->one_match = '';
            $object->two_match = '';
            $object->three_match = '';
        }

        $object->save();
        $option_ids = array();
        $options = $request->options;
       
        foreach($options as $option){
           
            if($option['id'] == '0'){
                $obj = new QuestionOptions();
            }else{
                $obj = QuestionOptions::find(base64_decode($option['id']));
            }
            $obj->question_id = $unique_id;
            $obj->option_label = $option['option_label'];
            $obj->option_value = $option['option_value'];
            if(isset($option['language_proficiency_id']) && $option['language_proficiency_id'] != ''){
                $obj->language_proficiency_id = $option['language_proficiency_id'];
            }
            if(isset($option['criteria'])){
                $obj->criteria = $option['criteria'];
            }
            $obj->score = $option['score'];
            if(isset($option['non_eligible'])){
                $obj->non_eligible = 1;
                $obj->non_eligible_reason = $option['non_eligible_reason'];
            }else{
                $obj->non_eligible = 0;
                $obj->non_eligible_reason = '';
            }
            if(isset($option['image'])){
                $file = $option['image'];
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $newName        = mt_rand(1,99999)."-".$fileName;
                $source_url = $file->getPathName();
                
                $destinationPath = public_path('/uploads/images/');
                $file->move($destinationPath, $newName);

                $obj->image = $newName;
            }
            $obj->save();
            $option_ids[] = $obj->id;
        }
        $ques_opt = QuestionOptions::where('question_id',$unique_id)
                ->whereNotNull('image')
                ->whereNotIn("id",$option_ids)
                ->get();
        foreach($ques_opt as $opt){
            if(file_exists(public_path("/uploads/images/".$opt->image))){
                unlink(public_path("/uploads/images/".$opt->image));
            }
        }
        $opt_ids = QuestionOptions::where('question_id',$unique_id)
                    ->whereNotIn("id",$option_ids)
                    ->pluck('id');
       
        if(!empty($opt_ids)){
            $opt_ids = $opt_ids->toArray();
            for($i=0;$i < count($opt_ids);$i++){
                QuestionOptions::deleteRecord($opt_ids[$i]);
            }
        }
        if($request->input("match_score")){
            $match_scores = $request->input("match_score");
            LanguageScorePoints::where("question_id",$unique_id)->delete();
            foreach($match_scores as $lang_prof_id => $lang_prof){
                $object_lang_prof = new LanguageScorePoints();
                $object_lang_prof->language_proficiency_id = $lang_prof_id;
                $object_lang_prof->question_id = $unique_id;
                foreach($lang_prof as $key => $score){     
                    $object_lang_prof->$key = $score;                                  
                }
                $object_lang_prof->save();
            }
        }
        
                    
        if($request->input("components")){
            $components[] = $request->input("components");
            foreach($components as $component){
            
                $lastCount = ComponentQuestionIds::where("component_id",$component)
                                    ->orderBy("sort_order","desc")
                                    ->first();
                if(!empty($lastCount)){
                    $new_count = $lastCount->sort_order+1;
                }else{
                    $new_count = 1;
                }
                $check_comp = ComponentQuestionIds::where("question_id",$unique_id)->where("component_id",$component)->first();
                if(empty($check_comp)){
                    $obj = new ComponentQuestionIds();
                    $obj->question_id = $unique_id;
                    $obj->component_id = $component;
                    $obj->sort_order = $new_count;
                    $obj->save();
                    $comp_ques_ids[] = $obj->id;
                }else{
                    $comp_ques_ids[] = $check_comp->id;
                }
            }
            ComponentQuestionIds::where('question_id',$unique_id)
                                ->whereNotIn("id",$comp_ques_ids)
                                ->delete();
            
            ArrangeQuestions::where('question_id',$unique_id)->delete();

        }else{
            
            ComponentQuestionIds::where('question_id',$unique_id)->delete();
            $default_component =  ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    ->where("is_default",1)
                                                    ->first();
            $obj = new ComponentQuestionIds();
            $obj->question_id = $unique_id;
            $obj->component_id = $default_component->unique_id;
            $obj->sort_order = 1;
            $obj->save();

            $checkCount = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->where("question_id",$unique_id)
                            ->count();
            if($checkCount == 0){
                $lastCount = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                                    ->orderBy("sort_order","desc")
                                    ->first();
                if(!empty($lastCount)){
                    $new_count = $lastCount->sort_order+1;
                }else{
                    $new_count = 1;
                }
                $object = new ArrangeQuestions();
                $object->visa_service_id = $visa_service->unique_id;
                $object->question_id = $unique_id;
                $object->sort_order = $new_count;
                $object->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service_id));
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($visa_service_id,$id){
        $id = base64_decode($id);
        EligibilityQuestions::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            EligibilityQuestions::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    // Component Questions

    public function componentQuestions($visa_service_id)
    {
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Component Questions";
        return view(roleFolder().'.component-questions.lists',$viewData);
    } 

    public function getComponentAjaxList($visa_service_id,Request $request)
    {   
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        
       
        $records = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->orderBy('id',"desc")
                            ->paginate();
        
        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $view = View::make(roleFolder().'.component-questions.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addComponent($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $this->defaultGroup($visa_service->unique_id);
      
        $viewData['visa_service'] = $visa_service;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                                // ->doesntHave("ComponentQuestions")
                                                ->get();
        $viewData['pageTitle'] = "Add Component";
        $groups = QuestionsGroups::where("visa_service_id",$visa_service->unique_id)->where("is_default",0)->get();
        $viewData['groups'] = $groups;
        return view(roleFolder().'.component-questions.add',$viewData);
    }

    public function saveComponent($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
            'component_title' => 'required',
            'questions'=> 'required',
            'min_score'=> 'required',
            'max_score'=> 'required',
        ]);
        
        
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $options = $request->options;
       
        $visa_service = VisaServices::where("id",$id)->first();
        $unique_id = randomNumber();
        $object =  new ComponentQuestions();
        $object->unique_id = $unique_id;
        $object->visa_service_id = $visa_service->unique_id;
        $object->component_title = $request->input("component_title");
        if($request->input("show_in_question")){
            $object->show_in_question = $request->input("show_in_question");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->min_score = $request->input("min_score");
        $object->max_score = $request->input("max_score");
        $object->added_by = \Auth::user()->unique_id;
        $object->save();
        $questions = $request->questions;
        foreach($questions as $question){
            $obj = new ComponentQuestionIds();
            $obj->component_id = $unique_id;
            $obj->visa_service_id = $visa_service->unique_id;
            $obj->question_id = $question;
            $obj->save();

            ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->where("question_id",$question)
                            ->delete();
        }
        if($request->input("group")){
            $group_id = $request->input("group");
            $obj = new GroupComponentIds();
            $obj->component_id = $unique_id;
            $obj->group_id = $group_id;
            $obj->save();
        }else{
            $default_group =  QuestionsGroups::where("visa_service_id",$visa_service->unique_id)
                ->where("is_default",1)
                ->first();
            $obj = new GroupComponentIds();
            $obj->component_id = $unique_id;
            $obj->group_id = $default_group->unique_id;
            $obj->save();
        }
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/component-questions/'.$visa_service_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function editComponent($visa_service_id,$id){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $record = ComponentQuestions::with('Questions')->where("id",$id)
                                    ->whereHas('Questions')
                                    ->first();
        $this->defaultGroup($visa_service->unique_id);
        $question_ids = $record->Questions->pluck("question_id")->toArray();
        $group_ids = $record->GroupComponents->pluck("group_id")->toArray();
        
        $viewData['question_ids'] = $question_ids;
        $viewData['group_ids'] = $group_ids;
        $viewData['record'] = $record;
        $viewData['visa_service'] = $visa_service;
        $elg_questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    // ->doesntHave("ComponentQuestions")
                                                    ->pluck('unique_id');
        if(!empty($elg_questions)){
            $qids = $elg_questions->toArray();
        }else{
            $qids = array();
        }
        $all_quids = array_merge($question_ids,$qids);
        $questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    ->whereIn("unique_id",$all_quids)
                                                    ->get();
        $viewData['questions'] = $questions;
        $viewData['pageTitle'] = "Edit Component";
        $groups = QuestionsGroups::where("visa_service_id",$visa_service->unique_id)->where("is_default",0)->get();
        $viewData['groups'] = $groups;
        return view(roleFolder().'.component-questions.edit',$viewData);
    }

    public function updateComponent($visa_service_id,$id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $validator = Validator::make($request->all(), [
            'component_title' => 'required',
            'questions'=> 'required',
            'min_score'=> 'required',
            'max_score'=> 'required',
        ]);
        
        
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $options = $request->options;
       
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $unique_id = randomNumber();
        $object =  ComponentQuestions::find($id);
        $unique_id = $object->unique_id;
        $object->visa_service_id = $visa_service->unique_id;
        $object->component_title = $request->input("component_title");
        if($request->input("show_in_question")){
            $object->show_in_question = $request->input("show_in_question");
        }else{
            $object->show_in_question = 0;
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }else{
            $object->description = '';
        }
        $object->min_score = $request->input("min_score");
        $object->max_score = $request->input("max_score");
        $object->added_by = \Auth::user()->unique_id;
        $object->save();
        $questions = $request->questions;
        $ques_ids = array();
        foreach($questions as $key => $question){
            $check = ComponentQuestionIds::where("component_id",$unique_id)->where("question_id",$question)->first();
            if(empty($check)){
                $obj = new ComponentQuestionIds();
            }else{
                $obj = ComponentQuestionIds::find($check->id);
            }
            ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->where("question_id",$question)
                            ->delete();
            $obj->sort_order = $key + 1;
            $obj->visa_service_id = $visa_service->unique_id;
            $obj->component_id = $unique_id;
            $obj->question_id = $question;
            $obj->save();
            $ques_ids[] = $obj->id;
            
        }
        ComponentQuestionIds::whereNotIn("id",$ques_ids)->where("component_id",$unique_id)->delete();
        

        if($request->input("group")){
            $group_id = $request->input("group");
            $checkGroup = GroupComponentIds::where("component_id",$unique_id)->first();
            if(!empty($checkGroup)){
                $obj = GroupComponentIds::find($checkGroup->id);
            }else{
                $obj = new GroupComponentIds();
            }
            
            $obj->component_id = $unique_id;
            $obj->group_id = $group_id;
            $obj->save();
        }else{
            $default_group =  QuestionsGroups::where("visa_service_id",$visa_service->unique_id)
                ->where("is_default",1)
                ->first();
            $checkGroup = GroupComponentIds::where("component_id",$unique_id)->first();
            if(!empty($checkGroup)){
                $obj = GroupComponentIds::find($checkGroup->id);
            }else{
                $obj = new GroupComponentIds();
            }
            $obj->group_id = $default_group->unique_id;
            $obj->save();
        }

        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/component-questions/'.base64_encode($visa_service_id));
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function deleteSingleComponent($visa_service_id,$id){
        $id = base64_decode($id);
        ComponentQuestions::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultipleComponent($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            ComponentQuestions::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function setCondition($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $id = base64_decode($id);
        $record = EligibilityQuestions::find($id);
        $questions = EligibilityQuestions::where("id","!=",$id)
                                ->where('visa_service_id',$visa_service->unique_id)
                                ->doesntHave('ComponentQuestions')
                                ->doesntHave("ConditionalQuestions")
                                ->get();
        $viewData['questions'] = $questions;
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $components = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                        ->whereHas("Questions",function($query) use($record){
                                            $query->where("question_id","!=",$record->unqiue_id);
                                        })
                                        ->get();
        $conditionalComponents = ConditionalQuestions::where("question_id",$record->unique_id)->where('component_id','!=',0)->pluck("component_id","option_id");
        $conditionalQuestions = ConditionalQuestions::where("question_id",$record->unique_id)->where('conditional_question_id','!=',0)->pluck("conditional_question_id","option_id");
        if(!empty($conditionalComponents)){
            $viewData['conditionalComponents'] = $conditionalComponents->toArray();
        }
        if(!empty($conditionalQuestions)){
            $viewData['conditionalQuestions'] = $conditionalQuestions->toArray();
        }
        $viewData['components'] = $components;
        
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Set Condition";
        
        return view(roleFolder().'.eligibility-questions.set-conditions',$viewData);
    }

    public function saveCondition($visa_service_id,$id,Request $request){
        $visa_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $components = array();
        $questions = array();
        if($request->input("component")){
            $components = $request->component;
        }
        if($request->input("question")){
            $questions = $request->question;
        }
        
        ConditionalQuestions::where("question_id",$request->input('question_id'))->delete();
        foreach($components as $key => $value){
            $object = new ConditionalQuestions();
            $object->question_id = $request->input("question_id");
            $object->option_id = $key;
            $object->component_id = $value;
            // $object->condition_type = 'normal';
            $object->added_by = \Auth::user()->unique_id;
            $object->save();
 
        }

        foreach($questions as $key => $value){
            $object = new ConditionalQuestions();
            $object->question_id = $request->input("question_id");
            $object->option_id = $key;
            $object->conditional_question_id = $value;
            $object->added_by = \Auth::user()->unique_id;
            $object->save();
            ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->where("question_id",$value)
                            ->delete();
        }

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.$visa_service_id);
        $response['message'] = "Condition added successfully";
        
        return response()->json($response);
    }

    public function arrangeQuestions($visa_service_id){
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $default_component = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                            ->where("is_default",1)
                                            ->first();
        $records = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                    ->whereHas("ComponentQuestionIds",function($query) use($default_component){
                                        $query->where("component_id",$default_component->unique_id);
                                    })
                                    ->doesntHave("ConditionalQuestions")
                                    ->doesntHave("ArrangeQuestions")
                                    ->get();
        
        if(!empty($records)){
            foreach($records as $record){
                $checkCount = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                            ->where("question_id",$record->unique_id)
                            ->count();
                if($checkCount == 0){
                    $lastCount = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)
                                ->where("question_id",$record->unique_id)
                                ->orderBy("sort_order","desc")
                                ->first();
                    if(!empty($lastCount)){
                        $new_count = $lastCount->sort_order+1;
                    }else{
                        $new_count = 1;
                    }
                    $object = new ArrangeQuestions();
                    $object->visa_service_id = $visa_service->unique_id;
                    $object->question_id = $record->unique_id;
                    $object->sort_order = $new_count;
                    $object->save();
                }
            }
        }
        $question_sequence = ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['pageTitle'] = "Arrange Questions";
        
        return view(roleFolder().'.eligibility-questions.arrange-questions',$viewData);
    }

    public function saveArrangedQuestions($visa_service_id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        ArrangeQuestions::where("visa_service_id",$visa_service->unique_id)->delete();
        $questions = $request->question_id;
        
        for($i=0;$i < count($questions);$i++){
            $object = new ArrangeQuestions();
            $object->visa_service_id = $visa_service->unique_id;
            $object->question_id = $questions[$i];
            $object->sort_order = $i+1;
            $object->save();
        }
        $response['status'] = true;
        $response['message'] = "Question rearranged successfully";
        return response()->json($response);
    }


    public function arrangeGroups($visa_service_id){
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $default_component = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                            ->where("is_default",1)
                                            ->first();
        $records = QuestionsGroups::where("visa_service_id",$visa_service->unique_id)
                                    ->doesntHave("ArrangeGroups")
                                    ->get();
        
        if(!empty($records)){
            foreach($records as $record){
                $checkCount = ArrangeGroups::where("visa_service_id",$visa_service->unique_id)
                            ->where("group_id",$record->unique_id)
                            ->count();
                if($checkCount == 0){
                    $lastCount = ArrangeGroups::where("visa_service_id",$visa_service->unique_id)
                                ->where("group_id",$record->unique_id)
                                ->orderBy("sort_order","desc")
                                ->first();
                    if(!empty($lastCount)){
                        $new_count = $lastCount->sort_order+1;
                    }else{
                        $new_count = 1;
                    }
                    $object = new ArrangeGroups();
                    $object->visa_service_id = $visa_service->unique_id;
                    $object->group_id = $record->unique_id;
                    $object->sort_order = $new_count;
                    $object->save();
                }
            }
        }
        $question_sequence = ArrangeGroups::where("visa_service_id",$visa_service->unique_id)
                                        ->whereHas("Group")
                                        ->orderBy('sort_order','asc')
                                        ->get();
        $viewData['question_sequence'] = $question_sequence;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['pageTitle'] = "Arrange Groups";
        
        return view(roleFolder().'.eligibility-questions.arrange-groups',$viewData);
    }

    public function saveArrangedGroups($visa_service_id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        ArrangeGroups::where("visa_service_id",$visa_service->unique_id)->delete();
        $groups = $request->group_id;
        
        for($i=0;$i < count($groups);$i++){
            $object = new ArrangeGroups();
            $object->visa_service_id = $visa_service->unique_id;
            $object->group_id = $groups[$i];
            $object->sort_order = $i+1;
            $object->save();
        }
        $response['status'] = true;
        $response['message'] = "Group rearranged successfully";
        return response()->json($response);
    }

    // QuestionsGroups
    
    public function groupsQuestions($visa_service_id)
    {
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Group Questions";
        return view(roleFolder().'.groups-questions.lists',$viewData);
    } 

    public function groupsQuestionsAjaxList($visa_service_id,Request $request)
    {   
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        
       
        $records = QuestionsGroups::where("visa_service_id",$visa_service->unique_id)
                            ->orderBy('id',"desc")
                            ->paginate();
        
        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $view = View::make(roleFolder().'.groups-questions.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addGroupQuestions($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    ->doesntHave('GroupQuestions')
                                                    ->doesntHave('ComponentQuestions')
                                                    ->get();
        $viewData['components'] = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    ->doesntHave('GroupComponents')
                                                    ->get();
                                                    
        $viewData['pageTitle'] = "Add Group Questions";
        $viewData['visa_service_id'] = $visa_service_id;
        return view(roleFolder().'.groups-questions.add',$viewData);
    }

    public function saveGroupQuestions($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
            'group_title' => 'required',
            'min_score'=> 'required',
            'max_score'=> 'required',
            'components'=> 'required',
        ]);
        
        // if(!$request->input("components")){
        //     $response['status'] = false;
        //     $response['error_type'] = 'no_component_question';
        //     $response['message'] = "Component is required!";
        //     return response()->json($response);
        // }
        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $visa_service = VisaServices::where("id",$id)->first();
        $unique_id = randomNumber();
        $last_group = QuestionsGroups::where("visa_service_id",$visa_service->unique_id)->orderBy('sort_order','desc')->first();
        $object =  new QuestionsGroups();
        $object->unique_id = $unique_id;
        $object->visa_service_id = $visa_service->unique_id;
        $object->group_title = $request->input("group_title");
        if($request->input("description")){
            $object->description = $request->input("description");
        }else{
            $object->description = '';
        }
        if(!empty($last_group)){
            $object->sort_order = $last_group->sort_order + 1;
        }else{
            $object->sort_order = 1;
        }
        $object->min_score = $request->input("min_score");
        $object->max_score = $request->input("max_score");
        $object->added_by = \Auth::user()->unique_id;
        $object->save();
        // if($request->input("questions")){
        //     $questions = $request->questions;
        //     foreach($questions as $question){
        //         $obj = new GroupQuestionIds();
        //         $obj->group_id = $unique_id;
        //         $obj->question_id = $question;
        //         $obj->save();
        //     }
        // }
        if($request->input("components")){
            $components = $request->components;
            foreach($components as $component){
                $obj = new GroupComponentIds();
                $obj->group_id = $unique_id;
                $obj->component_id = $component;
                $obj->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function editGroupQuestions($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = QuestionsGroups::with('Questions')->where("id",$id)->first();
        $question_ids = $record->Questions->pluck("question_id");
        if(!empty($question_ids)){
            $question_ids = $question_ids->toArray();
        }else{
            $question_ids = array();
        }
        $component_ids = $record->Components->pluck("component_id");
        if(!empty($component_ids)){
            $component_ids = $component_ids->toArray();
        }else{
            $component_ids = array();
        }
        $viewData['record'] = $record;
        $viewData['question_ids'] = $question_ids;
        $viewData['component_ids'] = $component_ids;
        $viewData['visa_service'] = $visa_service;
        $elg_questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                            // ->doesntHave('GroupQuestions')
                                            ->doesntHave('ComponentQuestions')
                                            ->pluck('unique_id');
        if(!empty($elg_questions)){
            $elg_questions = $elg_questions->toArray();
        }else{
            $elg_questions = array();
        }
        $qids = array_merge($question_ids,$elg_questions);


        $comp_questions = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                            ->doesntHave('GroupComponents')
                                            ->pluck('unique_id');
        if(!empty($comp_questions)){
            $comp_questions = $comp_questions->toArray();
        }else{
            $comp_questions = array();
        }
        $comp_ids = array_merge($component_ids,$comp_questions);

        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                                    ->whereIn("unique_id",$qids)
                                                    ->get();
        $viewData['components'] = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)
                                            ->whereIn("unique_id",$comp_ids)
                                            ->get();
        $viewData['pageTitle'] = "Edit Group Questions";
        $viewData['visa_service_id'] = $visa_service_id;
        return view(roleFolder().'.groups-questions.edit',$viewData);
    }

    public function updateGroupQuestions($visa_service_id,$id,Request $request){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'group_title' => 'required',
            'min_score'=> 'required',
            'max_score'=> 'required',
            'components'=> 'required',
        ]);
        
        // if(!$request->input("questions") && !$request->input("components")){
        //     $response['status'] = false;
        //     $response['error_type'] = 'no_component_question';
        //     $response['message'] = "Component or Question must required!";
        //     return response()->json($response);
        // }
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $visa_service = VisaServices::where("id",$visa_id)->first();
        
        $object =  QuestionsGroups::find($id);
        $unique_id = $object->unique_id;
        $object->visa_service_id = $visa_service->unique_id;
        $object->group_title = $request->input("group_title");
        if($request->input("description")){
            $object->description = $request->input("description");
        }else{
            $object->description = '';
        }
        $object->min_score = $request->input("min_score");
        $object->max_score = $request->input("max_score");
        $object->save();

        if($request->input("questions")){
            $questions = $request->questions;
            GroupQuestionIds::where("group_id",$unique_id)->delete();
            foreach($questions as $question){
                $obj = new GroupQuestionIds();
                $obj->group_id = $unique_id;
                $obj->question_id = $question;
                $obj->save();
            }
        }

        if($request->input("components")){
            $components = $request->components;
            GroupComponentIds::where("group_id",$unique_id)->delete();
            foreach($components as $key => $component){
                $obj = new GroupComponentIds();
                $obj->group_id = $unique_id;
                $obj->component_id = $component;
                $obj->sort_order = $key + 1;
                $obj->save();
            }
        }
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function deleteSingleGroup($visa_service_id,$id){
        $id = base64_decode($id);
        QuestionsGroups::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultipleGroup($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            QuestionsGroups::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    // CombinationQuestions
    
    public function combinationQuestions($visa_service_id,$component_id)
    {
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $components = ComponentQuestions::where("visa_service_id",$visa_service->unique_id)->get();

        $questions = ComponentQuestionIds::with('EligibilityQuestion')
                                ->where("component_id",$component_id)
                                ->get();

        $viewData['components'] = $components;
        $viewData['component_id'] = $component_id;
        $viewData['visa_services'] = $visa_service;
        $viewData['questions'] = $questions;
        $viewData['pageTitle'] = $visa_service->name." Combination Questions";

        $records = QuestionCombination::where("visa_service_id",$visa_service->unique_id)
                                    ->where("component_id",$component_id)
                                    ->get();
        $viewData['records'] = $records;
        return view(roleFolder().'.combination-questions.lists',$viewData);
    } 

    public function fetchComponentQuestions($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $component_id = $request->input("component_id");
        $questions = ComponentQuestionIds::with('EligibilityQuestion')->where("component_id",$component_id)->get();
        $options = '<option value="">Select Question One</option>';
        foreach($questions as $question){   
            $options .= '<option value="'.$question->EligibilityQuestion->unique_id.'">'.$question->EligibilityQuestion->question.'</option>';
        }

        $response['status'] = true;
        $response['options'] = $options;
        return response()->json($response);
    }
    public function fetchQuestions($visa_service_id,Request $request){
        
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $question_id = $request->input("question_id");
        $component_id = $request->input("component_id");
        $questions = ComponentQuestionIds::with('EligibilityQuestion')
                                        ->where("component_id",$component_id)
                                        ->where("question_id","!=",$question_id)
                                        ->get();
        // $questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
        //                                 ->where("unique_id","!=",$question_id)
        //                                 ->get();
        $options = '<option value="">Select Question Two</option>';
        foreach($questions as $question){   
            $options .= '<option value="'.$question->EligibilityQuestion->unique_id.'">'.$question->EligibilityQuestion->question.'</option>';
        }

        $response['status'] = true;
        $response['options'] = $options;
        return response()->json($response);
    }

    public function fetchCombinationQuestions($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();

        

        $question_one = $request->input("question_one");
        $question_two = $request->input("question_two");
        $options_one = QuestionOptions::where("question_id",$question_one)->get();
        $options_two = QuestionOptions::where("question_id",$question_two)->get();
        $groups = array();
        $combinations = array();
        $i = 0;
        foreach($options_one as $opt1){
            foreach($options_two as $opt2){
                $temp = array();
                $temp[] = $opt1;
                $temp[] = $opt2;
                $groups[$i] = $temp;
               
                $question_combinations = QuestionCombination::where("option_id_one",$opt1->id)
                                                        ->where("option_id_two",$opt2->id)
                                                        ->first();
                // $query = \DB::getQueryLog();
                // pre($query);
                // echo "OPT1: ".$opt1->id." OPT2:".$opt2->id."<Br>";
                if(!empty($question_combinations)){
                    $combinations['group_'.$i]['behaviour'] = $question_combinations->behaviour;
                    $combinations['group_'.$i]['score'] = $question_combinations->score;
                }
                $i++;
            }  
        }
        
        $viewData['records'] = $groups;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['combinations'] = $combinations;
        $view = View::make(roleFolder().'.combination-questions.combination-questions',$viewData);
        $contents = $view->render();
        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function saveCombinationQuestions($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $validator = Validator::make($request->all(), [
            'combination' => 'required',
        ]);
        
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = '';
            
            foreach($error as $key => $err){
                $errMsg .= "<div>".$err[0]."</div>";
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $combinations = $request->combination;
        array_values($combinations);
        
        
      
        foreach($combinations as $combination){
            QuestionCombination::where("visa_service_id",$visa_service->unique_id)
                            ->where("option_id_one",$combination['option_id_0'])
                            ->where("option_id_two",$combination['option_id_1'])
                            ->delete();
            $object = new QuestionCombination();
            $object->visa_service_id = $visa_service->unique_id;
            $object->component_id = $request->input("component_id");
            $object->option_id_one = $combination['option_id_0'];
            $object->option_id_two = $combination['option_id_1'];
            $object->question_id_one = $combination['question_id_0'];
            $object->question_id_two = $combination['question_id_1'];
            $object->score = $combination['score'];
            $object->behaviour = $combination['behaviour'];
            $object->added_by = \Auth::user()->unique_id;
            $object->save();
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/combination-questions/add/'.$request->input("component_id"));
        $response['message'] = "Combination added successfully";
        
        return response()->json($response);
    }

    public function deleteSingleCombination ($visa_service_id,$id){
        $id = base64_decode($id);
        QuestionCombination::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function fetchOptions(Request $request,$visa_service_id){
        $question_id = $request->get("question_id");
        $options = QuestionOptions::where("question_id",$question_id)->get();
        $html = "<option value=''>Select Option</option>";
        foreach($options as $option){
            $html .= "<option value='".$option->id."'>".$option->option_label."</option>";
        }
        $response['status'] = true;
        $response['options'] = $html;


        return response()->json($response);
    }

    public function defaultComponent($visa_service_id){
        $count = ComponentQuestions::where("visa_service_id",$visa_service_id)->where("is_default",1)->count();
        if($count == 0){
            $object = new ComponentQuestions();
            $object->unique_id = randomNumber();
            $object->visa_service_id = $visa_service_id;
            $object->component_title = "Default Component";
            $object->is_default = 1;
            $object->save();
        }
    }

    public function defaultGroup($visa_service_id){
        $count = QuestionsGroups::where("visa_service_id",$visa_service_id)->where("is_default",1)->count();
        if($count == 0){
            $object = new QuestionsGroups();
            $object->unique_id = randomNumber();
            $object->visa_service_id = $visa_service_id;
            $object->group_title = "Default Group";
            $object->is_default = 1;
            $object->save();
        }
    }


    public function groupComponents($visa_service_id,$group_id){
        $visa_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $group_id = base64_decode($group_id);
        $group = QuestionsGroups::with('Components')->where("id",$group_id)->first();
        
        $viewData['group'] = $group;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        
        $viewData['pageTitle'] = "Set Condition";
        
        return view(roleFolder().'.groups-questions.group-components',$viewData);
    }

    public function setGroupCondition($visa_service_id,$group_id,$component_id,$question_id){
        $visa_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $group_id = base64_decode($group_id);
        $group = QuestionsGroups::with('Components')->where("id",$group_id)->first();
        $record = EligibilityQuestions::where("unique_id",$question_id)->first();
        $component_detail = ComponentQuestions::where("unique_id",$component_id)->first();
        $component_ids = GroupConditionalQuestions::where('group_id',$group->unique_id)
                    ->where("question_id",$question_id)
                    ->get();
        
        $componentSet = array();
        foreach($component_ids as $comp_id){
            $componentSet[$comp_id->option_id] = $comp_id->component_id;
        }
        
        

        $component_lists = GroupComponentIds::where("group_id",$group->unique_id)
                                    ->where("component_id","!=",$component_id)
                                    ->whereHas("Component")
                                    ->get();
                                    
        $components = array();
        $exists_id = GroupConditionalQuestions::where('group_id',$group->unique_id)->get()->toArray();
       
        foreach($component_lists as $comp){
            $exists_id = GroupConditionalQuestions::where("component_id",$component_id)
                                ->where("parent_component_id",$comp->component_id)
                                ->count();
        
            if($exists_id == 0){
                $components[] = $comp;
            }
        }
        $viewData['componentSet'] = $componentSet;
        $viewData['components'] = $components;
        $viewData['component_detail'] = $component_detail;
        $viewData['group'] = $group;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['record'] = $record;
        
        $viewData['pageTitle'] = "Set Condition";
        
        return view(roleFolder().'.groups-questions.set-condition',$viewData);
    }

    public function saveGroupCondition($visa_service_id,$group_id,$component_id,$question_id,Request $request){
        
        $visa_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $group_id = base64_decode($group_id);
        $group = QuestionsGroups::with('Components')->where("id",$group_id)->first();
       
        $components = array();
        if($request->input("component")){
            $components = $request->component;
        }
        
        GroupConditionalQuestions::where('group_id',$group->unique_id)
                    ->where("question_id",$question_id)
                    ->delete();

        foreach($components as $key => $value){
            if($value != ''){
                $object = new GroupConditionalQuestions();
                $object->group_id = $group->unique_id;
                $object->parent_component_id = $component_id;
                $object->question_id = $question_id;
                $object->option_id = $key;
                $object->component_id = $value;
                $object->added_by = \Auth::user()->unique_id;
                $object->save();
            }
        }

        $response['status'] = true;
        $response['redirect_back'] =  baseUrl('visa-services/eligibility-questions/'.$visa_service_id.'/groups-questions/components/'.base64_encode($group_id));
        $response['message'] = "Condition added successfully";
        
        return response()->json($response);
    }

    public function groupEligibilityPattern($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $visa_service_id = $visa_service->unique_id;
        $records = EligibilityPattern::where("visa_service_id",$visa_service_id)->paginate();
        $viewData['records'] = $records;
        $viewData['visa_service'] = $visa_service;
        $viewData['pageTitle'] = "Group Eligibiliy Pattern of ".$visa_service->name;
        
        return view(roleFolder().'.eligibility-questions.group-eligibility-patterns',$viewData);
    }
    

    public function groupEligibilityPatternDelete($visa_service_id,$id){
        $id = base64_decode($id);
        
        EligibilityPattern::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function addGroupEligibilityPattern($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $sub_visa_services = VisaServices::where("parent_id",$visa_service->id)->get();
        $visa_service_id = $visa_service->unique_id;
        $question_sequence = ArrangeGroups::where("visa_service_id",$visa_service->unique_id)
                                        ->orderBy("sort_order","asc")
                                        ->get();
        $viewData['eligible_check'] = 'group';
        $viewData['action'] = 'add';
        $viewData['question_sequence'] = $question_sequence;
        $viewData['sub_visa_services'] = $sub_visa_services;
        $viewData['visa_service'] = $visa_service;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['pageTitle'] = "Eligibility Check of ".$visa_service->name;
        
        return view(roleFolder().'.eligibility-questions.group-eligibility-check',$viewData);
    }

    public function fetchGroupConditional($visa_service_id,Request $request){
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();

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
            $view = View::make(roleFolder().'.eligibility-questions.group-conditional-questions',$viewData);
            $contents = $view->render();
            $response['status'] = true;
            $response['contents'] = $contents;
        }else{
            $response['status'] = false;
        }
        return response()->json($response);
    }
    
    public function saveEligibilityPattern($visa_service_id,Request $request){
        
        $visa_service = VisaServices::where("unique_id",$visa_service_id)->first();
      
        $validator = Validator::make($request->all(), [
            'questions'=> 'required',
            'sub_visa_service'=> 'required'
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
        $questions = $request->questions;
        
        $unique_id = randomNumber();
        $check = EligibilityPattern::where("visa_service_id",$visa_service_id)
                                    ->where("sub_visa_service",$request->input("sub_visa_service"))
                                    ->where("eligible_type",$request->input("eligible_type"))
                                    ->first();
        if(!empty($check)){
            $object = EligibilityPattern::find($check->id);
        }else{
            $object = new EligibilityPattern();
            $object->unique_id = $unique_id;
        }
        $object->visa_service_id = $visa_service_id;
        $object->sub_visa_service = $request->input("sub_visa_service");
        
        $object->eligible_type = $request->input("eligible_type");
        $object->response = json_encode($questions);
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl("visa-services/eligibility-questions/".base64_encode($visa_service->id).'/eligibility-pattern');
        
        return response()->json($response);
    }

    

    public function setEligibilityPattern(Request $request,$visa_service_id){
        $id = base64_decode($visa_service_id);
        $question_ids = explode(",",$request->input("question_ids"));
        for($i=0;$i < count($question_ids);$i++){
            $question_ids[$i] = base64_decode($question_ids[$i]);
        }
       
        $visa_service = VisaServices::where("id",$id)->first();
        $sub_visa_services = VisaServices::where("parent_id",$visa_service->id)->get();
        $visa_service_id = $visa_service->unique_id;
        $questions = EligibilityQuestions::whereIn("id",$question_ids)->get();
        $viewData['visa_service'] = $visa_service;
        $viewData['sub_visa_services'] = $sub_visa_services;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = $questions;
        $viewData['pageTitle'] = "Set Pattern for ".$visa_service->name;
        
        return view(roleFolder().'.eligibility-questions.set-eligibility-pattern',$viewData);
    }

    public function editEligibilityPattern($visa_service_id,$id){
        $id = base64_decode($id);
        $record = EligibilityPattern::where("id",$id)->first();
        
        $id = base64_decode($visa_service_id);
        $ids = json_decode($record->response,true);
        $question_ids = array();
        foreach($ids as $qu_id => $value){
            $question_ids[] = $qu_id;
        }
        $visa_service = VisaServices::where("id",$id)->first();
        $sub_visa_services = VisaServices::where("parent_id",$visa_service->id)->get();
        $visa_service_id = $visa_service->unique_id;
        $questions = EligibilityQuestions::whereIn("unique_id",$question_ids)->get();
        $viewData['record'] = $record;
        $viewData['visa_service'] = $visa_service;
        $viewData['sub_visa_services'] = $sub_visa_services;
        $viewData['visa_service_id'] = $visa_service_id;
        $viewData['questions'] = $questions;
        $viewData['pageTitle'] = "Edit Pattern for ".$visa_service->name;

        return view(roleFolder().'.eligibility-questions.edit-eligibility-pattern',$viewData);
    }

    public function combinationalOptions(Request $request,$visa_id,$question_id){
        $visa_id = base64_decode($visa_id);
        $question_id = base64_decode($question_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $question = EligibilityQuestions::where("id",$question_id)->first();
        $viewData['question'] = $question;
        $viewData['visa_service'] = $visa_service;
        $viewData['pageTitle'] = "Combinational Options";
        $records = CombinationalOptions::where("question_id",$question->unique_id)
                                ->whereHas("OptionOne")
                                ->whereHas("OptionTwo")
                                ->get();
        CombinationalOptions::where("question_id",$question->unique_id)
                            ->doesntHave("OptionOne")
                            ->doesntHave("OptionTwo")
                            ->delete();
                                
        $viewData['records'] = $records;
        return view(roleFolder().'.combinational-options.add',$viewData);
    }

    public function fetchCombinationalOptions(Request $request,$visa_id,$question_id){
        // pre($request->all());
        $visa_id = base64_decode($visa_id);
        $question_id = base64_decode($question_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $question = EligibilityQuestions::where("id",$question_id)->first();
       
        $viewData['question'] = $question;
        $viewData['visa_service'] = $visa_service;

        $options = $request->input("option_one");
        $comb_options = array();
        for($i=0;$i < count($options); $i++){
            $option_one = QuestionOptions::where("id",$options[$i])->first();
            for($j=$i+1;$j < count($options); $j++){
                $option_two = QuestionOptions::where("id",$options[$j])->first();
                $temp = array();
                $temp['option_one'] = $option_one->toArray();
                $temp['option_two'] = $option_two->toArray();
                $checkOption = CombinationalOptions::where("option_one_id",$option_one->id)
                                                   ->where("option_two_id",$option_two->id)
                                                   ->first();
                if(!empty($checkOption)){
                    $temp['score'] = $checkOption->score;
                    $temp['level'] = $checkOption->level;
                }else{
                    $temp['score'] = '';
                    $temp['level'] = '';
                }
                $comb_options[] = $temp;
            }   
        }
        $viewData['comb_options'] = $comb_options;
        // return view(roleFolder().'.combinational-options.combinational-options',$viewData);
        $view = View::make(roleFolder().'.combinational-options.combinational-options',$viewData);
        $contents = $view->render();
        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function saveCombinationalOptions(Request $request,$visa_id,$question_id){
        $visa_id = base64_decode($visa_id);
        $question_id = base64_decode($question_id);
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $question = EligibilityQuestions::where("id",$question_id)->first();        
        $options = $request->input("option");
        $combinational_id = randomNumber();
        foreach($options as $option){
            $checkOption = CombinationalOptions::where("option_one_id",$option['option_one_id'])->where("option_two_id",$option['option_two_id'])->first();
            if(!empty($checkOption)){
                $object = CombinationalOptions::find($checkOption->id);
            }else{
                $object = new CombinationalOptions();
            }
            $object->option_one_id = $option['option_one_id'];
            $object->option_two_id = $option['option_two_id'];
            $object->option_one_value = $option['option_one_value'];
            $object->option_two_value = $option['option_two_value'];
            $object->score = $option['score'];
            $object->level = $option['level'];
            $object->question_id = $request->input("question_id");
            $object->visa_service_id = $request->input("visa_service_id");
            $object->save();
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id));
        $response['message'] = "Combination added successfully";;
        return response()->json($response);
    }

    public function deleteCombinationOption(Request $request, $visa_id,$comb_id){
        $id = base64_decode($com_id);
        CombinationalOptions::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function setPreConditions($visa_service_id,$question_id){
        $visa_id = base64_decode($visa_service_id);
        
        $visa_service = VisaServices::where("id",$visa_id)->first();
      
        $question_id = base64_decode($question_id);
        $record = EligibilityQuestions::where("id",$question_id)->first();
        $question_options = QuestionOptions::where("question_id",$record->unique_id)->get();
        $question_group = ComponentQuestionIds::with('ComponentGroups')
                                            ->where("question_id",$record->unique_id)
                                            ->first();

        $components = array();
        $conditionalComponents = array();
        if(!empty($question_group)){
            $ques_group = $question_group->ComponentGroups->QuestionsGroups;
            $group_sequence = ArrangeGroups::where("group_id",$ques_group->unique_id)
                                        ->where("visa_service_id",$ques_group->visa_service_id)
                                        ->first();

            $group_components = ArrangeGroups::with('Components')
                                    ->where("group_id","!=",$ques_group->unique_id)
                                    ->where("visa_service_id",$ques_group->visa_service_id)
                                    ->where("sort_order",">",$group_sequence->sort_order)
                                    ->get();
            foreach($group_components as $comp){
                $components = array_merge($components,$comp->Components->toArray());
            }
        }
        $preConditions = ComponentPreConditions::where("question_id",$record->unique_id)->get();
        foreach($preConditions as $cond){
            $conditionalComponents[$cond->option_id] = $cond->component_id;
        }
        
        $viewData['question_options'] = $question_options;
        $viewData['conditionalComponents'] = $conditionalComponents;
        $viewData['components'] = $components;
        $viewData['pageTitle'] = "Set Pre Condition";
        $viewData['record'] = $record;
        $viewData['visa_service'] = $visa_service;
        
        return view(roleFolder().'.eligibility-questions.set-pre-condition',$viewData);        
    }

    public function savePreConditions($visa_service_id,$question_id,Request $request){
        ComponentPreConditions::where("question_id",$request->question_id)->delete();

        $components = $request->input("component");
        foreach($components as $opt_id => $component_id){
            if($component_id != ''){
                $object = new ComponentPreConditions();
                $object->question_id = $request->input("question_id");
                $object->option_id = $opt_id;
                $object->component_id = $component_id;
                $object->save();
            }
        }
        $response['status'] = true;
        $response['message'] = "Record saved successfully";
        return response()->json($response);
    }

    public function multipleGroupQuestions($visa_service_id,$component_id)
    {
        $visa_service_id = base64_decode($visa_service_id);
        $viewData['visa_service_id'] = $visa_service_id;
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        // $current_question = EligibilityQuestions::where("id",$question_id)->first();

        $group_questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                        ->whereHas("CombinationalOptions")
                                        ->whereHas("ComponentQuestionIds",function($query) use($component_id){
                                            $query->where("component_id",$component_id);
                                        })
                                        ->get();
        
        $questions = EligibilityQuestions::where("visa_service_id",$visa_service->unique_id)
                                        ->doesntHave("CombinationalOptions")
                                        ->whereHas("ComponentQuestionIds",function($query) use($component_id){
                                            $query->where("component_id",$component_id);
                                        })
                                        ->get();
        
        $question_combinations = MultipleOptionsGroups::where("component_id",$component_id)
                                                ->whereHas("CombinationalOption")
                                                ->whereHas("QuestionOption")
                                                ->whereHas("Question")
                                                ->get();
   
        $viewData['group_questions'] = $group_questions;
        $viewData['visa_service'] = $visa_service;
        $viewData['questions'] = $questions;
        $viewData['question_combinations'] = $question_combinations;
        $viewData['component_id'] = $component_id;
        $viewData['pageTitle'] = "Multiple Options Combinations";

        $records = QuestionCombination::where("visa_service_id",$visa_service->unique_id)->get();
        $viewData['records'] = $records;
        return view(roleFolder().'.combinational-options.multiple-group-questions',$viewData);
    }

    public function fetchGroupOptions(Request $request,$visa_id){
        // pre($request->all());
        $visa_id = base64_decode($visa_id);
        $group_question_id = $request->input("group_question_id");
        $component_id = $request->input("component_id");
        $group_options = $request->input("group_options");
        $question_options = $request->input("question_options");
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $question = EligibilityQuestions::where("unique_id",$group_question_id)->first();
        $combination_options = CombinationalOptions::with(['OptionOne','OptionTwo'])
                                                ->where("question_id",$group_question_id)
                                                ->whereIn("option_one_id",$group_options)
                                                ->whereIn("option_two_id",$group_options)
                                                ->get();
        $viewData['question'] = $question;
        $viewData['visa_service'] = $visa_service;
        
        $selected_question = EligibilityQuestions::where("unique_id",$request->input("selected_question"))->first();
        $options = QuestionOptions::whereIn("id",$question_options)->get();
        // $options = $selected_question->Options;
        $comb_options = array();
        foreach($combination_options as $comb_option){
            foreach($options as $option){
                $temp = array();
                $temp['comb_group'] = $comb_option->toArray();
                $temp['option'] = $option->toArray();
                $checkOption = array();
                $checkOption = MultipleOptionsGroups::where("comb_option_id",$comb_option->id)
                                                   ->where("option_id",$option->id)
                                                   ->first();
                if(!empty($checkOption)){
                    $temp['score'] = $checkOption->score;
                    $temp['behaviour'] = $checkOption->behaviour;
                    $temp['comb_option_id'] = $checkOption->comb_option_id;
                    $temp['option_id'] = $checkOption->option_id;
                }else{
                    $temp['score'] = '';
                    $temp['behaviour'] = '';
                    $temp['comb_option_id'] = '';
                    $temp['option_id'] = '';
                }
                $comb_options[] = $temp;
            }   
        }
        $viewData['comb_options'] = $comb_options;
        $viewData['component_id'] = $component_id;
        // return view(roleFolder().'.combinational-options.combinational-options',$viewData);
        $view = View::make(roleFolder().'.combinational-options.group-combinational-options',$viewData);
        $contents = $view->render();
        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function saveMultipleOptionsGroup(Request $request,$visa_id){
        $visa_id = base64_decode($visa_id);
        $group_question_id = $request->input("group_question_id");
        
        $visa_service = VisaServices::where("id",$visa_id)->first();
        $question = EligibilityQuestions::where("id",$group_question_id)->first();        
        $options = $request->input("option");
        $combinational_id = randomNumber();
        
        foreach($options as $option){
            $checkOption = MultipleOptionsGroups::where("comb_option_id",$option['comb_option_id'])
                                            ->where("option_id",$option['option_id'])
                                            ->first();
            if(!empty($checkOption)){
                $object = MultipleOptionsGroups::find($checkOption->id);
            }else{
                $object = new MultipleOptionsGroups();
            }
            $object->component_id = $request->input("component_id");
            $object->comb_option_id = $option['comb_option_id'];
            $object->question_id = $option['question_id'];
            $object->option_id = $option['option_id'];
            $object->option_value = $option['option_value'];
            $object->score = $option['score'];
            $object->behaviour = $option['behaviour'];
            $object->group_question_id = $request->input("group_question_id");
            $object->visa_service_id = $request->input("visa_service_id");
            $object->save();
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/eligibility-questions/'.base64_encode($visa_service->id).'/multi-option-groups/add/'.$request->input("component_id"));
        $response['message'] = "Combination added successfully";;
        return response()->json($response);
    }

    public function deleteMultipleOptionsGroup($visa_id,$id){
        $id = base64_decode($id);

        MultipleOptionsGroups::where("id",$id)->delete();
        return redirect()->back()->with("success","Record deleted successfully");
    }
}

