<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;
use App\Models\User;
use App\Models\DomainDetails;
use App\Models\ProfessionalDetails;
use App\Models\LicenceBodies;
use App\Models\Languages;
use App\Models\AppointmentSchedule;
use App\Models\ProfessionalEvent;
use App\Models\CustomTime;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index($location_id){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
        $viewData['pageTitle'] = "Appointment";
        $viewData['activeTab'] = "appointment-schedule";
        $viewData['location_id'] = $location_id;

        return view(roleFolder().'.appointment.lists',$viewData);

    }


    // public function getAjaxList($location_id,Request $request)
    // {
    //     $search = $request->input("search");
    //     $records = ProfessionalEvent::orderBy('id',"desc")
    //                     ->where(function($query) use($search){
    //                         if($search != ''){
    //                             $query->where("name","LIKE","%$search%");
    //                         }
    //                     })
    //                     ->paginate();
    //     $viewData['records'] = $records;
    //     $view = View::make(roleFolder().'.appointment.event-ajax-list',$viewData);
    //     $contents = $view->render();
    //     $response['contents'] = $contents;
    //     $response['last_page'] = $records->lastPage();
    //     $response['current_page'] = $records->currentPage();
    //     $response['total_records'] = $records->total();
    //     return response()->json($response);
    // }

    //8-3-22 ys
    public function setSchedule($location_id){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
        $records = AppointmentSchedule::where("location_id",$location_id)->get();

        $schedules = array();
        foreach($records as $record){
            $schedules[$record->day] = array("from"=>$record->from_time,"to"=>$record->to_time);
        }
        
        $customTime = CustomTime::where('location_id',$location_id)->get();

        //echo $location_id;
        // print_r($customTime);
        //  exit; 
        $viewData['customTime'] = $customTime;
        $viewData['pageTitle'] = "Appointment Schedule";
        $viewData['activeTab'] = "appointment-schedule";
        $viewData['schedules'] = $schedules;
        $viewData['location_id'] = $location_id;
        return view(roleFolder().'.appointment.set-schedule',$viewData);

    }

    public function saveSchedule($location_id,Request $request){

        //pre($request->all());
        $schedules = $request->input("schedule");
        $active_days = array();
        foreach($schedules as $schedule){
            $checkSchedule = AppointmentSchedule::where("day",$schedule['day'])
                                                ->where("location_id",$location_id)
                                                ->first();
            if(!empty($checkSchedule)){
                $object = AppointmentSchedule::find($checkSchedule->id);
            }else{
                $object = new AppointmentSchedule();
            }
            $object->location_id = $location_id;
            $object->day = $schedule['day'];
            $object->from_time = $schedule['from'];
            $object->to_time = $schedule['to'];
            $object->save();
            $active_days[] = $schedule['day'];
        }
        AppointmentSchedule::whereNotIn("day",$active_days)
                            ->where("location_id",$location_id)
                            ->delete();
        $response['status'] = true;
        $response['message'] = "Appointment Schedule set successfully.";

        return response()->json($response);
    }

    // 9-3-22 ys
    public function addEvent(){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
        $viewData['pageTitle'] = "Add Event";
        $viewData['activeTab'] = "appointment-schedule";

        return view(roleFolder().'.appointment.add-event',$viewData);
    }

    // public function saveEvent(Request $request){

    //     //pre($request->all());

    //     $validator = Validator::make($request->all(), [
    //         'event_name'=>'required',
    //         'event_link'=>'required',
    //         'event_time'=>'required',
    //         'description'=>'required',
            
    //     ]);

    //     if ($validator->fails()) {
    //         $response['status'] = false;
    //         $error = $validator->errors()->toArray();
    //         $errMsg = array();
            
    //         foreach($error as $key => $err){
    //             $errMsg[$key] = $err[0];
    //         }
    //         $response['message'] = $errMsg;
    //         return response()->json($response);
    //     }
    //     $event_name = $request->input("event_name");
    //     $event_link = $request->input("event_link");
    //     $event_time = $request->input("event_time");
    //     $description = $request->input("description");

    //     $object = new ProfessionalEvent;

    //     $object->name = $event_name;
    //     $object->link = $event_link;
    //     $object->time = $event_time;
    //     $object->description = $description;
    //     $object->save();

    //     $response['status'] = true;
    //     $response['message'] = "Event set successfully";

    //     return response()->json($response);
    // }

    //16-3-22
    public function addCustomTime($location_id){
        $viewData['pageTitle'] = "Add Customized Time";

        $viewData['location_id'] = $location_id;
        $view = View::make(roleFolder().'.appointment.custom-time.add',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function editCustomTime($location_id,$id){

        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit Customized Time";
        $viewData['location_id'] = $location_id;

        $rec = CustomTime::where('id',$id)->first();
        $viewData['rec'] = $rec;
        $view = View::make(roleFolder().'.appointment.custom-time.edit',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveCustomTime($location_id,Request $request){
        // pre($request->all());
        
        try{
            $valid = array(
                'date'=>'required',
                'type'=>'required', 
            );


            if($request->input("type") == "day-off"){
                    $valid['description'] = 'required';
                    
            }

            if($request->input("type") == "custom-time"){
                    $valid['from'] = 'required';
                    $valid['to'] = 'required';        
            }

            $validator = Validator::make($request->all(),$valid);

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
        

            $location_id = base64_decode($location_id);

            $object = new CustomTime();
            $object->unique_id = randomNumber();
            $object->location_id = $request->input("location_id");
            $object->custom_date = dateFormat($request->input("date"),"Y-m-d");
            $object->type = $request->input("type");
            
            if( $request->input("type") != "day-off"){

                if(!empty($request->input("from")))
                {
                    $object->from_time = $request->input("from");
                }

                if(!empty($request->input("to")))
                {
                    $object->to_time = $request->input("to");
                }
            }
            else
            {
                $object->description = $request->input("description");
            }

            //$object->duration = $request->input("duration");
            
            $object->save();

            $response['status'] = true;
            $response['redirect_back'] = baseUrl('appointment/'.base64_encode($location_id).'/set-schedule');
            $response['message'] = "Custom Time added sucessfully";
        }
        catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        
        return response()->json($response);
    }
 
    public function updateCustomTime($location_id,Request $request){
        // pre($request->all());
        $object = CustomTime::where('id',base64_decode($request->input("rec_id")))->first();

        try{
            $valid = array(
                'date'=>'required',
                'type'=>'required', 
            );


            if($request->input("type") == "day-off"){
                    $valid['description'] = 'required';
                    
            }

            if($request->input("type") == "custom-time"){
                    $valid['from'] = 'required';
                    $valid['to'] = 'required';        
            }

            $validator = Validator::make($request->all(),$valid);

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
        

            $location_id = base64_decode($location_id);

            $object->location_id = $request->input("location_id");
            $object->custom_date = dateFormat($request->input("date"),"Y-m-d");
            
            $object->type = $request->input("type");
            
            if( $request->input("type") != "day-off"){

                if(!empty($request->input("from")))
                {
                    $object->from_time = $request->input("from");
                }

                if(!empty($request->input("to")))
                {
                    $object->to_time = $request->input("to");
                }
            }
            else
            {
                $object->description = $request->input("description");
            }

            //$object->duration = $request->input("duration");
            
            $object->save();

            $response['status'] = true;
            $response['redirect_back'] = baseUrl('appointment/'.base64_encode($location_id).'/set-schedule');
            $response['message'] = "Custom Time updated sucessfully";
        }
        catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        
        return response()->json($response);
    }

    public function deleteCustomTime($location_id,$id){
        $id = base64_decode($id);
        CustomTime::deleteRecord($id);
        
        // \Session::flash('success', 'Records deleted successfully'); 
        return redirect()->back()->with('error',"Record deleted successfully");
    }

    // public function edit($id,Request $request){
    //     $viewData['pageTitle'] = "Edit Appointment Type";
    //     $id = base64_decode($id);
    //     $record = AppointmentTypes::find($id);
    //     $viewData['record'] = $record;
    //     $view = View::make(roleFolder().'.appointment-types.modal.edit-schedule',$viewData);
    //     $contents = $view->render();
    //     $response['contents'] = $contents;
    //     $response['status'] = true;
    //     return response()->json($response);
    // }


    // public function update($id,Request $request){
    //     // pre($request->all());
    //     $id = base64_decode($id);
    //     $object =  AppointmentTypes::find($id);

    //     $validator = Validator::make($request->all(), [
    //         'name'=>'required',
    //     ]);

    //     if ($validator->fails()) {
    //         $response['status'] = false;
    //         $error = $validator->errors()->toArray();
    //         $errMsg = array();
            
    //         foreach($error as $key => $err){
               
    //             $errMsg[$key] = $err[0];
    //         }
    //         $response['message'] = $errMsg;
    //         return response()->json($response);
    //     }
    //     $id = \Auth::user()->id;

    //     $object->name = $request->input("name");
    //     $object->duration = $request->input("duration");
    //     $object->save();
        
    //     $response['status'] = true;
    //     $response['redirect_back'] = baseUrl('appointment-types');
    //     $response['message'] = "Record updated successfully";

    //     return response()->json($response);
    // }

    // public function deleteSingle($id){
    //     $id = base64_decode($id);
    //     AppointmentTypes::deleteRecord($id);
        
    //     // \Session::flash('success', 'Records deleted successfully'); 
    //     return redirect()->back()->with('error',"Record deleted successfully");
    // }

    // public function deleteMultiple(Request $request){
    //     $ids = explode(",",$request->input("ids"));
    //     for($i = 0;$i < count($ids);$i++){
    //         $id = base64_decode($ids[$i]);
    //         AppointmentTypes::deleteRecord($id);
    //     }
    //     $response['status'] = true;
    //     \Session::flash('success', 'Records deleted successfully'); 
    //     return response()->json($response);
    // }
}
