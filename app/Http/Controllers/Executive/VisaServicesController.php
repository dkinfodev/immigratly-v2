<?php

namespace App\Http\Controllers\Executive;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\VisaServices;
use App\Models\VisaServiceContent;

class VisaServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('executive');
    }

    public function visaServices()
    {
        
        $viewData['pageTitle'] = "Visa Services";
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

    public function visaServiceContent($visa_service_id){
        if(!employee_permission('visa-content','view-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $viewData['visa_service_id'] = $visa_service_id;
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_services'] = $visa_service;
        $viewData['pageTitle'] = $visa_service->name." Content";
        return view(roleFolder().'.visa-service-content.lists',$viewData);
    }

    public function visaContentList($visa_service_id,Request $request){   
        if(!employee_permission('visa-content','view-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $visa_service_id = base64_decode($visa_service_id);
        $records = VisaServiceContent::where("visa_service_id",$visa_service_id)
                            ->where("added_by",\Auth::user()->id)
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
        if(!employee_permission('visa-content','add-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $id = base64_decode($visa_service_id);
        $visa_service = VisaServices::where("id",$id)->first();
        $viewData['visa_service'] = $visa_service;

        $viewData['pageTitle'] = "Add Content";
        
        return view(roleFolder().'.visa-service-content.add',$viewData);
    }
     
    public function saveContent($visa_service_id,Request $request){
        if(!employee_permission('visa-content','add-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
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
        if(!employee_permission('visa-content','edit-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $visa_id = base64_decode($visa_service_id);
        $id = base64_decode($id);

        $visa_service = VisaServices::where("id",$visa_id)->first();
        $record = VisaServiceContent::find($id);
        $viewData['visa_service'] = $visa_service;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Content";
        
        return view(roleFolder().'.visa-service-content.edit',$viewData);
    }

    public function updateContent($visa_service_id,$id,Request $request){
        if(!employee_permission('visa-content','edit-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
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
        $object->description = $request->input("description");
        
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('visa-services/content/'.base64_encode($visa_service_id));
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

     public function deleteSingleContent($visa_service_id,$id){
        if(!employee_permission('visa-content','delete-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $id = base64_decode($id);
        VisaServiceContent::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    
    public function deleteMultipleContent($visa_service_id,Request $request){
        if(!employee_permission('visa-content','delete-visa-content')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            VisaServiceContent::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
}
