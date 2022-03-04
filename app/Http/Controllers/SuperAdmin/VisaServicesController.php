<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\VisaServices;
use App\Models\DocumentFolder;
use App\Models\VisaServiceCutoff;
use App\Models\VisaServiceContent;
use App\Models\NocCode;
use App\Models\CvTypes;
use App\Models\PrimaryDegree;
use App\Models\LanguageProficiency;
use App\Models\LanguageScoreChart;
use App\Models\EligibilityScoreRanges;
use App\Models\VisaServicesBlocks;
use App\Models\Tags;
use App\Models\EligibilityQuestions;
use App\Models\QuestionOptions;
use App\Models\ArrangeQuestions;
use App\Models\ComponentQuestionIds;
use App\Models\ComponentQuestions;
use App\Models\DependentQuestionComponent;

class VisaServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function visaServices()
    {
        
        $viewData['pageTitle'] = "Visa Services";
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-services.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {   $search = $request->input("search");
        $records = VisaServices::with('SubServices')
                            ->where('parent_id',0)
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("name","LIKE","%".$search."%");
                                }
                            })
                            ->orderBy('id',"desc")
                            ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.visa-services.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Visa Service";
        $viewData['main_services'] = VisaServices::where("parent_id",0)->where('is_dependent',0)->get();
        $viewData['documents'] = DocumentFolder::get();
        $viewData['cv_types'] = CvTypes::get();
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-services.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:visa_services',
            'document_folders'=> 'required',
            'assessment_price' => "required|numeric",
            'eligible_type'=> 'required',
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
        
        $unique_id = randomNumber();
        $object =  new VisaServices;
        if($request->input('parent_id')){
            $object->parent_id = $request->input("parent_id");
        }
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->unique_id = $unique_id;
        $object->assessment_price = $request->input("assessment_price");
        if($request->input("is_dependent")){
            $object->is_dependent = 1;
            $object->dependent_visa_service = $request->input("dependent_visa_service");
        }
        if($request->input("document_folders")){
            $object->document_folders = implode(",",$request->input("document_folders"));
        }
        $object->cv_type = $request->input("cv_type");
        $object->eligible_type = $request->input("eligible_type");
        $object->save();

        if($request->input("is_dependent") && $request->input("question")){
            $dependent_questions = $request->input("question");
            $ques_ids = array();
            foreach($dependent_questions as $quid => $que_value){
                $ques_ids[] = $que_value['question_id'];
            }
            $eligibility_questions = EligibilityQuestions::whereIn("unique_id",$ques_ids)->get();
            $avoid_columns = array("id","unique_id","created_at","updated_at",'visa_service_id');
            foreach($eligibility_questions as $question){
                $object2 = new EligibilityQuestions();
                $columns = $object2->getTableColumns();
                foreach($columns as $column){
                    if(!in_array($column,$avoid_columns)){
                        $object2->$column = $question->$column;
                    }
                }
                $elg_unique_id = randomNumber();
                $object2->unique_id = $elg_unique_id;
                $object2->visa_service_id = $unique_id;
                $object2->save();

                $options = $question->Options;
                $avoid_opt_columns = array("id","question_id","created_at","updated_at");
                foreach($options as $option){
                   
                    $object3 = new QuestionOptions();
                    $columns = $object3->getTableColumns();
                   
                    foreach($columns as $column){
                        if(!in_array($column,$avoid_opt_columns)){
                            $object3->$column = $option->$column;
                        }
                    }
                    $object3->question_id = $elg_unique_id;
                    $object3->save();
                }
                
                $this->defaultComponent($unique_id);
                $default_component =  ComponentQuestions::where("visa_service_id",$unique_id)
                                                    ->where("is_default",1)
                                                    ->first();
                $obj = new ComponentQuestionIds();
                $obj->question_id = $elg_unique_id;
                $obj->component_id = $default_component->unique_id;
                $obj->sort_order = 1;
                $obj->save();
                $lastCount = ArrangeQuestions::where("visa_service_id",$unique_id)
                                    ->orderBy("sort_order","desc")
                                    ->first();
                if(!empty($lastCount)){
                    $new_count = $lastCount->sort_order+1;
                }else{
                    $new_count = 1;
                }
                $object = new ArrangeQuestions();
                $object->visa_service_id = $unique_id;
                $object->question_id = $elg_unique_id;
                $object->sort_order = $new_count;
                $object->save();

                $obj = new DependentQuestionComponent();
                $obj->visa_service_id = $unique_id;
                $obj->question_id = $elg_unique_id;
                $obj->linked_question_id = $question->unique_id;
                $obj->component_id = $dependent_questions[$question->unique_id]['component_id'];
                $obj->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = VisaServices::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Visa Services";
        $viewData['documents'] = DocumentFolder::get();
        
        $viewData['main_services'] = VisaServices::where("parent_id",0)
                                                ->where("id","!=",$id)
                                                ->where("is_dependent",0)
                                                ->get();        
        $viewData['cv_types'] = CvTypes::get();
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-services.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $object =  VisaServices::find($id);
        $unique_id = $object->unique_id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:visa_services,name,'.$object->id,
            'assessment_price' => "required|numeric"
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

        
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        if($request->input('parent_id')){
            $object->parent_id = $request->input("parent_id");
        }else{
            $object->parent_id = 0;
        }
        if($request->input("document_folders")){
            $object->document_folders = implode(",",$request->input("document_folders"));
        }
        if($request->input("is_depedent")){
            $object->is_dependent = $request->input("is_depedent");
            $object->dependent_visa_service = $request->input("dependent_visa_service");
        }else{
            $object->is_dependent = 0;
            $object->dependent_visa_service = 0;
        }
        $object->assessment_price = $request->input("assessment_price");
        $object->cv_type = $request->input("cv_type");
        $object->eligible_type = $request->input("eligible_type");
        $object->save();

        if($request->input("is_dependent") && $request->input("question")){
            $dependent_questions = $request->input("question");
            $ques_ids = array();
            foreach($dependent_questions as $quid => $que_value){
                $ques_ids[] = $que_value['question_id'];
            }
            $eligibility_questions = EligibilityQuestions::whereIn("unique_id",$ques_ids)->get();
            $avoid_columns = array("id","unique_id","created_at","updated_at",'visa_service_id');
            foreach($eligibility_questions as $question){
                $object2 = new EligibilityQuestions();
                $columns = $object2->getTableColumns();
                foreach($columns as $column){
                    if(!in_array($column,$avoid_columns)){
                        $object2->$column = $question->$column;
                    }
                }
                $elg_unique_id = randomNumber();
                $object2->unique_id = $elg_unique_id;
                $object2->visa_service_id = $unique_id;
                $object2->save();

                $options = $question->Options;
                $avoid_opt_columns = array("id","question_id","created_at","updated_at");
                foreach($options as $option){
                   
                    $object3 = new QuestionOptions();
                    $columns = $object3->getTableColumns();
                   
                    foreach($columns as $column){
                        if(!in_array($column,$avoid_opt_columns)){
                            $object3->$column = $option->$column;
                        }
                    }
                    $object3->question_id = $elg_unique_id;
                    $object3->save();
                }
                $this->defaultComponent($unique_id);
                $default_component =  ComponentQuestions::where("visa_service_id",$unique_id)
                                                    ->where("is_default",1)
                                                    ->first();
                $obj = new ComponentQuestionIds();
                $obj->question_id = $elg_unique_id;
                $obj->component_id = $default_component->unique_id;
                $obj->sort_order = 1;
                $obj->save();
                $lastCount = ArrangeQuestions::where("visa_service_id",$unique_id)
                                    ->orderBy("sort_order","desc")
                                    ->first();
                if(!empty($lastCount)){
                    $new_count = $lastCount->sort_order+1;
                }else{
                    $new_count = 1;
                }
                $object = new ArrangeQuestions();
                $object->visa_service_id = $unique_id;
                $object->question_id = $elg_unique_id;
                $object->sort_order = $new_count;
                $object->save();

                $obj = new DependentQuestionComponent();
                $obj->visa_service_id = $unique_id;
                $obj->question_id = $elg_unique_id;
                $obj->linked_question_id = $question->unique_id;
                $obj->component_id = $dependent_questions[$question->unique_id]['component_id'];
                $obj->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        VisaServices::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServices::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    public function search($keyword){
        $keyword = $keyword;
        
        $records = VisaServices::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.visa-services.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function visaServiceCutoff($visa_service_id)
    {
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Cutoff Points";
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-service-cutoff.lists',$viewData);
    } 

    public function visaCutoffList($visa_service_id,Request $request)
    {   
        $visa_service_id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $records = VisaServiceCutoff::where("visa_service_id",$visa_service->unique_id)
                            ->orderBy('id',"desc")
                            ->paginate();

        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $view = View::make(roleFolder().'.visa-service-cutoff.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addCutoff($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $noc_codes = NocCode::get();
        $viewData['noc_codes'] = $noc_codes;
        $viewData['visa_service'] = $visa_service;

        $viewData['pageTitle'] = "Add Cutoff";
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-service-cutoff.add',$viewData);
    }

    public function saveCutoff($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
            'cutoff_date' => 'required',
            'cutoff_point'=> 'required'
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
        $visa_service = VisaServices::where("id",$id)->first();
        $object =  new VisaServiceCutoff();
        $object->visa_service_id = $visa_service->unique_id;
        $object->cutoff_date = $request->input("cutoff_date");
        $object->cutoff_point = $request->input("cutoff_point");
        if($request->input("excluded_noc")){
           $object->excluded_noc = implode(",",$request->input("excluded_noc"));
        }
        if($request->input("included_noc")){
           $object->included_noc = implode(",",$request->input("included_noc"));
        }
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/cutoff/'.$visa_service_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function editCutoff($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);

        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = VisaServiceCutoff::find($id);
        $noc_codes = NocCode::get();
        $viewData['noc_codes'] = $noc_codes;
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Cutoff";
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-service-cutoff.edit',$viewData);
    }

    public function updateCutoff($visa_service_id,$id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'cutoff_date' => 'required',
            'cutoff_point'=> 'required'
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
        $visa_service = VisaServices::where("id",$visa_service_id)->first();
        $object =  VisaServiceCutoff::find($id);
        $object->visa_service_id = $visa_service->unique_id;
        $object->cutoff_date = $request->input("cutoff_date");
        $object->cutoff_point = $request->input("cutoff_point");
        if($request->input("excluded_noc")){
           $object->excluded_noc = implode(",",$request->input("excluded_noc"));
        }else{
            $object->excluded_noc = '';
        }

        if($request->input("included_noc")){
           $object->included_noc = implode(",",$request->input("included_noc"));
        }else{
            $object->included_noc = '';
        }
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/cutoff/'.base64_encode($visa_service_id));
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingleCutoff($visa_service_id,$id){
        $id = base64_decode($id);
        VisaServiceCutoff::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultipleCutoff($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServiceCutoff::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function visaServiceContent($visa_service_id){
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Content";
        return view(roleFolder().'.visa-service-content.lists',$viewData);
    }

    public function visaContentList($visa_service_id,Request $request){   
        $visa_service_id = base64_decode($visa_service_id);
        $records = VisaServiceContent::where("visa_service_id",$visa_service_id)
                            ->orderBy('id',"desc")
                            ->paginate();

        $viewData['records'] = $records;
        $viewData['visa_service_id'] = base64_encode($visa_service_id);
        $view = View::make(roleFolder().'.visa-service-content.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addContent($visa_service_id){
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;

        $viewData['pageTitle'] = "Add Content";
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-service-content.add',$viewData);
    }
     
    public function saveContent($visa_service_id,Request $request){
        $id = base64_decode($visa_service_id);
        $validator = Validator::make($request->all(), [
            'description' => 'required',
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
        $object =  new VisaServiceContent();
        $object->title = $request->input("title");
        $object->visa_service_id = $id;
        $object->description = $request->input("description");
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/content/'.$visa_service_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function editContent($visa_service_id,$id){
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);

        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = VisaServiceContent::find($id);
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Content";
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-service-content.edit',$viewData);
    }

    public function updateContent($visa_service_id,$id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            //'cutoff_point'=> 'required'
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
        $object =  VisaServiceContent::find($id);
        $object->visa_service_id = $visa_service_id;
        $object->title = $request->input("title");
        $object->description = $request->input("description");
        
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/content/'.base64_encode($visa_service_id));
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

     public function deleteSingleContent($visa_service_id,$id){
        $id = base64_decode($id);
        VisaServiceContent::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    
    public function deleteMultipleContent($visa_service_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServiceContent::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function fetchEducations(Request $request){
        $primary_degree = PrimaryDegree::select('id','name')->get()->toArray();
        $response['status'] = true;
        $response['educations'] = $primary_degree;
        return response()->json($response);
    }

    public function fetchProficiency(Request $request){
        $proficiency_id = $request->input('proficiency_id');
        $language_proficiency = LanguageProficiency::where("unique_id",$proficiency_id)->first();
        $proficiencies = LanguageScoreChart::select('clb_level','language_proficiency_id')
                            ->where("language_proficiency_id",$proficiency_id)
                            ->get();
        
        $response['status'] = true;
        $response['proficiencies'] = $proficiencies;
        $response['language_proficiency'] = $language_proficiency;
        return response()->json($response);
    }

    public function scoreRanges($visa_service_id){
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $score_range = EligibilityScoreRanges::where("visa_service_id",$visa_service->unique_id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['score_range'] = $score_range;
        $viewData['pageTitle'] = $visa_service->name." Score Range";
        return view(roleFolder().'.visa-services.score-range',$viewData);
    }

    public function saveScoreRange($visa_service_id,Request $request){
        $visa_service_id = base64_decode($visa_service_id);
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        
        $validator = Validator::make($request->all(), [
            'good_score' => 'required',
            'may_be_score' => 'required',
            'difficult_range_score' => 'required',
            'none_eligible_score' => 'required'
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
        $checkExists = EligibilityScoreRanges::where("visa_service_id",$visa_service->unique_id)->first();
        if(!empty($checkExists)){
            $object =  EligibilityScoreRanges::find($checkExists->id);
        }else{
            $object = new EligibilityScoreRanges();
        }
        $object->visa_service_id = $visa_service->unique_id;
        $object->good_score = $request->input("good_score");
        $object->may_be_score = $request->input("may_be_score");
        $object->difficult_range_score = $request->input("difficult_range_score");
        $object->none_eligible_score = $request->input("none_eligible_score");
        
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Score saved successfully";
        
        return response()->json($response);
    }

    public function questionAsSequence(Request $request){
        $show_as_sequence = $request->input("show_as_sequence");

        $visa_id = VisaServices::where("unique_id",$request->input("visa_service_id"))->update(['question_as_sequence'=>$show_as_sequence]);

        $response['status'] = true;
        if($show_as_sequence == 1){
            $response['message'] = "Group Question will display as sequence";
        }else{
            $response['message'] = "Group Question will display all together";
        }

        return response()->json($response);
    }

    public function additionalInfo($id){
        $id = base64_decode($id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name.' Additional Info';
        $viewData['additional_data'] = VisaServicesBlocks::where("visa_service_id",$visa_service->unique_id)->orderBy('sort_order',"asc")->get();
        $viewData['activeTab'] = "visa-services";
        return view(roleFolder().'.visa-services.additional-info.additional-info',$viewData);
    }
    public function changeBlockOrder(Request $request){
        try{
            $orders = $request->input("orders");
            foreach($orders as $key => $value){
                $object = VisaServicesBlocks::find($key);
                $object->sort_order = $value;
                $object->save();
            }
            $response['status'] = true;
            $response['message'] = "Order change successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function addBlock($visa_type_id,Request $request){
        try{
            $visa_type_id = base64_decode($visa_type_id);
            $block = $request->input("block");
            $visa_service = VisaServices::where("id",$visa_type_id)->first();
            $viewData['visa_type_id'] = $visa_type_id;
            if($block == 'overview'){
                $viewData['tags'] = Tags::get();
            }
            $viewData['visa_service'] = $visa_service;
            $view = View::make(roleFolder().'.visa-services.additional-info.'.$block,$viewData);
            $contents = $view->render();
            $response['status'] = true;
            $response['contents'] = $contents;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function editBlock($id,Request $request){
        try{
            $record = VisaServicesBlocks::find($id);
            $block = $record->block;
            $visa_type_id = $record->visa_type_id;
            
            $viewData['visa_type_id'] = $visa_type_id;
            if($block == 'overview'){
                $viewData['tags'] = GeneralTags::get();
            }
            $record = VisaServicesBlocks::find($id);
            $viewData['record'] = $record;
            if($block == 'language'){
                $block = "edit_language";
            }
            if($block == 'expirence'){
                $block = "edit_expirence";
            }
            if($block == 'cost'){
                $block = "edit_cost";
            }
            if($block == 'education'){
                $block = "edit_education";
            }
            $view = View::make(roleFolder().'.visa-services.additional-info.'.$block,$viewData);
            $contents = $view->render();
            $response['status'] = true;
            $response['contents'] = $contents;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function saveVisaBlocks($visa_service_id,Request $request){
        try{
            $visa_type_id = $request->input("visa_type_id");
            $vsb = VisaServicesBlocks::where("visa_service_id",$visa_type_id)->orderBy("sort_order","desc")->first();
            $block = $request->input("block");
            
            $object = new VisaServicesBlocks();
            $object->visa_service_id = $request->input("visa_type_id");
            $object->block = $block;
            $object->title = $request->input("title");
            $object->description = $request->input("description");
            if($block == 'overview'){
                $additional_data = array("tags"=>$request->input("tags"));
                $object->additional_data = json_encode($additional_data);
            }
            
            if($request->input("ads")){
                $additional_data = $request->input("ads");
                $additional_data = array_values($additional_data);
                $object->additional_data = json_encode($additional_data);
            }
            if(!empty($vsb)){
                $object->sort_order = $vsb->sort_order + 1;
            }else{
                $object->sort_order = 1;
            }
            $object->save();
            $response['status'] = true;
            $response['message'] = "Block added successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateVisaBlocks($id,Request $request){
        try{
            $block = $request->input("block");
            $object = VisaServicesBlocks::find($id);
            // $object->visa_type_id = $request->input("visa_type_id");
            // $object->block = $block;
            $object->title = $request->input("title");
            $object->description = $request->input("description");
            if($block == 'overview'){
                $additional_data = array("tags"=>$request->input("tags"));
                $object->additional_data = json_encode($additional_data);
            }
            
            if($request->input("ads")){
                $additional_data = $request->input("ads");
                $additional_data = array_values($additional_data);
                $object->additional_data = json_encode($additional_data);
            }
            $object->save();
            $response['status'] = true;
            $response['message'] = "Block added successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteBlock(Request $request){
        try{
            $id = $request->input("id");
            VisaServicesBlocks::where("id",$id)->delete();
            $response['status'] = true;
            $response['message'] = "Block added successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function stringReplace(Request $request){
        $html = $request->input("html");
        $from = $request->input("from");
        $to = $request->input("to");

        $new_html = str_replace($from,$to,$html);

        echo $new_html;

    }

    public function fetchQuestions(Request $request){
        $visa_service_id = $request->input("visa_service_id");
        $questions = EligibilityQuestions::where("visa_service_id",$visa_service_id)->get();
        $options = "";
        foreach($questions as $ques){
            $options .= "<option value='".$ques->id."'>".$ques->question."</option>";
        }

        $response['status'] = true;
        $response['options'] = $options;

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

    public function fetchQuestionsWithComponents(Request $request){
        $visa_service_id = $request->input("visa_service_id");
        $questions = EligibilityQuestions::whereHas('ComponentQuestions')->where("visa_service_id",$visa_service_id)->get();
        $html = "<table class='table table-bordered table-striped'>";
        $html .="<thead><tr>";
        $html .= '<th class="text-center">
        &nbsp;
                    </th>';
        $html .= "<th>Quuestion</th>";
        $html .= "<th>Component</th>";
        $html .= "</tr></thead><tbody>";
        foreach($questions as $key => $ques){
            // $options .= "<option value='".$ques->id."'>".$ques->question."</option>";
            $html .="<tr>";
            $html .='<th class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input onchange="selectQues(this)" type="checkbox" id="custom-lable-'.$key.'" class="custom-control-input ques_check">
                            <label class="custom-control-label" for="custom-lable-'.$key.'">&nbsp;</label>
                        </div>
                    </th>';
            $html .='<td><input disabled type="hidden" value="'.$ques->unique_id.'" class="dependent_ques" name="question['.$ques->unique_id.'][question_id]" />'.$ques->question.'</td>';
            $html .='<td><select disabled required class="select2 dependent_ques" name="question['.$ques->unique_id.'][component_id]"><option value="">Select Component</option>';
            foreach($ques->ComponentQuestions as $component){
                $html .='<option value="'.$component->Component->unique_id.'">'.$component->Component->component_title.'</option>';
            }
            $html .='</select>';
            $html .='</tr>';
        }
        $html .= "</tbody></table>";

        $response['status'] = true;
        $response['options'] = $html;

        return response()->json($response);
    }
}
