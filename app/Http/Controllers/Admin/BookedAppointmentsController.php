<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\AppointmentTypes;
use App\Models\AppointmentSchedule;
use App\Models\CustomTime;
use App\Models\ProfessionalLocations;
use App\Models\Leads;
use App\Models\ProfessionalServices;
use App\Models\BookedAppointments;
use App\Models\Invoices;
use App\Models\InvoiceItems;

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
        
        $records = BookedAppointments::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.booked-appointments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }
    public function viewCalendar()
    {
        $viewData['pageTitle'] = "Booked Appointments";
        $viewData['activeTab'] = 'booked-appointments';
        $viewData['professional'] = \Session::get("subdomain");
        return view(roleFolder().'.booked-appointments.calendar',$viewData);
    } 
    public function addAppointment()
    {
        $viewData['pageTitle'] = "Schedule Appointments";
        $leads = Leads::where('mark_as_client',0)->get();
        $viewData['leads'] = $leads;
        $clients = Leads::where('mark_as_client',1)->get();
        $viewData['clients'] = $clients;
        
        $visa_services = ProfessionalServices::orderBy('id',"desc")->get();

        $viewData['visa_services'] = $visa_services;
        $professional_locations = ProfessionalLocations::get();
        $viewData['professional_locations'] = $professional_locations;
        return view(roleFolder().'.booked-appointments.add-appointment',$viewData);
    }

    public function saveAppointment(Request $request){

        $validator = Validator::make($request->all(), [
            'duration' => 'required',
            'visa_service_id' => 'required',
            'appointment_type' => 'required',
            'location_id' => 'required',
            'appointment_for' => 'required',
            'user_id' => 'required',
        ],[
            'visa_service_id.required'=>"Please select visa service",
            'location_id.required'=>"Please select location",
            'user_id.required'=>"Please select user",
        ]);
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
        $duration = explode("-",$request->input("duration"));
        
        
        $appointment = array();
        $booking_id = randomNumber();
        $inv_unique_id = randomNumber();
        $object = new BookedAppointments();
        $object->unique_id = $booking_id;
        $object->location_id = $request->input("location_id");
        $object->break_time = $request->input("break_time");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->appointment_date = $request->input("date");
        $object->appointment_type_id = $request->input("appointment_type");
        if($request->input("appointment_for") == 'leads'){
            $object->lead_id = $request->input("user_id");
        }else{
            $object->client_id = $request->input("user_id");
        }
        
        $object->status = 'awaiting';
        if($request->input("price") > 0){
            $object->payment_status = 'pending';
        }else{
            $object->payment_status = 'paid';
        }
        $object->schedule_id = $request->input("schedule_id");
        $object->time_type = $request->input("time_type");
        
        $object->price = $request->input("price");
        $object->meeting_duration = $request->input("interval");
        $object->start_time = $duration[0];
        $object->end_time = $duration[1];
        $object->invoice_id = $inv_unique_id;
        
        $object->save();

                
        $object2 = new Invoices();
        $object2->unique_id = $inv_unique_id;
        $object2->client_id = $request->input("user_id");
        $object2->payment_status = "pending";
        $object2->amount = $request->input("price");
        $object2->link_to = 'appointment';
        $object2->link_id = $booking_id;
        $object2->invoice_date = date("Y-m-d"); 
        $object2->created_by = \Auth::user()->unique_id;
        $object2->save();

        $object2 = new InvoiceItems();
        $object2->invoice_id = $inv_unique_id;
        $object2->unique_id = randomNumber();
        $object2->particular = "Appointment Fee";
        $object2->amount = $request->input("price");
        $object2->save();

        $response['status'] = true;
        $response['message'] = "Appointment booked successfully!";
        

        if($request->input("appointment_for") == 'leads'){
            $user = Leads::where("unique_id",$request->input("user_id"))->first();
        }else{
            $user = Leads::where("unique_id",$request->input("user_id"))->first();
        }
        $subdomain =  \Session::get("subdomain");
        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);
        
        $start_time = $duration[0]; 
        $end_time = $duration[1];
        $date = $request->input("date");
        $email = $user->email;
        
        
        $message = "<p>Professional ".$company_data->company_name." booked an appointment for ".$date." from ".$start_time." to ".$end_time."</p>"; 
        if($request->input("price") > 0){
            $message .= "<p>To confirm booking you will have to pay ".currencyFormat($request->input("price")).". Click below link and pay and confirm</p>";
            $message .= "<p><a href='#'>Click here to Pay</a></p>";
        }
        $mailData['mail_message'] = $message;

        $view = View::make('emails.notification',$mailData);
        $message = $view->render();
        $parameter['to'] = $email;
        $parameter['to_name'] = '';
        $parameter['message'] = $message;
        $parameter['subject'] = "Appointment booked with Professional from Immigratly";
        $parameter['view'] = "emails.notification";
        $parameter['data'] = $mailData;
        $mailRes = sendMail($parameter);
        return response()->json($response);
    }
    public function rescheduleAppointment($appointment_id)
    {
        $subdomain = \Session::get("subdomain");
        $apiData['appointment_id'] = $appointment_id;
        $result = curlRequest("booked-appointments/single",$apiData);
        if($result['status'] == 'success'){
            $record = $result['data'];
        }else{
            return redirect()->back()->with("error","Invalid appointment access");
        }
        $viewData['pageTitle'] = "Booked Appointments";
        $viewData['record'] = $record;
        

        $professional_location = ProfessionalLocations::where('unique_id',$record['location_id'])->first();
        $appointment_schedule = AppointmentSchedule::where('location_id',$record['location_id'])->with('Location')->get();
        $appointment_types = AppointmentTypes::with('timeDuration')->get()->toArray();
        $visa_service = professionalService($subdomain,$record['visa_service_id'],'unique_id');
        $viewData['service'] = $visa_service;
        $viewData['appointment_types'] = $appointment_types;
        $viewData['appointment_schedule'] = $appointment_schedule;
        $viewData['location_id'] = $record['location_id'];
        $viewData['action'] = "edit";
        $viewData['eid'] = $record['unique_id'];
        $viewData['professional_location'] = $professional_location;

        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.booked-appointments.reschedule',$viewData);
    }
     
    public function fetchServiceAppointmentTypes(Request $request){
        $subdomain = \Session::get("subdomain");
        $results = AppointmentTypes::with('timeDuration')->get();
        $services = '<option value="">Select Appointment Type</option>';
        $data = array();
        $data['service_id'] = $request->input("visa_service_id");
        $apiData = professionalCurl('appointment-types',$subdomain,$data);

        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $appointment_types = $apiData['data'];
        }else{
            $appointment_types = array();
        }
        $viewData['appointment_types'] = $appointment_types;
        $view = View::make(roleFolder().'.booked-appointments.appointment-types',$viewData);
        $contents = $view->render();
        
        $response['status'] = true;
        $response['html'] = $contents;

        return response()->json($response);
    }
    public function fetchAppointments(Request $request){
        $month = $request->input("month");
        $year = $request->input("year");
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $professional = $request->input("professional");
        
        $day_schedules = array();
        $apiData['professional'] = \Session::get("subdomain");
        $apiData['start_date'] = $start_date;
        $apiData['end_date'] = $end_date;
        $apiData['response_type'] = "date_counter";
        $result = curlRequest("booked-appointments/fetch-appointments",$apiData);
        if($result['status'] == 'success'){
            $appointments = $result['data'];
        }else{
            $appointments = array();
        }
        $dates = getBetweenDates($start_date,$end_date);
        
        for($d=0;$d < count($dates);$d++){
            $day = date("l",strtotime($dates[$d]));
            foreach($appointments as $appointment){
                if($appointment['appointment_date'] == $dates[$d]){
                    $temp = array();
                    $temp['start'] = $dates[$d];
                    $temp['title'] = $appointment['total_appointment']. " Appointment(s) \n are booked";
                    $temp['className'] = 'text-primary booked-appointment';
                    $day_schedules[] = $temp;
                }
            }
        }
        $response['status'] = true;
        $response['schedule'] = $day_schedules;

        return response()->json($response);
    }


    public function fetchHours(Request $request){
        $location_id = $request->input("location_id");
        $month = $request->input("month");
        $year = $request->input("year");
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        
        $day_schedules = array();
        $appointment_date = '';
        if($request->action == 'edit' && $request->eid != ''){
            $eid = $request->eid;
            $appointment = BookedAppointments::where("unique_id",$eid)->first();
            if(!empty($appointment)){
                $appointment_date = $appointment->appointment_date;
            }
        }
        $dates = getBetweenDates($start_date,$end_date);
        $schedule_available = false;
        for($d=0;$d < count($dates);$d++){
            $day = date("l",strtotime($dates[$d]));
            $hours = AppointmentSchedule::where("location_id",$location_id)
                    ->where("day",strtolower($day))
                    ->first();
            $custom_time = CustomTime::where("custom_date",$dates[$d])
                    ->where("location_id",$location_id)
                    ->first();
            if(!empty($custom_time)){
                $schedule_available = true;
                if($custom_time->type == 'custom-time'){
                    $temp = array();
                    $temp['start'] = $dates[$d];
                    $temp['end'] = $dates[$d];
                    $temp['time_type'] = 'custom_time';
                    $temp['id'] = $custom_time->id;
                    $temp['title'] = "Working Hours \n".$custom_time->from_time." to ".$custom_time->to_time;
                    $temp['className'] = 'available-appointment';
                    $day_schedules[] = $temp;
                }else{
                    $temp['start'] = $dates[$d];
                    $temp['end'] = $dates[$d];
                    $temp['id'] = $custom_time->id;
                    $temp['time_type'] = 'day_off';
                    $temp['title'] = $custom_time->description;
                    $temp['className'] = 'text-danger day-off';
                    $day_schedules[] = $temp;
                }
            }else{
                if(!empty($hours)){
                    $schedule_available = true;
                    $temp = array();
                    $temp['start'] = $dates[$d];
                    $temp['end'] = $dates[$d];
                    $temp['id'] = $hours->id;
                    $temp['time_type'] = 'default';
                    $temp['title'] = "Working Hours \n".$hours->from_time." to ".$hours->to_time;
                    $temp['className'] = 'available-appointment';
                    $day_schedules[] = $temp;
                }
            }

            $booked_appointment = BookedAppointments::where("appointment_date",$dates[$d])->count();
            if($booked_appointment > 0){
                $temp = array();
                $temp['start'] = $dates[$d];
                $temp['id'] = $hours->id;
                $temp['title'] = $booked_appointment. " Appointment(s) booked";
                $temp['className'] = 'text-primary booked-appointment';
                $day_schedules[] = $temp;
            }

            if($appointment_date == $dates[$d]){
                $temp = array();
                $temp['start'] = $dates[$d];
                $temp['title'] = "Current Appointment Date";
                $temp['className'] = 'bg-warning';
                $day_schedules[] = $temp;
            }
        }
        $response['status'] = true;
        $response['schedule_available'] = $schedule_available;
        $response['schedule'] = $day_schedules;

        return response()->json($response);
    }

    public function fetchAvailabilityHours(Request $request){
        $date = $request->input("date");
        $schedule_id = $request->input("schedule_id");
        $service_id = $request->input("service_id");
        $break_time = $request->input("break_time");
        $price = $request->input("price");
        if($request->input("time_type")){
            $time_type = $request->input("time_type");
        }else{
            $time_type = 'default';
        }

        if($request->get("action") == 'edit' && $request->get("eid")){
            $eid = $request->get("eid");
            $viewData['action'] = "edit";
            $viewData['eid'] = $eid;
            $appointment = BookedAppointments::where("unique_id",$eid)->first();
            $viewData['appointment'] = $appointment;
        }else{
            $viewData['action'] = "add";
            $viewData['eid'] = '';
        }

        $professional = \Session::get("subdomain");
        $date = $request->input("date");
        $location_id = $request->input("location_id");
        $appointment_type_id = $request->input("appointment_type_id");
        $visa_service = professionalService($professional,$service_id,'unique_id');
       
        $appointment_type = AppointmentTypes::where("unique_id",$appointment_type_id)->first();
       
        $data['time_type'] = $time_type;
        $data['return'] = 'single';
        
        if($time_type == 'default'){
            $appointment_schedule =  AppointmentSchedule::where('id',$request->input('schedule_id'))->with('Location')->first()->toArray();
        }else{
            $appointment_schedule = CustomTime::where('id',$request->input('schedule_id'))->with('Location')->first()->toArray();
        }
        $viewData['visa_service'] = $visa_service;
        
        $type = $appointment_type->timeDuration->type;
        if($type == 'minutes'){
            $interval = $appointment_type->timeDuration->duration;
        }else{
            $interval = $appointment_type->timeDuration->duration * 60;
        }
        
        
        $from_time = $appointment_schedule['from_time'];
        $to_time = $appointment_schedule['to_time'];
        $booked_slots = BookedAppointments::where("location_id",$location_id)
                        ->whereDate("appointment_date",$date)
                        ->get();
        if(!empty($booked_slots)){
            $booked_slots = $booked_slots->toArray();
        }else{
            $booked_slots = array();
        }
        $book_slots = array();
        foreach($booked_slots as $b_slot){
            $temp = new \stdClass();
            $temp->from_time = $b_slot->start_time;
       
            $temp->to_time = date("H:i",strtotime($b_slot->end_time." +".$b_slot->break_time." minutes"));
            $book_slots[] = $temp;
        }

        $custom_times = CustomTime::where("custom_date",$date)
                    ->where("type","event-time")
                    ->get();
        foreach($custom_times as $b_slot){
            $temp = new \stdClass();
            $temp->from_time = $b_slot->from_time;
        
            $temp->to_time = $b_slot->to_time;
            $book_slots[] = $temp;
        }
        // pre($book_slots);
        $prev_endtime = array();
        $today = date("Y-m-d");
        if(!empty($book_slots)){
            asort($book_slots);
            $array_of_time = array();
            $book_slots = array_values($book_slots);
            foreach($book_slots as $key => $slot){
                if($key == 0){
                    if($date == $today){
                        
                        $app_from_time = $from_time;
                        $app_to_time = $slot->from_time;
                    }else{
                        $app_from_time = $from_time;
                        $app_to_time = $slot->from_time;
                    }
                    
                    if($app_from_time < $app_to_time){
                        $time_slot = getTimeSlot($interval,$app_from_time,$app_to_time);
                        $array_of_time = array_merge($array_of_time,$time_slot);
                    }
                    $prev_endtime[$key] = $slot->to_time;
                    
                }else{
                    $app_from_time = $prev_endtime[$key-1];
                    $app_to_time = $slot->from_time;
                    $time_slot = getTimeSlot($interval,$app_from_time,$app_to_time);
                    $array_of_time = array_merge($array_of_time,$time_slot);
                    $prev_endtime[$key] = $slot->to_time;
                    
                }
            }

            $app_from_time = end($prev_endtime);
            $app_to_time = $to_time;
            $time_slot = getTimeSlot($interval,$app_from_time,$app_to_time);
            $array_of_time = array_merge($array_of_time,$time_slot);
            $time_slots = $array_of_time;
        }else{
            $time_slots = getTimeSlot($interval,$from_time,$to_time);
        }
        
        $time_slots = array_values($time_slots);
        // pre($time_slots);
        $viewData['break_time'] = $break_time;
        $viewData['date'] = date("F d, Y",strtotime($date));
        $viewData['time_slots'] = $time_slots;
        $viewData['schedule_id'] = $schedule_id;
        $viewData['location_id'] = $location_id;
        $viewData['interval'] = $interval;
        $viewData['professional'] = $professional;
        $viewData['time_type'] = $time_type;
        $viewData['price'] = $price;
        
        $viewData['date'] = $date;
        $viewData['appointment_type_id'] = $appointment_type_id;
        $viewData['pageTitle'] = "Selct Your Time Slot";
        if($request->input("time_slot_for") == 'add-appointment'){
            $view = View::make(roleFolder().'.booked-appointments.appointment-slots',$viewData);
        }else{
            $view = View::make(roleFolder().'.booked-appointments.time-slots',$viewData);
        }
        
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function updateAppointment(Request $request){

        $validator = Validator::make($request->all(), [
            'duration' => 'required',
            'visa_service' => 'required',
        ]);
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
        $apiData = $request->all();
        $result = curlRequest("booked-appointments/update-appointment",$apiData);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = $result['message'];
            $response['redirect_back'] = baseUrl("booked-appointments");
        }else{
            $response['status'] = false;
            $response['message'] = $result['message'];
        }
        return response()->json($response);
    }

    public function changeStatus($id,$status){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['id'] = $id;
        $apiData['status'] = $status;
        $result = curlRequest("booked-appointments/change-status",$apiData);
        
        $viewData = array();
        if($result['status'] == 'success'){
            return redirect()->back()->with("success","Booking status changed successfully");
        }else{
            return redirect()->back()->with("error","Something wents wrong");
        }        
    }
    
    public function viewAppointment($appointment_id){
        $appointment = \DB::table(MAIN_DATABASE.".booked_appointments")
                            ->where("unique_id",$appointment_id)
                            ->first();
        $subdomain = \Session::get("subdomain");
        $visa_service = professionalService($subdomain,$appointment->visa_service_id,'unique_id');
        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);
        $professional_location = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_locations")->where('unique_id',$appointment->location_id)->first();
        $viewData['professional_location'] = $professional_location;
        $viewData['pageTitle'] = "View Appointment";
        $viewData['service'] = $visa_service;
        $viewData['company_data'] = $company_data;
        $viewData['professionalAdmin'] = $professionalAdmin;
        $viewData['appointment'] = $appointment;
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.booked-appointments.view-appointment',$viewData);
    }

}
