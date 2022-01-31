<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\VisaServices;
use App\Models\ProgramTypes;
use App\Models\VisaServiceGroups;
use App\Models\GroupVisaIds;


class VisaServiceGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        
        $viewData['pageTitle'] = "Visa Services Groups";
        $viewData['activeTab'] = "visa-service-groups";
        return view(roleFolder().'.visa-service-groups.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {   $search = $request->input("search");
        $records = VisaServiceGroups::with('VisaServices')
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("group_title","LIKE","%".$search."%");
                                }
                            })
                            ->orderBy('id',"desc")
                            ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.visa-service-groups.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Visa Service";
        $visa_service_ids = GroupVisaIds::get();
        if(!empty($visa_service_ids)){
            $visa_service_ids = $visa_service_ids->pluck("visa_service_id")->toArray();
        }else{
            $visa_service_ids = array();
        }
        $viewData['visa_services'] = VisaServices::where(function($query) use($visa_service_ids){
                                                            if(!empty($visa_service_ids)){
                                                                $query->whereNotIn("unique_id",$visa_service_ids);
                                                            }
                                                    })
                                                    ->get();
        $viewData['program_types'] = ProgramTypes::get();
        
        $viewData['activeTab'] = "visa-service-groups";
        return view(roleFolder().'.visa-service-groups.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'group_title' => 'required',
            'description'=> 'required',
            'image' => "required|mimes:jpeg,jpg,png,gif",
            'program_type'=> 'required',
            // 'visa_services' => 'required|array',
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
        $object =  new VisaServiceGroups();
        $object->group_title = $request->input("group_title");
        $object->unique_id = $unique_id;
        $object->description = $request->input("description");
        
        $object->program_type = $request->input("program_type");
        if ($file = $request->file('image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = public_path("/uploads/visa-groups");
            if($file->move($destinationPath, $newName)){
                $object->image = $newName;
            }
        }
        $object->save();
        if($request->input("visa_services")){
            $visa_services = $request->input("visa_services");
            for($i=0;$i < count($visa_services);$i++){
                $object2 = new GroupVisaIds();
                $object2->visa_group_id = $unique_id;
                $object2->visa_service_id = $visa_services[$i];
                $object2->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-service-groups');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $record = VisaServiceGroups::where("id",$id)->first();
        $viewData['record'] = $record;

        $visa_service_ids = GroupVisaIds::where('visa_group_id',"!=",$record->unique_id)->get();
        if(!empty($visa_service_ids)){
            $visa_service_ids = $visa_service_ids->pluck("visa_service_id")->toArray();
        }else{
            $visa_service_ids = array();
        }
        $viewData['visa_services'] = VisaServices::where(function($query) use($visa_service_ids){
                                                            if(!empty($visa_service_ids)){
                                                                $query->whereNotIn("unique_id",$visa_service_ids);
                                                            }
                                                    })
                                                    ->get();
        $viewData['program_types'] = ProgramTypes::get();
        $viewData['pageTitle'] = "Edit Visa Group Service";
        $viewData['activeTab'] = "visa-service-groups";
        return view(roleFolder().'.visa-service-groups.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $object =  VisaServiceGroups::find($id);
        $validator = Validator::make($request->all(), [
            'group_title' => 'required',
            'description'=> 'required',
            'image' => "mimes:jpeg,jpg,png,gif",
            'program_type'=> 'required',
            // 'visa_services' => 'required|array',
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
        $unique_id = $object->unique_id;
        $object->group_title = $request->input("group_title");
        $object->description = $request->input("description");
        $object->program_type = $request->input("program_type");
        if ($file = $request->file('image')){
            if($object->image != ''){
                unlink(public_path("/uploads/visa-groups"));
            }
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = public_path("/uploads/visa-groups");
            if($file->move($destinationPath, $newName)){
                $object->image = $newName;
            }
        }
        $object->save();

     
        if($request->input("visa_services")){
            $visa_services = $request->input("visa_services");
      
            GroupVisaIds::where("visa_group_id",$unique_id)->delete();
            for($i=0;$i < count($visa_services);$i++){
                $object2 = new GroupVisaIds();
                $object2->visa_group_id = $unique_id;
                $object2->visa_service_id = $visa_services[$i];
                $object2->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-service-groups');
        $response['message'] = "Record updated successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        VisaServiceGroups::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServiceGroups::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
}
