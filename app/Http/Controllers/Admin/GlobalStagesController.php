<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\GlobalStages;
use App\Models\GlobalSubStages;
use App\Models\GlobalStageProfile;
use App\Models\ProfessionalServices;

class GlobalStagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Stage Profiles";
        $viewData['activeTab'] = 'global_stages';
        return view(roleFolder().'.global-stages.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = GlobalStageProfile::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.global-stages.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    
    public function add(Request $request){
        $viewData['pageTitle'] = "Create Stage Profile";
        $viewData['activeTab'] = 'global_stages';
        if($request->get("redirect_back")){
            $viewData['redirect_back'] = $request->get("redirect_back");
        }else{
            $viewData['redirect_back'] = baseUrl("global-stages");
        }
        $service_ids = GlobalStageProfile::where("visa_service_id","!=",0)->pluck("visa_service_id");
        if(!empty($service_ids)){
            $service_ids = $service_ids->toArray();
            $services = ProfessionalServices::whereNotIn('service_id',$service_ids)->orderBy('id',"desc")->get();
        }else{
            $services = ProfessionalServices::orderBy('id',"desc")->get();
        }
        $viewData['services'] = $services;
        return view(roleFolder().'.global-stages.add',$viewData);
    }


    public function save(Request $request){
     
        $validator = Validator::make($request->all(), [
            'name'=>'required',
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
        
        $object = new GlobalStageProfile();
        $object->unique_id = randomNumber();
        $object->name = $request->input("name");
        if($request->input("link_to_service") == 1){
            $object->visa_service_id = $request->input("visa_service_id");
        }
        $object->save();
        $id = $object->id;
        $stage_profile_id = $object->unique_id;
        $items = $request->input("items");
        foreach($items as $stages){
            $object2 = new GlobalStages();
            $object2->unique_id = randomNumber();
            $object2->profile_id = $stage_profile_id;
            $object2->name = $stages['stage_name'];
            $object2->save();
            // $stage_id = $object2->unique_id;

            // $sub_stages = $stages['sub_stages'];
            // foreach($sub_stages as $sub_stage){
            //     $object3 = new GlobalSubStages();
            //     $object3->unique_id = randomNumber();
            //     $object3->name = $sub_stage['name'];
            //     $object3->stage_id = $stage_id;
            //     $object3->stage_type = $sub_stage['stage_type'];
            //     $object3->save();
            // }
        }
        $response['status'] = true;
        // if($request->input("redirect_back")){
        //     $response['redirect_back'] = $request->input("redirect_back");
        // }else{
        //     $response['redirect_back'] = baseUrl('global-stages');
        // }
        $response['redirect_back'] = baseUrl('global-stages/edit/'.base64_encode($id));
        $response['message'] = "Stage Profile added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Stage Profile";
        $viewData['activeTab'] = 'global_stages';
        $id = base64_decode($id);
        if($request->get("redirect_back")){
            $viewData['redirect_back'] = $request->get("redirect_back");
        }else{
            $viewData['redirect_back'] = baseUrl("global-stages");
        }
        $service_ids = GlobalStageProfile::where("visa_service_id","!=",0)->where("id","!=",$id)->pluck("visa_service_id");
        if(!empty($service_ids)){
            $service_ids = $service_ids->toArray();
            $services = ProfessionalServices::whereNotIn('service_id',$service_ids)->orderBy('id',"desc")->get();
        }else{
            $services = ProfessionalServices::orderBy('id',"desc")->get();
        }
        $viewData['services'] = $services;
        $record = GlobalStageProfile::where("id",$id)->first();
        $viewData['record'] = $record;
        return view(roleFolder().'.global-stages.edit',$viewData);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  GlobalStageProfile::find($id);

        $validator = Validator::make($request->all(), [
            'name'=>'required',
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
        if($request->input("link_to_service") == 1){
            $object->visa_service_id = $request->input("visa_service_id");
        }else{
            $object->visa_service_id = 0;
        }
        $object->save();
        $stage_profile_id = $object->unique_id;
        $items = $request->input("items");
        $stage_ids = array();
        
        foreach($items as $stages){
            if(isset($stages['id'])){
                $object2 = GlobalStages::find($stages['id']);
            }else{
                $object2 = new GlobalStages();
                $object2->unique_id = randomNumber();
            }
            $object2->profile_id = $stage_profile_id;
            $object2->name = $stages['stage_name'];
            $object2->save();
            $stage_id = $object2->unique_id;
            $stage_ids[] = $object2->id;
            $sub_stages = $stages['sub_stages'];
            $sub_stage_ids = array();

            foreach($sub_stages as $sub_stage){
                if(isset($sub_stage['id'])){
                    $object3 = GlobalSubStages::find($sub_stage['id']);
                    if(empty($object3)){
                        $object3 = new GlobalSubStages();
                        $object3->unique_id = randomNumber();
                    }
                }else{
                    $object3 = new GlobalSubStages();
                    $object3->unique_id = randomNumber();
                }
                $object3->name = $sub_stage['name'];
                $object3->stage_id = $stage_id;
                $object3->stage_type = $sub_stage['stage_type'];
                $object3->save();
                $sub_stage_ids[] = $object3->id;
            }
            GlobalSubStages::where("stage_id",$stage_id)->whereNotIn("id",$sub_stage_ids)->delete();
        }
        GlobalStages::where("profile_id",$stage_profile_id)->whereNotIn("id",$stage_ids)->delete();
        $response['status'] = true;
        if($request->input("redirect_back")){
            $response['redirect_back'] = $request->input("redirect_back");
        }else{
            $response['redirect_back'] = baseUrl('global-stages');
        }
        
        $response['message'] = "Stage Profile edited sucessfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        GlobalStageProfile::deleteRecord($id);
        
        // \Session::flash('success', 'Records deleted successfully'); 
        return redirect()->back()->with('error',"Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            GlobalStageProfile::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
}
