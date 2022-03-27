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
    
	public function index(){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
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

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
        $viewData['pageTitle'] = "Add Event";
        $viewData['activeTab'] = "event";
        $locations = ProfessionalLocations::get();
        $viewData['locations'] = $locations;
 	
        return view(roleFolder().'.event.add-event',$viewData);
    }

    public function editEvent($id){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
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
	        $event_from_time = $request->input("event_from_time");
	        $event_to_time = $request->input("event_to_time");
	        $description = $request->input("description");
	        $event_date = $request->input("event_date");
	        
	        $object = new ProfessionalEvent;

	        $object->name = $event_name;

        	if($professionalLocations->type == "virtual")
        	{
        		$object->link = $event_link;
        		$object->event_type = "online";				
        	}
        	if($professionalLocations->type == "onsite")
        	{
        		//$object->link = $event_link;
        		$object->event_type = "offline";				
        	}

	        $object->unique_id = randomNumber();	            
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
	        $object->date = $event_date;
            $object->type = "custom-time";
            
            //Need to set as per schedule - pod
            $object->from_time = $request->input("event_from_time");
            $object->to_time = $request->input("event_to_time");
            //

            $object->description = $request->input("description");
            $object->save();

	        $response['status'] = true;
	        $response['message'] = "Event added successfully";
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
	        $event_from_time = $request->input("event_from_time");
	        $event_to_time = $request->input("event_to_time");
	        $description = $request->input("description");
	        $event_date = $request->input("event_date");
	        
	        $object = new ProfessionalEvent;

	        $object->name = $event_name;

        	if($professionalLocations->type == "virtual")
        	{
        		$object->link = $event_link;
        		$object->event_type = "online";				
        	}
        	if($professionalLocations->type == "onsite")
        	{
        		//$object->link = $event_link;
        		$object->event_type = "offline";				
        	}
	        $object->unique_id = randomNumber();    
	        $object->location_id = $location;    
	        $object->from_time = $event_from_time;
	        $object->to_time = $event_to_time;
	        $object->description = $description;
	        $object->event_date = $event_date;
	        $object->save();

	        //Entry in custom time
	        $object = CustomTime::where('location_id',$old_location)->first();
	        $object->location_id = $location;
	        $object->date = $event_date;
            $object->type = "custom-time";
            
            //Need to set as per schedule - pod
            $object->from_time = $request->input("event_from_time");
            $object->to_time = $request->input("event_to_time");
            //

            $object->description = $request->input("description");
            $object->save();

	        $response['status'] = true;
	        $response['message'] = "Event added successfully";
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
