<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;


class BookedAppointmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Booked Appointments";
        $viewData['activeTab'] = 'booked-appointments';
        return view(roleFolder().'.booked-appointments.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['search'] = $search;
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
       
        $result = curlRequest("booked-appointments?page=".$page,$apiData);
        
        $viewData = array();
        if($result['status'] == 'success'){
            $viewData['records'] = $result['data'];
            
            $response['last_page'] = $result['last_page'];
            $response['current_page'] = $result['current_page'];
            $response['total_records'] = $result['total_records'];
        }else{
            $viewData['records'] = array();
        }
  
        $view = View::make(roleFolder().'.booked-appointments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }
    
    public function add(){
        $viewData['pageTitle'] = "Add Appointment Type";
        $view = View::make(roleFolder().'.booked-appointments.modal.add-schedule',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function save(Request $request){
        // pre($request->all());
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
        $object = new AppointmentTypes();
        $object->unique_id = randomNumber();
        $object->name = $request->input("name");
        $object->duration = $request->input("duration");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('booked-appointments');
        $response['message'] = "Schedule added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Appointment Type";
        $id = base64_decode($id);
        $record = AppointmentTypes::find($id);
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.booked-appointments.modal.edit-schedule',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  AppointmentTypes::find($id);

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
        $id = \Auth::user()->id;

        $object->name = $request->input("name");
        $object->duration = $request->input("duration");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('booked-appointments');
        $response['message'] = "Record updated successfully";

        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        AppointmentTypes::deleteRecord($id);
        
        // \Session::flash('success', 'Records deleted successfully'); 
        return redirect()->back()->with('error',"Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            AppointmentTypes::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


}
