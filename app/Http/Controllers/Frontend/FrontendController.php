<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Validator;
use DB;
use Razorpay\Api\Api;
use Image;
use View;
use App\Models\User;
use App\Models\Articles;
use App\Models\ChatGroups;
use App\Models\News;
use App\Models\Professionals;
use App\Models\ChatGroupComments;
use App\Models\Webinar;
use App\Models\VisaServices;
use App\Models\VisaServiceContent;
use App\Models\AssessmentForms;
use App\Models\Leads;
use App\Models\Countries;
use App\Models\States;
use App\Models\City;
use App\Models\Languages;
use App\Models\ArrangeGroups;
use App\Models\ProfessionalReview;
use App\Models\AppointmentSchedule;
use App\Models\AppointmentTypes;
use App\Models\BookedAppointments;
use App\Models\UserInvoices;
use App\Models\InvoiceItems;
use App\Models\UserWithProfessional;
use App\Models\ClientAppointments;
class FrontendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }
    public function home(){
        if(\Auth::check()){
            return redirect(baseUrl('/'));
        }else{
            return redirect('/');
        }
    }
    public function index(){
        //return redirect("signup/user");
        // $data['database'] = base64_encode("immigrat_main_immigratly");
        // $data['username'] = base64_encode("immigrat_immigratly");
        // $data['password'] = base64_encode("PHx#t;qv1p]S");
        // pre($data);
        // exit;
        // $db['GOOGLE_CLIENT_ID'] = base64_encode("972372764079-l4dqpfuun15l5oetf070mh6ek60m6jl7.apps.googleusercontent.com");
        // $db['GOOGLE_CLIENT_SECRET'] = base64_encode("YV9PppIZly96PyGTDIXuV4Ly");
        // $db['GOOGLE_URL'] = base64_encode("https://immigratly.com/login/google/callback");
        // echo json_encode($db);
        // exit;
       //$contens = public_path('uploads/files/26531-2stallions-300x300.jpg');
       //$image = \Storage::disk('s3')->put('26531-2stallions-300x300.jpg', $contens);

        // $image = Image::create([
        //     'filename' => public_path('uploads/files/65912-75910-noc_codes.csv'),
        //     'url' => Storage::disk('s3')->url($path)
        // ]);
       
        $now = \Carbon\Carbon::now();
        $articles = Articles::where("status","publish")
                        ->whereHas("Category")
                        ->orderBy('id','desc')
                        ->limit(4)
                        ->get();
        
        $news = News::where(DB::raw("(STR_TO_DATE(news_date,'%d-%m-%Y'))"), ">=",$now)
                    ->orderBy("id",'desc')
                    ->limit(4)
                    ->get();

        $webinars = Webinar::where("status","publish")
                        ->whereHas("Category")
                        ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now)
                        ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                        ->limit(4)
                        ->get();

        $professionals = Professionals::orderBy('id','desc')
                        ->limit(6)
                        ->get();
       
        $viewData['webinars'] = $webinars;
        $viewData['professionals'] = $professionals;
        $viewData['articles'] = $articles;   
        $viewData['news'] = $news;   
        $viewData['pageTitle'] = "Home Page";   
        return view('frontend.index',$viewData);
     
    }

    public function professionals(){
         
        $countries = Countries::get();
        $states = States::get();
        $professionals = Professionals::orderBy('id','asc')->get();
        $visa_services = VisaServices::get();
        $languages = Languages::get();
        $viewData['visa_services'] = $visa_services;
        $viewData['languages'] = $languages;
        $viewData['countries'] = $countries;
        $viewData['states'] = $states;
        $viewData['professionals'] = $professionals;
        $viewData['pageTitle'] = "Professionals";   
        return view('frontend.professional.list',$viewData);
    }

    public function professionalAjaxList(Request $request){
        
        $search = $request->input();
        $professionals = Professionals::orderBy('id','asc')->get();
        
        $details = array();
        $subdomains = array();
        $available_professional = array();
        foreach ($professionals as $key => $professional) {
            $domain = $professional->subdomain;
            $checkDB = professionalAdmin($domain);
            if(!empty($checkDB)){
                    
                $professionalDetail = professionalDetail($domain);
                $subdomains[] = $domain;
                $flag = 1;
                $record = DB::table(PROFESSIONAL_DATABASE.$domain.".professional_details")
                            ->orderBy('id',"desc")
                            ->where(function($query) use($search){
                        
                                if(isset($search['search_by_keyword']) && $search['search_by_keyword'] != ''){
                                    $query->where("company_name","LIKE","%".$search['search_by_keyword']."%");
                                }
                                if(isset($search['country']) && $search['country'] != '' && $search['country'] != 'all'){
                                    $query->where("country_id",$search['country']);
                                }
                                if(isset($search['state']) && $search['state'] != '' && $search['state'] != 'all'){
                                    $query->where("state_id",$search['state']);
                                }
                            })
                            ->first();
                if(empty($record)){
                    $flag = 0;
                }
                $detail = DB::table(PROFESSIONAL_DATABASE.$domain.".users")
                            ->where(function($query) use($search){
                                if(isset($search['search_by_keyword']) && $search['search_by_keyword'] != ''){
                                    $query->where("first_name","LIKE","%".$search['search_by_keyword']."%");
                                    $query->orWhere("last_name","LIKE","%".$search['search_by_keyword']."%");
                                }
                            })
                            ->where("role","admin")->first();   
                if(!empty($detail)){
                    if(isset($search['language']) && $search['language'] != '' && $search['language'] != 'all'){
                        
                        if($detail->languages_known != ''){
                            $languages_known = json_decode($detail->languages_known,true);
                            if(!in_array($search['language'],$languages_known)){
                                $flag = 0;
                            }
                        }
                    }
                }else{
                    $flag = 0;
                }
                if(isset($search['visa_service']) && $search['visa_service'] != '' && $search['visa_service'] != 'all'){
                    $services = DB::table(PROFESSIONAL_DATABASE.$domain.".professional_services")->pluck("service_id");
                    if(!empty($empty)){
                        $services = $services->toArray();
                        if(!in_arrray($search['visa_service'],$services)){
                            $flag = 0;
                        }
                    }
                }
                if($flag == 1){
                    $record->subdomain = $domain;
                    $record->user_details = $detail;
                    $available_professional[] = $record;
                }
                // $details[] = $detail;

            }        
        }

        $records = $available_professional; 
        $professionals = Professionals::orderBy('id','asc')->get();
        $search = $request->input("search");
        $viewData['records'] = $records;
        $viewData['details'] = $details;
        $viewData['subdomains'] = $subdomains;
        $view = View::make('frontend.professional.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        // $response['last_page'] = $records->lastPage();
        // $response['current_page'] = $records->currentPage();
        // $response['total_records'] = $records->total();
        return response()->json($response);
    }


    public function professionalDetail($subdomain){
        $subdomain = $subdomain;

        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);

        $professional = Professionals::where('subdomain',$subdomain)->first();

        if(!empty($company_data)){    
            $viewData['company_data'] = $company_data;
            $viewData['professional'] = $professional;
            $viewData['professionalAdmin'] = $professionalAdmin;
            $viewData['pageTitle'] = "Professional Detail";   
            $viewData['subdomain'] = $subdomain;
            return view('frontend.professional.detail',$viewData);
        }
        else{
            echo "No Details found";
        }
    }
    
    public function bookAppointmentServices(Request $request,$subdomain,$location_id){
        
        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);
        
        $type = 'services';
        $viewData['type'] = $type;
        $professional_location = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_locations")->where('unique_id',$location_id)->first();
        $professional = Professionals::where('subdomain',$subdomain)->first();
        $viewData['location_id'] = $location_id;
        $viewData['professional_location'] = $professional_location;
        if(!empty($company_data)){    
            
            $data = array();
            $data['get_service_price'] = "1";
            $apiData = professionalCurl('services',$subdomain,$data);
            if(isset($apiData['status']) && $apiData['status'] == 'success'){
                $visa_services = $apiData['data'];
            }else{
                $visa_services = array();
            }
            // pre($visa_services);
            $viewData['visa_services'] = $visa_services;
            $viewData['company_data'] = $company_data;
            $viewData['professional'] = $professional;
            $viewData['professionalAdmin'] = $professionalAdmin;
            $viewData['pageTitle'] = "Book Appointment with ".$company_data->company_name." <small>(".$professional_location->address.")</small>";   
            $viewData['subdomain'] = $subdomain;
            return view('frontend.professional.book-services',$viewData);
        }
        else{
            return redirect()->back()->with("error","Professional Details found");
        }
    }
    public function bookAppointment(Request $request,$subdomain,$location_id){
        if(!$request->get("eid")){
            $check_appointments = ClientAppointments::where("client_id",\Auth::user()->unique_id)
                                                    ->where("appointment_date",">=",date("Y-m-d"))
                                                    ->where("professional",$subdomain)
                                                    ->count();
            
            if($check_appointments > 2){
                return redirect(baseUrl('booked-appointments'))->with("error_message","You already had 3 bookings with the professional");
            }
        }
        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);
        
        if($request->get("service_id")){
            $type = "book_appointment";
            $visa_service = professionalService($subdomain,$request->get("service_id"),'unique_id');
            if(!$request->get("eid")){
            
                $check_appointments = \DB::table(PROFESSIONAL_DATABASE.$subdomain.".booked_appointments")
                                                    ->where("client_id",\Auth::user()->unique_id)
                                                    ->where("appointment_date",">=",date("Y-m-d"))
                                                    ->where("location_id",$location_id)
                                                    ->where("visa_service_id",$request->get("service_id"))
                                                    ->first();
                 if(!empty($check_appointments)){
                    return redirect()->back()->with("error_message","You already had booked appointment with the professional for this service dated on ".dateFormat($check_appointments->appointment_date)." at ".$check_appointments->start_time." to ".$check_appointments->end_time."!");
                }
            }
            
            $viewData['visa_service_id'] = $request->get("service_id");
            $viewData['service'] = $visa_service;
        }else{
            return redirect()->back()->with("error","Service not selected");
        }
        if($request->get("action") == 'edit' && $request->get("eid")){
            $eid = $request->get("eid");
            $viewData['action'] = "edit";
            $viewData['eid'] = $eid;
            $client_appointment = ClientAppointments::where("unique_id",$eid)->first();
            $appointment = $client_appointment->bookingDetail($client_appointment->professional,$client_appointment->booking_id);
            //redirect if edited 3 times
            if($appointment->edit_counter > 2){
                return redirect()->back()->with("error_message","You already edited this appointment 3 times.");
            }
            // end redirect
            $viewData['appointment'] = $appointment;
        }else{
            $viewData['action'] = "add";
            $viewData['eid'] = '';
        }
        $viewData['type'] = $type;
        $data = array();
        $data['service_id'] = $request->get("service_id");
        $apiData = professionalCurl('appointment-types',$subdomain,$data);
        
        
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $appointment_types = $apiData['data'];
        }else{
            $appointment_types = array();
        }
        
        $data = array();
        $data['location_id'] = $location_id;
        $apiData = professionalCurl('appointment-schedules',$subdomain,$data);
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $appointment_schedule = $apiData['data'];
        }else{
            $appointment_schedule = array();
        }
        // $appointment_schedule = DB::table(PROFESSIONAL_DATABASE.$subdomain.".appointment_schedule")->where("location_id",$location_id)->get();
        // $appointment_types = DB::table(PROFESSIONAL_DATABASE.$subdomain.".appointment_types as at")
        //                     ->leftJoin(PROFESSIONAL_DATABASE.$subdomain.".time_duration as td", 'td.unique_id', '=', 'at.duration')
        //                     ->select("at.*,td.name,td.duration")
        //                     ->get();
        // pre($appointment_schedule->toArray());
        // exit;
        $professional_location = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_locations")->where('unique_id',$location_id)->first();
        $professional = Professionals::where('subdomain',$subdomain)->first();
        $viewData['appointment_types'] = $appointment_types;
        $viewData['appointment_schedule'] = $appointment_schedule;
        $viewData['location_id'] = $location_id;
        $viewData['professional_location'] = $professional_location;
        if(!empty($company_data)){    
            
            $data = array();
            $apiData = professionalCurl('services',$subdomain);
            if(isset($apiData['status']) && $apiData['status'] == 'success'){
                $visa_services = $apiData['data'];
            }else{
                $visa_services = array();
            }
            // pre($visa_services);
            $viewData['visa_services'] = $visa_services;
            $viewData['company_data'] = $company_data;
            $viewData['professional'] = $professional;
            $viewData['professionalAdmin'] = $professionalAdmin;
            $viewData['pageTitle'] = "Book Appointment with ".$company_data->company_name." <small>(".$professional_location->address.")</small>";   
            $viewData['subdomain'] = $subdomain;
            return view('frontend.professional.book-appointment',$viewData);
        }
        else{
            return redirect()->back()->with("error","Professional Details found");
        }
    }
    public function fetchHours(Request $request){
        $location_id = $request->input("location_id");
        $month = $request->input("month");
        $year = $request->input("year");
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $professional = $request->input("professional");
        
        $day_schedules = array();
        // $date = $year."-".$month."-01";
        // $start_date = date("Y-m-d",strtotime($date));
        // $end_date = date("Y-m-t",strtotime($date));
        if($request->action == 'edit' && $request->eid != ''){
            $eid = $request->eid;
            $client_appointment = ClientAppointments::where("unique_id",$eid)->first();
            $appointment = \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")->where("unique_id",$client_appointment->booking_id)->first();
            $appointment_date = $appointment->appointment_date;
        }else{
            $appointment_date = '';
        }
        $dates = getBetweenDates($start_date,$end_date);
        
        for($d=0;$d < count($dates);$d++){
            $day = date("l",strtotime($dates[$d]));
            $hours = \DB::table(PROFESSIONAL_DATABASE.$professional.".appointment_schedule")
                    ->where("location_id",$location_id)
                    ->where("day",strtolower($day))
                    ->first();
            $custom_time = \DB::table(PROFESSIONAL_DATABASE.$professional.".custom_time")
                    ->where("custom_date",$dates[$d])
                    ->where("location_id",$location_id)
                    ->first();
            if(!empty($custom_time)){
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
                    $temp['title'] = strip_tags($custom_time->description);
                    $temp['className'] = 'text-danger day-off';
                    $day_schedules[] = $temp;
                }
            }else{
                if(!empty($hours)){
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

            $booked_appointment = \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")
                                                    ->where("appointment_date",$dates[$d])
                                                    ->where("location_id",$location_id)
                                                    ->count();
            if($booked_appointment > 0){
                $temp = array();
                $temp['start'] = $dates[$d];
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
        $response['schedule'] = $day_schedules;

        return response()->json($response);
    }
    public function fetchAvailabilityHours(Request $request){
        $date = $request->input("date");
        $schedule_id = $request->input("schedule_id");
        $service_id = $request->input("service_id");
        $break_time = $request->input("break_time");
        $price = $request->input("price");
        $professional = $request->input("professional");
        if($request->input("time_type")){
            $time_type = $request->input("time_type");
        }else{
            $time_type = 'default';
        }

        if($request->get("action") == 'edit' && $request->get("eid")){
            $eid = $request->get("eid");
            $viewData['action'] = "edit";
            $viewData['eid'] = $eid;
            $client_appointment = ClientAppointments::where("unique_id",$eid)->first();
            $appointment = \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")->where("unique_id",$client_appointment->booking_id)->first();
            // $appointment = BookedAppointments::where("unique_id",$eid)->first();
            $viewData['appointment'] = $appointment;
        }else{
            $viewData['action'] = "add";
            $viewData['eid'] = '';
        }

        
        $date = $request->input("date");
        $location_id = $request->input("location_id");
        $appointment_type_id = $request->input("appointment_type_id");
        $visa_service = professionalService($professional,$service_id,'unique_id');
        $data = array();
        $data['return'] = 'single';
        $data['id'] = $appointment_type_id;
        $apiData = professionalCurl('appointment-types',$professional,$data);
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $appointment_type = $apiData['data'];
        }else{
            $appointment_type = array();
        }
        $data = array();
        $data['schedule_id'] = $schedule_id;
        $data['time_type'] = $time_type;
        $data['return'] = 'single';
        $apiData = professionalCurl('appointment-schedules',$professional,$data);
      
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $appointment_schedule = $apiData['data'];
        }else{
            $appointment_schedule = array();
        }
        // pre($visa_services);
        $viewData['visa_service'] = $visa_service;
        // $appointment_schedule = \DB::table(PROFESSIONAL_DATABASE.$professional.".appointment_schedule")
        //             ->where("id",$schedule_id)
        //             ->first();
        // $appointment_type = \DB::table(PROFESSIONAL_DATABASE.$professional.".appointment_types")
        //             ->where("unique_id",$appointment_type_id)
        //             ->first();
        
        $type = $appointment_type['time_duration']['type'];
        if($type == 'minutes'){
            $interval = $appointment_type['time_duration']['duration'];
        }else{
            $interval = $appointment_type['time_duration']['duration'] * 60;
        }
        
        
        $from_time = $appointment_schedule['from_time'];
        $to_time = $appointment_schedule['to_time'];
        $booked_slots = \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")
                                        ->where("location_id",$location_id)
                                        ->whereDate("appointment_date",$date)
                                        ->get();
        // if(!empty($booked_slots)){
        //     $booked_slots = $booked_slots->toArray();
        // }else{
        //     $booked_slots = array();
        // }
        $book_slots = array();
        foreach($booked_slots as $b_slot){
            $temp = new \stdClass();
            $temp->from_time = $b_slot->start_time;
       
            $temp->to_time = date("h:i",strtotime($b_slot->end_time." +".$b_slot->break_time." minutes"));
            $book_slots[] = $temp;
        }

        $custom_times = \DB::table(PROFESSIONAL_DATABASE.$professional.".custom_time")
                    ->where("custom_date",$date)
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
        if(!empty($book_slots)){
            asort($book_slots);
            $array_of_time = array();
            $book_slots = array_values($book_slots);
            foreach($book_slots as $key => $slot){
                if($key == 0){
                    $app_from_time = $from_time;
                    $app_to_time = $slot->from_time;
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
        $viewData['price'] = $price;
        $viewData['break_time'] = $break_time;
        $viewData['date'] = date("F d, Y",strtotime($date));
        $viewData['time_slots'] = $time_slots;
        $viewData['schedule_id'] = $schedule_id;
        $viewData['location_id'] = $location_id;
        $viewData['interval'] = $interval;
        $viewData['professional'] = $professional;
        $viewData['time_type'] = $time_type;
        
        $viewData['date'] = $date;
        $viewData['appointment_type_id'] = $appointment_type_id;
        $viewData['pageTitle'] = "Selct Your Time Slot";
        $view = View::make('frontend.professional.time-slots',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }
    public function timeSlot($start_time,$end_time,$add_mins){
        $array_of_time = array();
        while ($start_time <= $end_time) // loop between time
        {
           $array_of_time[] = date("h:i", $start_time);
           $start_time += $add_mins; // to check endtie=me
        }
        return $array_of_time;

    }

    public function placeBooking(Request $request){

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
        $duration = explode("-",$request->input("duration"));
        
        $apiData = $request->all();
        $professional = $request->input("professional");
        if($request->input("action") == 'edit'){
            $eid = $request->input("eid");
            $client_appointment = ClientAppointments::where("unique_id",$eid)->first();
            $object = \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")->where("unique_id",$client_appointment->booking_id)->first();
            $appointment = $object;
            $booking_id = $object->unique_id;
            if($object->edit_counter > 2)
            {
                $response['status'] = true;
                $response['message'] = "Your edit limit exceed. You cannot edit appointment any more";
                $response['redirect_back'] = baseUrl('booked-appointments');
                return response()->json($response);    
            }
            else
            {   
                \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")->where("unique_id",$client_appointment->booking_id)->update(['edit_counter'=>$object->edit_counter+1]);
                
            }
            $apiData['eid'] = $booking_id;
        }
        
        unset($apiData['_token']);
        $apiData['user_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('save-appointment',$professional,$apiData);
        
        // else{
        //     $appointment = array();
        //     $booking_id = randomNumber();
        //     $inv_unique_id = randomNumber();
        //     $object = new BookedAppointments();
        //     $object->unique_id = $booking_id;
        // }
        
        
        // $object->professional = $request->input("professional");
        // $object->location_id = $request->input("location_id");
        // $object->break_time = $request->input("break_time");
        
        // $object->visa_service_id = $request->input("visa_service");
        // $object->appointment_date = $request->input("date");
        // $object->appointment_type_id = $request->input("appointment_type_id");
        // $object->user_id = \Auth::user()->unique_id;
        // $object->status = 'awaiting';
        // if($request->input("price") > 0){
        //     $object->payment_status = 'pending';
        // }else{
        //     $object->payment_status = 'paid';
        // }
        // $object->schedule_id = $request->input("schedule_id");
        // $object->time_type = $request->input("time_type");
        
        // $object->price = $request->input("price");
        // $object->meeting_duration = $request->input("interval");
        // $object->start_time = $duration[0];
        // $object->end_time = $duration[1];
        // if($request->input("action") == 'add'){
        //     $object->invoice_id = $inv_unique_id;
        // }
        // $object->save();

                
        // if($request->input("action") == 'edit'){
        //     $object2 = UserInvoices::where("link_id",$booking_id)->where("link_to","appointment")->first();
        //     $inv_unique_id = $object2->unique_id;
        // }else{
        //     $object2 = new UserInvoices();
        //     $object2->unique_id = $inv_unique_id;
        // }
        // $object2->client_id = \Auth::user()->unique_id;
        // $object2->payment_status = "pending";
        // $object2->amount = $request->input("price");
        // $object2->link_to = 'appointment';
        // $object2->link_id = $booking_id;
        // $object2->invoice_date = date("Y-m-d"); 
        // $object2->created_by = \Auth::user()->unique_id;
        // $object2->save();

        // if($request->input("action") == 'edit'){
        //     $object2 = InvoiceItems::where("invoice_id",$inv_unique_id)->first();
        // }else{
        //     $object2 = new InvoiceItems();
        //     $object2->invoice_id = $inv_unique_id;
        //     $object2->unique_id = randomNumber();
        // }
        
        // $object2->particular = "Appointment Fee";
        // $object2->amount = $request->input("price");
        // $object2->save();

        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $booking_id = $api_response['booking_id'];
            $response['status'] = true;
            $response['message'] = "Your time slot is booked successfully. Team will contact you soon!";
            \Session::flash("success_message", "Your time slot is booked successfully. Team will contact you soon!");

            if($request->input("action") == 'edit'){
                if($appointment->price == 0 &&  $request->input("price") > 0){
                    $response['redirect_back'] = url('pay-for-appointment/'.$professional.'/'.$booking_id);
                }else{
                    $response['redirect_back'] = baseUrl('booked-appointments');
                }
            }else{
                if($request->input("price") > 0){
                    $response['redirect_back'] = url('pay-for-appointment/'.$professional.'/'.$booking_id);
                }else{
                    $response['redirect_back'] = baseUrl('booked-appointments');
                }
            }
            $subdomain =  $request->input("professional");
            $company_data = professionalDetail($subdomain);
            $professionalAdmin = professionalAdmin($subdomain);
            
            $start_time = $duration[0]; 
            $end_time = $duration[1];
            $date = $request->input("date");
            $email = \Auth::user()->email;
            $mailData['mail_message'] = "You booked an appointment for ".$date." from ".$start_time." to ".$end_time." with professional ".$company_data->company_name.". Professional  will confirm and reply you soon You will be notified by the professional."; 
            $view = View::make('emails.notification',$mailData);
            $message = $view->render();
            $parameter['to'] = $email;
            $parameter['to_name'] = '';
            $parameter['message'] = $message;
            if($request->input("action") == 'edit'){
                $parameter['subject'] = "Appointment reschedule with Professional from Immigratly";
            }else{
                $parameter['subject'] = "Appointment booked with Professional from Immigratly";
            }
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
           
            $mailRes = sendMail($parameter);

            $parameter = array();
            $mailData = array();
            if($request->input("action") == 'edit'){
                $mailData['mail_message'] = "Client ".\Auth::user()->first_name." ".\Auth::user()->last_name." has reschedule an appointment for ".$date." from ".$start_time." to ".$end_time.". Appointment ID is ".$booking_id;

            }else{
                $mailData['mail_message'] = "Client ".\Auth::user()->first_name." ".\Auth::user()->last_name." booked an appointment for ".$date." from ".$start_time." to ".$end_time.". Appointment ID is ".$booking_id;
            }
            $view = View::make('emails.notification',$mailData);
            $message = $view->render();
            $parameter['to'] = $professionalAdmin->email;
            $parameter['to_name'] = '';
            $parameter['message'] = $message;
            if($request->input("action") == 'edit'){
                $parameter['subject'] = "Appointment reschedule by Client from Immigratly";
            }else{
                $parameter['subject'] = "Appointment booked by Client from Immigratly";
            }
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
           
            $mailRes = sendMail($parameter);
        }else{
            $response['status'] = false;
            $response['message'] = "Issue while booking appointment.";
        }
        return response()->json($response);
    }

    public function appointmentPayment($subdomain,$booking_id){
        $appointment = \DB::table(PROFESSIONAL_DATABASE.$subdomain.".booked_appointments")->where("unique_id",$booking_id)->first();
        
        $invoice =  \DB::table(PROFESSIONAL_DATABASE.$subdomain.".invoices")->where("unique_id",$appointment->invoice_id)->first();
        if(empty($appointment)){
            return redirect()->back()->with("error","Invalid Appointment");
        }
        $user = array();
        $user_type = '';
        if($appointment->lead_id != ''){
            $user = \DB::table(PROFESSIONAL_DATABASE.$subdomain.".leads")->where("unique_id",$appointment->lead_id)->first();
            $user_type = 'lead';
        }
        if($appointment->client_id != ''){
            $user = User::where("unique_id",$appointment->client_id)->first();
            $user_type = 'client';
        }
        
        if(Auth::check()){
            if(!empty($invoice) && $invoice->payment_status == 'paid'){
                return redirect(baseUrl('booked-appointments'));
            }
            $checkAppointment = ClientAppointments::where("professional",$subdomain)->where("booking_id",$booking_id)->first();
            if(empty($checkAppointment)){
                $client_appointment = new ClientAppointments();
                $client_appointment->unique_id = randomNumber();
            }else{
                $client_appointment = ClientAppointments::find($checkAppointment->id);
            }
            $client_appointment->professional = $subdomain;
            $client_appointment->booking_id = $booking_id;
            $client_appointment->appointment_date = $appointment->appointment_date;
            $client_appointment->start_time = $appointment->start_time;
            $client_appointment->end_time = $appointment->end_time;
            $client_appointment->status = "pending";
            $client_appointment->client_id = \Auth::user()->unique_id;
            $client_appointment->save();

            \DB::table(PROFESSIONAL_DATABASE.$subdomain.".booked_appointments")->where("unique_id",$booking_id)->update(['client_id'=>\Auth::user()->unique_id]);
        }
        $pay_amount = $appointment->price;  
        $viewData['pageTitle'] = "Pay for appointment";
        // $pay_amount = 0;
        $viewData['user_type'] = $user_type;
        $viewData['appointment'] = $appointment;
        $viewData['pay_amount'] = $pay_amount;
        $viewData['subdomain'] = $subdomain;
        $viewData['invoice_id'] = $invoice->unique_id;
        return view('frontend.professional.appointment-payment',$viewData);
    }
    public function articles($category=''){
        if($category != ''){
            $visa_service = VisaServices::where("slug",$category)->first();
            $articles = Articles::orderBy('id','desc')
                        ->whereHas("Category")
                        ->where("category_id",$visa_service->id)
                        ->where("status",'publish')
                        ->paginate();
        }else{
            $articles = Articles::orderBy('id','desc')
                        ->where("status",'publish')
                        ->whereHas("Category")
                        ->paginate();
        }
        
        $viewData['articles'] = $articles;   
        $viewData['pageTitle'] = "Articles";   
        $services = VisaServices::whereHas('Articles')->get();
        $viewData['services'] = $services;
        return view('frontend.articles.articles',$viewData);
    }   

    public function articleSingle($slug){
         $article = Articles::where('slug',$slug)->first();
         if(empty($article)){
            return redirect('/');   
         }
         $viewData['article'] = $article;   
         $viewData['pageTitle'] = $article->title;   
         return view('frontend.articles.article-single',$viewData);
    }

    public function webinars($category=''){
        $now = \Carbon\Carbon::now();
        if($category != ''){
            $visa_service = VisaServices::where("slug",$category)->first();
            
            $webinars = Webinar::where("status","publish")
                        ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now) 
                        ->where("category_id",$visa_service->id)
                        ->where("status",'publish')
                        ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                        ->paginate();
        }else{
            $webinars = Webinar::where("status","publish")
                        ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now) 
                        ->where("status",'publish')
                        ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                        ->paginate();
        }
        

        $viewData['webinars'] = $webinars;   
        $viewData['pageTitle'] = "Webinars";   
        $services = VisaServices::whereHas('Webinars')->get();
        $viewData['services'] = $services;
        return view('frontend.webinar.webinar',$viewData);
    }   

    public function webinarSingle($slug){
         $webinar = Webinar::where('slug',$slug)->first();
         if(empty($webinar)){
            return redirect('/');   
         }
         $viewData['webinar'] = $webinar;   
         $viewData['pageTitle'] = $webinar->title;   
         return view('frontend.webinar.webinar-single',$viewData);
    }
    public function discussions(){
        $viewData['pageTitle'] = "Discussions Topics";   
        return view('frontend.discussions.discussions',$viewData);
    }

    public function fetchTopics(Request $request){
        $search = $request->input("search");
        $discussions = ChatGroups::with('User')
                                ->where("status","open")
                                ->where(function($query) use($search){
                                    if($search != ''){
                                        $query->where("group_title","LIKE","%$search%");
                                        $query->orWhere("description","LIKE","%$search%");
                                    }
                                })
                                ->paginate(2);

        $viewData['discussions'] = $discussions;
        $view = View::make('frontend.discussions.topic-list',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        $response['last_page'] = $discussions->lastPage();
        $response['current_page'] = $discussions->currentPage();
        $next_page = $discussions->currentPage() + 1;
        $response['next_page'] = $next_page;
        $response['total_records'] = $discussions->total();
        return response()->json($response);
    }

    public function topicDetails($slug){
        $viewData['pageTitle'] = "Discussions Topics";   
        $discussions = ChatGroups::with('User')
                                ->where("slug",$slug)
                                ->first();

        $viewData['record'] = $discussions;
        return view('frontend.discussions.topic-detail',$viewData);
    }

    public function fetchComments(Request $request){
        $chat_id = $request->input("chat_id");
        $comments = ChatGroupComments::with('User')->where("chat_id",$chat_id)->get();
        $viewData['comments'] = $comments;
        $view = View::make('frontend.discussions.comments',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function sendComment(Request $request){

        $object = new ChatGroupComments();
        $unique_id = randomNumber();
        $object->unique_id = $unique_id;
        $object->chat_id = $request->input("chat_id");
        if($request->input("message")){
            $message = $request->input("message");
            $object->message = $message;
        }
        
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = public_path("/uploads/files");
                if($file->move($destinationPath, $newName)){
                    $object->file_name = $newName;
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
                return response()->json($response);
            } 
        }
        $object->send_by = \Auth::user()->unique_id;
        $object->user_type = "user";
        $object->save();

        $response['status'] = true;
        $response['message'] = "Comment added successfully";

        return response()->json($response);
    }

    public function sendVerifyCode(Request $request){
        $validator = Validator::make($request->all(), [
            'value' => 'required',
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

        $value = $request->input("value");
        $verify_type = explode(":",$value);
        \Session::forget("verify_code");
        \Session::forget("service_code");
        if($verify_type[0] == 'mobile_no'){
            if($request->input("check") == 'user'){
                $checkExists = User::whereRaw("CONCAT(`country_code`, `phone_no`) = ?", [$verify_type[1]])->count();
            }else{
                $checkExists = Professionals::whereRaw("CONCAT(`country_code`, `phone_no`) = ?", [$verify_type[1]])->count();
            }
          
            if($checkExists > 0){
                $response['status'] = false;
                $response['message'] = "Mobile exists try another number";
                return response()->json($response);
            }
            $return = sendVerifyCode($verify_type[1]);
            
            if($return['status'] == 1){
                $response['status'] = true;
                \Session::put("service_code",$return['service_code']);
                $response['message'] = $return['message'];
            }else{
                $response['status'] = false;
                $response['message'] = $return['message'];
            }
            return response()->json($response);
        }else{
            if($request->input("check") == 'user'){
                $checkExists = User::where("email",$verify_type[1])->count();
            }else{
                $checkExists = Professionals::where("email",$verify_type[1])->count();
            }
            
            if($checkExists > 0){
                $response['status'] = false;
                $response['message'] = "Email already exists try another email";
                return response()->json($response);
            }
            \Session::forget("verify_code");
            $verify_code = mt_rand(100000,999999);
            
            $mailData['verify_code'] = $verify_code;
            $view = View::make('emails.verify-code',$mailData);
            $message = $view->render();
            $parameter['to'] = $verify_type[1];
            $parameter['to_name'] = '';
            $parameter['message'] = $message;
            $parameter['subject'] = companyName()." verfication code";
            // echo $message;
            // exit;
            $parameter['view'] = "emails.verify-code";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);
            // $mailRes['status'] = true;
            // $response['status'] = true;
            // $response['verify_code'] = $verify_code;
            // $response['message'] = "<h2>User Code: ".$verify_code."</h2>";
            \Session::put("verify_code",$verify_code);
            if($mailRes['status'] == true){
                \Session::put("verify_code",$verify_code);
                $response['status'] = true;
                $response['message'] = "Check your email for verfication code";
                $response['otp'] = $verify_code;
            }else{
                $response['status'] = true;
                $response['verify_code'] = $verify_code;
                $response['message'] = $mailRes['message']." <h2>CODE: ".$verify_code."</h2>";
            }
            return response()->json($response);
        }
    }

    public function externalAssessment($assessment_id,Request $request){
        $record = DB::table(MAIN_DATABASE.".assessment_forms")
                    ->where("uuid",$assessment_id)
                    ->first();
        
        $form_json = $record->form_json;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $checkExist = array();
        if(\Auth::check()){
            
            $checkExist = DB::table(MAIN_DATABASE.".external_assessments")
                        ->where("form_id",$record->unique_id)
                        ->where("user_id",\Auth::user()->unique_id)
                        ->first();
            
        }
        if(!empty($checkExist)){
            $viewData['already_filled'] = 1;
        }else{
            $viewData['already_filled'] = 0;
        }
        $viewData['form_json'] = $form_json;
        $viewData['countries'] = $countries;
        $viewData['record'] = $record;
        $viewData['assessment_id'] = $assessment_id;
        $query_string = "?assessment_id=".$assessment_id;
        $viewData['query_string'] = $query_string;
        $viewData['pageTitle'] = "Assessment Form";
        
        return view('frontend.assessment.assessment',$viewData);
    }

    public function saveExternalAssessment($assessment_id,Request $request)
    {
        $record = DB::table(MAIN_DATABASE.".assessment_forms")->where("uuid",$assessment_id)->first();
        $assessment = DB::table(MAIN_DATABASE.".assessments")->where("unique_id",$record->assessment_id)->first();
        $lead_tbl = PROFESSIONAL_DATABASE.$assessment->professional.".leads";
        $checkLead = DB::table($lead_tbl)->where("email",$request->input("email"))->first();
        if(!empty($checkLead)){
            $unique_id = $checkLead->unique_id;
            $email_required = 'required|email';
            $phone_no_required = 'required|numeric';
        }else{
            $email_required = 'required|email';
            $phone_no_required = 'required|numeric';
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => $email_required,
            'country_code' => 'required',
            'phone_no' => $phone_no_required,
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
        $postData = $request->all();
        
        unset($postData['_token']);
        unset($postData['first_name']);
        unset($postData['last_name']);
        unset($postData['email']);
        unset($postData['country_code']);
        unset($postData['phone_no']);
        
        // AssessmentForms::where("unique_id",$id)->first();
        $form_json = json_decode($record->form_json,true);
        $form_reply = array();
        foreach($form_json as $form){
            $temp = array();
            $temp = $form;
            if(isset($form['name']) && isset($postData[$form['name']])){
                if(isset($form['values'])){
                    $values = $form['values'];
                    $final_values = array();
                    foreach($values as $value){
                        $tempVal = $value;
                        if(is_array($postData[$form['name']])){
                            if(in_array($value['value'],$postData[$form['name']])){
                                $tempVal['selected'] = 1;
                            }else{
                                $tempVal['selected'] = 0;
                            }
                        }else{
                            if($value['value'] == $postData[$form['name']]){
                                $tempVal['selected'] = 1;
                                if($form['type'] == 'autocomplete'){
                                    $temp['value'] = $value['label'];
                                }
                            }else{
                                $tempVal['selected'] = 0;
                            }
                        }
                        $final_values[] = $tempVal;
                    }
                    $temp['values'] = $final_values;
                }else{
                    $temp['value'] = $postData[$form['name']];
                }
            }
            $form_reply[] = $temp;
        }
       
        if(!empty($postData)){
            
            $object = array();
            
            $object['first_name'] = $request->input("first_name");
            $object['last_name'] = $request->input("last_name");
            $object['email'] = $request->input("email");
            $object['country_code'] = $request->input("country_code");
            $object['phone_no'] = $request->input("phone_no");
            $object['visa_service_id'] = $assessment->visa_service_id;
            

            $checkLead = DB::table(PROFESSIONAL_DATABASE.$assessment->professional.".leads")->where("email",$request->input("email"))->first();

            if(!empty($checkLead)){
                $unique_id = $checkLead->unique_id;
                DB::table(PROFESSIONAL_DATABASE.$assessment->professional.".leads")
                ->where("unique_id",$unique_id)
                ->update($object);
            }else{
                $unique_id = randomNumber();    
                $object['unique_id'] = $unique_id;
                
                DB::table(PROFESSIONAL_DATABASE.$assessment->professional.".leads")->insert($object);
            }    
            $insData = array();
            
            $insData['lead_id'] = $unique_id;
            $insData['unique_id'] = randomNumber();
            $insData['form_id'] = $record->unique_id;
            $insData['assessment_id'] = $record->assessment_id;
            $insData['created_at'] = date("Y-m-d H:i:s");
            $insData['updated_at'] = date("Y-m-d H:i:s");
            $insData['form_reply'] = json_encode($postData);
            $insData['user_id'] = \Auth::user()->unique_id;
            $insData['subdomain'] = $assessment->professional;
            DB::table(MAIN_DATABASE.".external_assessments")->insert($insData);
            // $object->form_reply = json_encode($postData);
            // $object->save();
            $response['status'] = true;
            $response['message'] = "Record saved successfully";
            return response()->json($response);
        }else{
            $response['status'] = false;
            $response['message'] = "Form fields are required";
            return response()->json($response);
        }
    }
    

    // ************* 28-8-update by y

    public function visaServices($slug){
        
        $visaService = VisaServices::where('slug',$slug)->first();
        $question_sequence = ArrangeGroups::where("visa_service_id",$visaService->unique_id)
                                        ->orderBy("sort_order","asc")
                                        ->get();
        $viewData['pageTitle'] = "Visa Services Content";   
        $record = VisaServiceContent::where('visa_service_id',$visaService->id)->get();
        $viewData['visaServices'] = $visaService;
        $viewData['records'] = $record;
      
        return view('frontend.visa-services.content-detail',$viewData);

    }
    public function ReviewProfessional($unique_id){
        $unique_id = $unique_id;

        //$professional = User::where('role','professional')->where('unique_id',$unique_id)->first();

        //print_r($professional);
        //exit;

        $professional = Professionals::where('unique_id',$unique_id)->first();

        $domain = $professional->subdomain;
        $checkDB = professionalAdmin($domain);
        if(!empty($checkDB)){
                    
                $professionalDetail = professionalDetail($domain);
                $subdomains[] = $domain;
                $flag = 1;
                $professionalDetails = DB::table(PROFESSIONAL_DATABASE.$domain.".professional_details")->orderBy('id',"desc")->first();
        }

        $viewData['professionalDetails'] = $professionalDetails;
        $reviewData = ProfessionalReview::where('professional_id',$unique_id)->get();

        $total = 0;
        $totalRec = 0;
        foreach ($reviewData as $key => $r) {
            $total += $r->rating;
            $totalRec += 1;
        }
        if($totalRec > 0){
            $avg = $total/$totalRec;
        }else{
            $avg = 0;
        }
        $avg = round($avg);
        
        $viewData['record'] =  $professional;
        $viewData['pageTitle'] = "Send Review";   
        $viewData['reviewData'] = $reviewData;
        $viewData['unique_id'] = $unique_id;
        $viewData['avgRating'] = $avg;
        $viewData['totaluser'] = $totalRec;   
        $viewData['total'] = $totalRec;
        $viewData['professionalDetail'] = $professionalDetail;

        return view('frontend.professional.review',$viewData);
        
    }

    public function sendReviewProfessional($unique_id,Request $request){

        //echo $unique_id;
        //exit;

        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'stars' => 'required',
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
        //$unique_id = $unique_id;
        $rating = $request->input("rating");
        $review = $request->input("review");
        $uid = \Auth::user()->unique_id;
        $object = new ProfessionalReview;
        $object->user_id = $uid;
        $object->professional_id = $unique_id;
        $object->rating = $rating;
        $object->review = $review;
        $object->save();


        $response['status'] = true;
        $response['redirect_back'] = Url('professional/write-review/'.$unique_id);
        $response['message'] = "Review sent";
        return response()->json($response);

    }
    
    public function caseWithProfessional($subdomain,Request $request){

        $data = array();
        $apiData = professionalCurl('services',$subdomain);
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $visa_services = $apiData['data'];
        }else{
            $visa_services = array();
        }
        $viewData['visa_services'] = $visa_services;
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "Post a Case";
        $view = View::make('user.cases.modal.create-case',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }
    public function saveCaseWithProfessional($subdomain,Request $request){

        $validator = Validator::make($request->all(), [
            'case_title' => 'required',
            'description' => 'required',
            'visa_service_id' => 'required',
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
        
        unset($apiData['_token']);
        $apiData['subdomain'] = $subdomain;
        $apiData['client_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('cases/create-case',$subdomain,$apiData);
       
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $check = UserWithProfessional::where("professional",$subdomain)->where("user_id",\Auth::user()->unique_id)->count();
            // $user = UserWithProfessional::firstOrNew(array('professional' => $subdomain,"user_id"=>\Auth::user()->unique_id));
            if($check == 0){
                $object = new UserWithProfessional();
                $object->professional = $subdomain;
                $object->user_id = \Auth::user()->unique_id;
                $object->save();
            }
            $response['status'] = true;
            $response['message'] = "Case posted successfully";
        }else{
            $response['status'] = false;
            $response['message'] = "Something went wrong while posting case. Try again";
        }
        return response()->json($response);
    }
}
