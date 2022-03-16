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

    public function index(){
        return redirect("signup/user");
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
    
    public function bookAppointment($subdomain,$location_id){
        $subdomain = $subdomain;

        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);

     
        $apiData = professionalCurl('appointment-types',$subdomain);
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
            
            $viewData['company_data'] = $company_data;
            $viewData['professional'] = $professional;
            $viewData['professionalAdmin'] = $professionalAdmin;
            $viewData['pageTitle'] = "Book Appointment with ".$company_data->company_name." <small>(".$professional_location->address.")</small>";   
            $viewData['subdomain'] = $subdomain;
            return view('frontend.professional.book-appointment',$viewData);
        }
        else{
            echo "No Details found";
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
        $dates = getBetweenDates($start_date,$end_date);
        
        for($d=0;$d < count($dates);$d++){
            $day = date("l",strtotime($dates[$d]));
            $hours = \DB::table(PROFESSIONAL_DATABASE.$professional.".appointment_schedule")
                    ->where("location_id",$location_id)
                    ->where("day",strtolower($day))
                    ->first();
            if(!empty($hours)){
                $temp = array();
                $temp['start'] = $dates[$d];
                $temp['end'] = $dates[$d];
                $temp['id'] = $hours->id;
                $temp['title'] = "Working Hours \n".$hours->from_time." to ".$hours->to_time;
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
        $professional = $request->input("professional");
        $date = $request->input("date");
        $location_id = $request->input("location_id");
        $appointment_type_id = $request->input("appointment_type_id");

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
        $data['return'] = 'single';
        $apiData = professionalCurl('appointment-schedules',$professional,$data);
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $appointment_schedule = $apiData['data'];
        }else{
            $appointment_schedule = array();
        }
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
        $booked_slots = BookedAppointments::where("professional",$professional)
                                        ->where("location_id",$location_id)
                                        ->whereDate("appointment_date",$date)
                                        ->get();
        if(!empty($booked_slots)){
            $booked_slots = $booked_slots->toArray();
        }else{
            $booked_slots = array();
        }
        pre($booked_slots);
        $time_slots = getTimeSlot($interval,$from_time,$to_time);
        $viewData['date'] = date("F d, Y",strtotime($date));
        $viewData['time_slots'] = $time_slots;
        $viewData['schedule_id'] = $schedule_id;
        $viewData['location_id'] = $location_id;
        $viewData['professional'] = $professional;
        $viewData['date'] = $date;
        $viewData['appointment_type_id'] = $appointment_type_id;
        $viewData['pageTitle'] = "Selct Your Time Slot";
        $view = View::make('frontend.professional.time-slots',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function placeBooking(Request $request){
        $duration = explode("-",$request->input("duration"));
        $object = new BookedAppointments();
        $object->unique_id = randomNumber();
        $object->professional = $request->input("professional");
        $object->location_id = $request->input("location_id");
        $object->appointment_date = $request->input("date");
        $object->user_id = \Auth::user()->unique_id;
        $object->status = 'awaiting_approval';
        $object->start_time = $duration[0];
        $object->end_time = $duration[1];
        $object->save();
        $response['status'] = true;
        $response['message'] = "Your time slot is booked successfully. Team will contact you soon!";
        return response()->json($response);
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
    // ************* END 28-8-update by y    
}
