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

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function index(){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
        $viewData['pageTitle'] = "Appointment";
        $viewData['activeTab'] = "appointment-schedule";

        return view(roleFolder().'.appointment.lists',$viewData);

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
        $view = View::make(roleFolder().'.appointment.event-ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    //8-3-22 ys
    public function setSchedule(){

        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        
        $records = AppointmentSchedule::get();

        $schedules = array();
        foreach($records as $record){
            $schedules[$record->day] = array("from"=>$record->from_time,"to"=>$record->to_time);
        }
        
        
        $viewData['pageTitle'] = "Appointment Schedule";
        $viewData['activeTab'] = "personal_tab";
        $viewData['schedules'] = $schedules;

        return view(roleFolder().'.appointment.set-schedule',$viewData);

    }

    public function saveSchedule(Request $request){

        //pre($request->all());
        $schedules = $request->input("schedule");
        $active_days = array();
        foreach($schedules as $schedule){
            $checkSchedule = AppointmentSchedule::where("day",$schedule['day'])->first();
            if(!empty($checkSchedule)){
                $object = AppointmentSchedule::find($checkSchedule->id);
            }else{
                $object = new AppointmentSchedule();
            }
            $object->day = $schedule['day'];
            $object->from_time = $schedule['from'];
            $object->to_time = $schedule['to'];
            $object->save();
            $active_days[] = $schedule['day'];
        }
        AppointmentSchedule::whereNotIn("day",$active_days)->delete();
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
        $viewData['active_tab'] = "personal_tab";

        return view(roleFolder().'.appointment.add-event',$viewData);
    }

    public function saveEvent(Request $request){

        //pre($request->all());

        $validator = Validator::make($request->all(), [
            'event_name'=>'required',
            'event_link'=>'required',
            'event_time'=>'required',
            'description'=>'required',
            
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
        $event_name = $request->input("event_name");
        $event_link = $request->input("event_link");
        $event_time = $request->input("event_time");
        $description = $request->input("description");

        $object = new ProfessionalEvent;

        $object->name = $event_name;
        $object->link = $event_link;
        $object->time = $event_time;
        $object->description = $description;
        $object->save();

        $response['status'] = true;
        $response['message'] = "Event set successfully";

        return response()->json($response);

    }
}
