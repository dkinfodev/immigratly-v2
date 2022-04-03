<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DomainDetails;
use App\Models\ProfessionalDetails;
use App\Models\LicenceBodies;
use App\Models\Languages;
use App\Models\AppointmentSchedule;
use App\Models\ProfessionalLocations;
use App\Models\ProfessionalEvent;
use App\Models\CustomTime;

use Validator;
use View;
class ProfessionalEventController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
    }

	public function index(){
        $viewData['pageTitle'] = "Event";
        $viewData['activeTab'] = "event";
        
        return view(roleFolder().'.event.lists',$viewData);

    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = ProfessionalEvent::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.event.event-ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addEvent(){

        
        $viewData['pageTitle'] = "Add Event";
        $viewData['activeTab'] = "event";
        $locations = ProfessionalLocations::get();
        $viewData['locations'] = $locations;
 	
        return view(roleFolder().'.event.add-event',$viewData);
    }

    public function editEvent($id){

        $id = base64_decode($id);
        $object = ProfessionalEvent::where('id',$id)->first();

        $viewData['record'] = $object;

        //print_r($record);exit;	
        $locations = ProfessionalLocations::get();
        $viewData['locations'] = $locations;

        $viewData['pageTitle'] = "Edit Event";
        $viewData['activeTab'] = "event";

        return view(roleFolder().'.event.edit-event',$viewData);
    }


    public function saveEvent(Request $request){

        //pre($request->all());
        //exit;
    	$location = $request->input("location");
        try{
            $valid = array(
                'event_name'=>'required',
	            'event_to_time'=>'required',
	            'event_date'=>'required',
	            'event_from_time'=>'required',
	            'description'=>'required',
	            'location'=>'required',
            );

            // if($request->input("is_online") == "1"){
            //         $valid['event_link'] = 'required';
            // }

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
        
        	$professionalLocations = ProfessionalLocations::where('unique_id',$location)->first();

	        $event_name = $request->input("event_name");
	        $event_link = $request->input("event_link");
	        $event_from_time = date("H:i",strtotime($request->input("event_from_time")));
	        $event_to_time = date("H:i",strtotime($request->input("event_to_time")));
	        $description = $request->input("description");
	        $event_date = date("Y-m-d",strtotime($request->input("event_date")));
	        $check_event = \DB::table(MAIN_DATABASE.".booked_appointments")->where("professional",\Session::get("subdomain"))
                            ->where("appointment_date",$event_date)
                            ->where("start_time",">=",$event_from_time)
                            ->where("end_time",">=",$event_from_time)
                            ->where("location_id",$location)
                            ->count();
	       
            if($check_event > 0){
                $response['status'] = false;
                $response['error_type'] = 'exist';
	            $response['message'] = "Client having appointments on given date of event, Please reschedule the appointment of clients";
                return response()->json($response);
            }
	        $object = new ProfessionalEvent;

	        $object->name = $event_name;

        	if($professionalLocations->type == "online")
        	{
        		$object->link = $event_link;
        		$object->event_type = "online";				
        	}
        	if($professionalLocations->type == "onsite")
        	{
        		//$object->link = $event_link;
        		$object->event_type = "offline";				
        	}
            $event_id = randomNumber();
	        $object->unique_id = $event_id;	            
	        $object->location_id = $location;    
	        $object->from_time = $event_from_time;
	        $object->to_time = $event_to_time;
	        $object->description = $description;
	        $object->event_date = $event_date;
	        $object->save();

	        //Entry in custom time
	        $object = new CustomTime;
	        $object->unique_id = randomNumber();
	        $object->location_id = $location;
	        $object->custom_date = $event_date;
            $object->custom_id = $event_id;
            $object->type = "event-time";
            
            //Need to set as per schedule - pod
            $object->from_time = $request->input("event_from_time");
            $object->to_time = $request->input("event_to_time");
            //

            $object->description = $request->input("description");
            $object->save();

	        $response['status'] = true;
	        $response['message'] = "Event added successfully";
            $response['redirect_back'] = baseUrl('/event');
	    }
	    
	    catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }    
        return response()->json($response);
    }

    public function updateEvent($id,Request $request){

        //pre($request->all());
    	$id = base64_decode($id);
    	$location = $request->input("location");
    	$object = ProfessionalEvent::where('id',$id)->first();
    	$old_location = $object->location_id;
        $event_id = $object->unique_id;
        try{
            $valid = array(
                'event_name'=>'required',
	            'event_to_time'=>'required',
	            'event_date'=>'required',
	            'event_from_time'=>'required',
	            'description'=>'required',
	            'location'=>'required',
            );

            // if($request->input("is_online") == "1"){
            //         $valid['event_link'] = 'required';
            // }

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
        
	        $professionalLocations = ProfessionalLocations::where('unique_id',$location)->first();

	        $event_name = $request->input("event_name");
	        $event_link = $request->input("event_link");
	        $event_from_time = date("H:i",strtotime($request->input("event_from_time")));
	        $event_to_time = date("H:i",strtotime($request->input("event_to_time")));
	        $description = $request->input("description");
	        $event_date = date("Y-m-d",strtotime($request->input("event_date")));
	        $check_event = \DB::table(MAIN_DATABASE.".booked_appointments")->where("professional",\Session::get("subdomain"))
                            ->where("appointment_date",$event_date)
                            ->where("start_time",">=",$event_from_time)
                            ->where("end_time",">=",$event_from_time)
                            ->where("location_id",$location)
                            ->count();
	       
            if($check_event > 0){
                $response['status'] = false;
                $response['error_type'] = 'exist';
	            $response['message'] = "Client having appointments on given date of event, Please reschedule the appointment of clients";
                return response()->json($response);
            }
	        $object->name = $event_name;

        	if($professionalLocations->type == "online")
        	{
        		$object->link = $event_link;
        		$object->event_type = "online";				
        	}
        	if($professionalLocations->type == "onsite")
        	{
        		//$object->link = $event_link;
        		$object->event_type = "offline";				
        	}
	        $object->location_id = $location;    
	        $object->from_time = $event_from_time;
	        $object->to_time = $event_to_time;
	        $object->description = $description;
	        $object->event_date = $event_date;
	        $object->save();

	        //Entry in custom time
            
	        $object = CustomTime::where('custom_id',$event_id)->first();
	        $object->location_id = $location;
	        $object->custom_date = $event_date;
            $object->type = "event-time";
            
            //Need to set as per schedule - pod
            $object->from_time = $request->input("event_from_time");
            $object->to_time = $request->input("event_to_time");
            //

            $object->description = $request->input("description");
            $object->save();

	        $response['status'] = true;
	        $response['message'] = "Event updated successfully";
            $response['redirect_back'] = baseUrl('/event');
	    }
	    
	    catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }    
        return response()->json($response);
    }

    public function deleteEvent($id){
    	$id = base64_decode($id);
        ProfessionalEvent::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
}
