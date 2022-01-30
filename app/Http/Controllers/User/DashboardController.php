<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\Languages;
use App\Models\Notifications;
use App\Models\LanguageProficiency;
use App\Models\ClientExperience;
use App\Models\CanadianEquivalencyLevel;
use App\Models\ClientEducations;
use App\Models\PrimaryDegree;
use App\Models\BackupSettings;
use App\Models\UserReminderNotes;
use App\Models\UserLanguageProficiency;

use App\Models\OfficialLanguages;
use App\Models\NocCode;
use App\Models\CvTypes;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function dashboard()
    {
        $viewData['pageTitle'] = "Dashboard";
        $viewData['activeTab'] = 'dashboard';
        return view(roleFolder().'.dashboard',$viewData);
    }

    public function completeProfile(Request $request){

        $id = \Auth::user()->id;

        $viewData['pageTitle'] = "Complete Profile";
        $record = User::where("id",$id)->first();
        $record2 = UserDetails::where("user_id",$record->unique_id)->first();

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $viewData['cv_types'] = CvTypes::get();
        if(!empty($record2))
        {
            $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record2->country_id)->get();
            $viewData['states'] = $states;
            $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record2->state_id)->get();
            $viewData['cities'] = $cities;
        }


        $languages = Languages::get();
        $viewData['languages'] = $languages;

        $viewData['countries'] = $countries;
        
        $viewData['record'] = $record;
        $viewData['record2'] = $record2;

        return view(roleFolder().'.complete-profile',$viewData);
    }
    
    public function saveProfile(Request $request){
        // pre($request->all());
        $id = \Auth::user()->id;
        $object =  User::find($id);

        $username = $object->name;
        $object2 = UserDetails::where('user_id',$object->unique_id)->first();

        if(empty($object2))
        {
            $object2 = new UserDetails();
        }else{
            $object2 = UserDetails::find($object2->id);
            
        }
        
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|unique:users,email,'.$object->id,
            // 'first_name' => 'required',
            // 'last_name' => 'required',
            // 'country_code' => 'required',
            // 'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            // 'termsCheckbox'=>'required',
            'country_id'=>'required',
            'cv_type'=>'required',
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
       
        // $object->first_name = $request->input("first_name");
        // $object->last_name = $request->input("last_name");
        // // $object->email = $request->input("email");
        // $object->country_code = $request->input("country_code");
        // $object->phone_no = $request->input("phone_no");
        
        
        // $object->save();
    
        $object2->user_id = \Auth::user()->unique_id;
        $object2->profile_complete = 1;
        $object2->date_of_birth = $request->input("date_of_birth");
        $object2->gender = $request->input("gender");
        $object2->cv_type = $request->input("cv_type");
        $object2->country_id = $request->input("country_id");
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/');
        $response['message'] = "Profile successfully completed";
        
        return response()->json($response);
    }

    public function editProfile(Request $request){

        $id = \Auth::user()->id;

        $viewData['pageTitle'] = "Edit Profile";
        $viewData['activeTab'] = "edit-profile";
        $record = User::where("id",$id)->first();
        $record2 = UserDetails::where("user_id",$record->unique_id)->first();

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $viewData['cv_types'] = CvTypes::get();
        if(!empty($record2))
        {
            $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record2->country_id)->get();
            $viewData['states'] = $states;
            $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record2->state_id)->get();
            $viewData['cities'] = $cities;
        }


        $languages = Languages::get();
        $viewData['languages'] = $languages;

        $viewData['countries'] = $countries;
        
        $viewData['record'] = $record;
        $viewData['record2'] = $record2;

        return view(roleFolder().'.edit-profile',$viewData);
    }
    
    public function updateProfile(Request $request){
        // pre($request->all());
        $id = \Auth::user()->id;
        $object =  User::find($id);

        $username = $object->name;
        $object2 = UserDetails::where('user_id',$object->unique_id)->first();

        if(empty($object2))
        {
            $object2 = new UserDetails();
        }else{
            $object2 = UserDetails::find($object2->id);
            
        }
        
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            // 'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            // 'cv_type'=>'required',
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
       
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        // $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = userDir()."/profile";
            
            $destinationPath = $path.'/thumb';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 100,100,80);

            $destinationPath = $path.'/medium';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 500,500,80);
            $destinationPath = userDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;                    
            }
        }
        $object->save();
    
        $object2->user_id = \Auth::user()->unique_id;
        $object2->profile_complete = 1;
        $object2->date_of_birth = $request->input("date_of_birth");
        $object2->gender = $request->input("gender");
        $object2->cv_type = $request->input("cv_type");
        $object2->country_id = $request->input("country_id");
        $object2->state_id = $request->input("state_id");
        $object2->city_id = $request->input("city_id");
        $object2->address = $request->input("address");
        if($request->address_2){
            $object2->address_2 = $request->input("address_2");
        }
        $object2->zip_code = $request->input("zip_code");
        $object2->languages_known = json_encode($request->input("languages_known"));
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/edit-profile');
        $response['message'] = "Profile updated sucessfully";
        
        return response()->json($response);
    }

    public function changePassword()
    {
        $id = \Auth::user()->id;
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['activeTab'] = "change-password";
        $viewData['pageTitle'] = "Change Password";
        return view(roleFolder().'.change-password',$viewData);
    }

    public function updatePassword(Request $request)
    {
        $id = \Auth::user()->id;
        $object =  User::find($id);

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4',
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
        
        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('edit-profile');
        $response['message'] = "Password updated sucessfully";
        
        return response()->json($response);
    }

    public function notifications(){
        $viewData['pageTitle'] = "All Notifications";
        $viewData['activeTab'] = "notifications";

        if(\Session::get("login_to") == 'professional_panel'){
            $chat_notifications = Notifications::with('Read')->where('type','chat')
                        
                        ->orderBy("id","desc")
                        ->get();
            $other_notifications = Notifications::with('Read')->where('type','other')
                        ->orderBy("id","desc")
                        ->get();
        }else{
            $chat_notifications = Notifications::with('Read')->where('type','chat')
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
            $other_notifications = Notifications::with('Read')->where('type','other')
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }
        $viewData['chat_notifications'] = $chat_notifications;
        $viewData['other_notifications'] = $other_notifications;
        return view(roleFolder().'.allnotification',$viewData);        
    }

    public function manageCv(){
        $user = User::where("id",\Auth::user()->id)->first();
        $user_detail = UserDetails::where("user_id",$user->unique_id)->first();
        
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $viewData['cv_types'] = CvTypes::get();
        if(!empty($user_detail))
        {
            $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$user_detail->country_id)->get();
            $viewData['states'] = $states;
            $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$user_detail->state_id)->get();
            $viewData['cities'] = $cities;
        }
        $languages = Languages::get();
        $language_proficiency = array();
        $official_languages = OfficialLanguages::get();

        $first_official = UserLanguageProficiency::where("user_id",\Auth::user()->unique_id)->where('type','first_official')->first();
        $second_official = UserLanguageProficiency::where("user_id",\Auth::user()->unique_id)->where('type','second_official')->first();
        $second_off_languages = array();
        $first_proficencies = array();
        $second_proficencies = array();
        if(!empty($first_official)){
            $viewData['first_official'] = $first_official;
            $second_off_languages = OfficialLanguages::where("unique_id","!=",$first_official->language_id)->get();
            $first_proficencies = LanguageProficiency::where("official_language",$first_official->language_id)->get();
        }
        if(!empty($second_official)){
            $viewData['second_official'] = $second_official;
            $second_proficencies = LanguageProficiency::where("official_language",$second_official->language_id)->get();
        }
        $viewData['first_proficencies'] = $first_proficencies;
        $viewData['second_proficencies'] = $second_proficencies;
        $work_expirences = ClientExperience::where("user_id",\Auth::user()->unique_id)->orderBy('id','desc')->get();
        $educations = ClientEducations::where("user_id",\Auth::user()->unique_id)->orderBy('id','desc')->get();
        $viewData['languages'] = $languages;
        $viewData['official_languages'] = $official_languages;
        $viewData['second_off_languages'] = $second_off_languages;
        $viewData['work_expirences'] = $work_expirences;
        $viewData['educations'] = $educations;
        $viewData['language_proficiency'] = $language_proficiency;
        $viewData['countries'] = $countries;
        $viewData['pageTitle'] = "Manage CV";
        $viewData['user'] = $user;
        $viewData['user_detail'] = $user_detail;

        $viewData['activeTab'] = "manage-cv";
        
        return view(roleFolder().'.manage-cv',$viewData);        
    }


    public function addWorkExperience(Request $request){
       
        $viewData['pageTitle'] = "Add Work Experience";
        $viewData['noc_codes'] = NocCode::get();
        $viewData['countries'] = Countries::get();
        $view = View::make(roleFolder().'.modal.add-work-experience',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveWorkExperience(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'company' => 'required',
                'job_title' => 'required',
                'exp_details' => 'required',
                'from_month' => 'required',
                'from_year' => 'required',
                'to_month' => 'required',
                'to_year' => 'required',
                'country_id' => 'required',
                'state_id' => 'required',
                'job_type' => 'required',
                'noc_code' => 'required',
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

            $object = new ClientExperience();
            $object->employment_agency = $request->input("company");
            $object->user_id = \Auth::user()->unique_id;
            $object->position = $request->input("job_title");
            $object->join_date = $request->input("join_date");
            $object->leave_date = $request->input("leave_date");
            $object->country_id = $request->input("country_id");
            $object->state_id = $request->input("state_id");
            $object->job_type = $request->input("job_type");
            $object->noc_type = $request->input("noc_type");
            $object->noc_code = implode(",",$request->input("noc_code"));
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record added successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function editWorkExperience($id){
       
        $id = base64_decode($id);
        $record = ClientExperience::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Work Experience";
        $viewData['noc_codes'] = NocCode::get();
        $view = View::make(roleFolder().'.modal.edit-work-experience',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateWorkExperience($id,Request $request){
        try{
            $id = base64_decode($id);
            $validator = Validator::make($request->all(), [
                'employment_agency' => 'required',
                'position' => 'required',
                'join_date' => 'required',
                'leave_date' => 'required',
                'exp_details' => 'required',
                'job_type' => 'required',
                'noc_code' => 'required',
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

            $object = ClientExperience::find($id);
            $object->employment_agency = $request->input("employment_agency");
            $object->user_id = \Auth::user()->unique_id;
            $object->position = $request->input("position");
            $object->join_date = $request->input("join_date");
            $object->leave_date = $request->input("leave_date");
            $object->exp_details = $request->input("exp_details");
            $object->job_type = $request->input("job_type");
            $object->noc_type = $request->input("noc_type");
            $object->noc_code = implode(",",$request->input("noc_code"));
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record added successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteExperience($id){
        $id = base64_decode($id);
        ClientExperience::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }

    public function educations(Request $request){
        $viewData['pageTitle'] = "Educations";
        
        $view = View::make(roleFolder().'.educations',$viewData);
        $contents = $view->render();
    }

    public function addEducation(Request $request){
       
        $viewData['pageTitle'] = "Add Education";
        $primary_degree = PrimaryDegree::get();
        $viewData['primary_degree'] = $primary_degree;

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;

        $CanadianEqLevel = CanadianEquivalencyLevel::get();
        $viewData['CanadianEqLevel'] = $CanadianEqLevel;

        $view = View::make(roleFolder().'.modal.add-education',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveEducation(Request $request){
        try{
            $valid = array(
                'degree_id' => 'required',
                'qualification' => 'required',
                //'percentage' => 'required',
                //'year_passed' => 'required',
                'school_name' => 'required',

                'from_month' => 'required',
                'from_year' => 'required',
                'to_month' => 'required',
                'to_year' => 'required',
                
                'country_id' => 'required',
                'state_id' => 'required',
                
                'canadian_equivalency_level' => 'required',
                'evaluating_agency' => 'required',

            );

            // if($request->input("is_eca") == 1){
            //     $valid['eca_equalency'] = 'required';
            //     $valid['eca_doc_no'] = 'required';
            //     $valid['eca_agency'] = 'required';
            //     $valid['eca_year'] = 'required';
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

            $object = new ClientEducations();
            $object->degree_id = $request->input("degree_id");
            $object->user_id = \Auth::user()->unique_id;
            $object->qualification = $request->input("qualification");
            $object->school_name = $request->input("school_name");
            $object->country_id = $request->input("country_id");
            $object->state_id = $request->input("state_id");

            //$object->percentage = $request->input("percentage");
            //$object->year_passed = $request->input("year_passed");
            
            //NEW
            if($request->input("is_highest_degree") == 1){
                $object->is_highest_degree = 1;
            }
            else{
                $object->is_highest_degree = 0;   
            }
            if($request->input("is_ongoing_study") == 1){
                 $object->is_ongoing_study = 1;
            }
            else{
                 $object->is_ongoing_study = 0;   
            }
            //NEW


            if($request->input("is_eca") == 1){
                // $object->is_eca = 1;
                // $object->eca_equalency = $request->input("eca_equalency");
                // $object->eca_doc_no = $request->input("eca_doc_no");
                // $object->eca_agency = $request->input("eca_agency");
                // $object->eca_year = $request->input("eca_year");
            }

            
            $object->canadian_equivalency_level = $request->input("canadian_equivalency_level");
            $object->evaluating_agency = $request->input("evaluating_agency");
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record added successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function editEducation($id){
       
        $id = base64_decode($id);
        $record = ClientEducations::where("id",$id)->first();
        $viewData['record'] = $record;
        $primary_degree = PrimaryDegree::get();
        $viewData['primary_degree'] = $primary_degree;
        $viewData['pageTitle'] = "Edit Education";
        $view = View::make(roleFolder().'.modal.edit-education',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateEducation($id,Request $request){
        try{
            $id = base64_decode($id);
            $valid = array(
                'degree_id' => 'required',
                'qualification' => 'required',
                'percentage' => 'required',
                'year_passed' => 'required'
            );
            if($request->input("is_eca") == 1){
                $valid['eca_equalency'] = 'required';
                $valid['eca_doc_no'] = 'required';
                $valid['eca_agency'] = 'required';
                $valid['eca_year'] = 'required';
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
            $object = ClientEducations::find($id);
            $object->degree_id = $request->input("degree_id");
            $object->user_id = \Auth::user()->unique_id;
            $object->qualification = $request->input("qualification");
            $object->percentage = $request->input("percentage");
            $object->year_passed = $request->input("year_passed");
            if($request->input("is_eca") == 1){
                $object->is_eca = 1;
                $object->eca_equalency = $request->input("eca_equalency");
                $object->eca_doc_no = $request->input("eca_doc_no");
                $object->eca_agency = $request->input("eca_agency");
                $object->eca_year = $request->input("eca_year");
            }else{
                $object->is_eca = 0;
                $object->eca_equalency = '';
                $object->eca_doc_no = '';
                $object->eca_agency = '';
                $object->eca_year = '';
            }
            $object->save();

            $response['status'] = true;
            $response['message'] = 'Record updated successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteEducation($id){
        $id = base64_decode($id);
        ClientEducations::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }

    public function saveLanguageProficiency(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'first_official' => 'required'
            ]);
            
            if ($validator->fails()) {
                $response['status'] = false;
                $response['error_type'] = 'validation';
                $error = $validator->errors()->toArray();
                $errMsg = '';
                
                foreach($error as $key => $err){
                    $errMsg .= $err[0];
                }
                $response['error_type'] = 'validation';
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $first_official = $request->first_official;
            $first_error_msg = '';
            $error_msg = '';
            foreach($first_official as $key => $value){
                if($value == ''){
                    $first_error_msg .= "<br>First offical ".$key." required.";
                }
            }
            if($first_error_msg != ''){
                $error_msg .= $first_error_msg;
            }
            $count = 0;
            $second_error_msg = '';
            $is_second = 0;
            $second_official = array();
            
            if($request->input("second_official")){
                $second_official = $request->second_official;
              
                foreach($second_official as $key => $value){
                    if($value == ''){
                        $count++;
                        $second_error_msg .= "<br>Second offical ".$key." required";
                    }else{
                        $is_second++;
                    }
                }
            }
            if($count != 6){
                if($second_error_msg != ''){
                    $error_msg .= $second_error_msg;
                }
            }
            if($error_msg != ''){
                $response['error_type'] = 'validation';
                $response['message'] = $error_msg;
                return response()->json($response);
            }
            $first_off = UserLanguageProficiency::where("user_id",\Auth::user()->unique_id) 
                                                ->where("type","first_official")
                                                ->first();
            if(!empty($first_off)){
                $object = UserLanguageProficiency::find($first_off->id);
            }else{
                $object = new UserLanguageProficiency();
            }
 
            $object->user_id = \Auth::user()->unique_id;
            $object->language_id = $first_official["language"];
            $object->proficiency = $first_official["proficiency"];
            $object->reading = $first_official["reading"];
            $object->writing = $first_official["writing"];
            $object->listening = $first_official["listening"];
            $object->speaking = $first_official["speaking"];
            $object->type = 'first_official';
            $object->save();

            if($is_second == 6){
                $second_off = UserLanguageProficiency::where("user_id",\Auth::user()->unique_id) 
                                                    ->where("type","second_official")
                                                    ->first();
                if(!empty($second_off)){
                    $object = UserLanguageProficiency::find($second_off->id);
                }else{
                    $object = new UserLanguageProficiency();
                }
                
                $object->user_id = \Auth::user()->unique_id;
                $object->language_id = $second_official["language"];
                $object->proficiency = $second_official["proficiency"];
                $object->reading = $second_official["reading"];
                $object->writing = $second_official["writing"];
                $object->listening = $second_official["listening"];
                $object->speaking = $second_official["speaking"];
                $object->type = 'second_official';
                $object->save();
            }else{
                $second_off = UserLanguageProficiency::where("user_id",\Auth::user()->unique_id) 
                                                    ->where("type","second_official")
                                                    ->delete();
            }

            $response['status'] = true;
            $response['message'] = 'Record saved successfully';
         
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function connectApps(){
        $viewData = array();

        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $viewData['user_detail'] = $user_detail;
        $viewData['pageTitle'] = "Connect Apps";
        $viewData['activeTab'] = "connect-apps";
        return view(roleFolder().'.connect-apps',$viewData);           
    }

    public function googleAuthention(){
        $url = baseUrl("/connect-apps/connect-google");
        $domain = get_domaininfo(url('/'));
        setcookie("google_url", $url, time() + (86400 * 30), '/');
        $url = google_auth_url();
        return redirect($url);
    }
    public function unlinkApp($app){
        if($app == 'google'){
            $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $object->google_drive_auth = '';
            $object->save();
            return redirect()->back()->with("success","Google drive account unlinked");
        }
        if($app == 'dropbox'){
            $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $object->dropbox_auth = '';
            $object->save();
            return redirect()->back()->with("success","Dropbox account unlinked");
        }
        return redirect()->back();
    }
    public function connectGoogle(Request $request){
        if(isset($_GET['code'])){
            $return = google_callback($_GET['code']);

            if(isset($return['access_token'])){
                $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
                $object->google_drive_auth = json_encode($return);
                $object->save();
                return redirect(baseUrl('/connect-apps'))->with("success","Google account connected successfully. You can now use the gdrive to upload documents");
            }
            return redirect(baseUrl('/connect-apps'))->with("error","Google connection failed try again");
        }else{
            return redirect(baseUrl('/connect-apps'))->with("error","Google connection failed");
        }   
    }

    public function dropboxAuthention(){
        $url = baseUrl("/connect-apps/connect-dropbox");
        $domain = get_domaininfo(url('/'));
        setcookie("dropbox_url", $url, time() + (86400 * 30), '/');
        $url = dropbox_auth_url();
        return redirect($url);
    }

    public function connectDropbox(Request $request){
       
        if(isset($_GET['code'])){
            $return = dropbox_callback($_GET['code']);
          
            if(isset($return['access_token'])){
                $object = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
                $object->dropbox_auth = json_encode($return);
                $object->save();
                return redirect(baseUrl('/connect-apps'))->with("success","Dropbox account connected successfully");
            }
            return redirect(baseUrl('/connect-apps'))->with("error",$return['message']);
        }else{
            return redirect(baseUrl('/connect-apps'))->with("error","Dropbox connection failed");
        }   
    }

    public function googleSetting(Request $request){
        $viewData['pageTitle'] = "Google Backup Setting";
        $settings = BackupSettings::where("user_id",\Auth::user()->unique_id)->first();
        $viewData['record'] = $settings;
        $view = View::make(roleFolder().'.modal.google-setting',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveGoogleSetting(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'duration' => 'required',
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
            
            $checkSetting = BackupSettings::where("user_id",\Auth::user()->unique_id)->first();
            if(!empty($checkSetting)){
                $object = BackupSettings::find($checkSetting->id);
                
            }else{
                $object = new BackupSettings();
                $object->unique_id = randomNumber();
            }
            $object->user_id = \Auth::user()->unique_id;
            $object->gdrive_duration = $request->input("duration");
            $object->save();

            $response['status'] = true;
            $response['message'] = "Backup setting saved successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function dropboxSetting(Request $request){
        $viewData['pageTitle'] = "Dropbox Backup Setting";
        $settings = BackupSettings::where("user_id",\Auth::user()->unique_id)->first();
        $viewData['record'] = $settings;
        $view = View::make(roleFolder().'.modal.dropbox-setting',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveDropboxSetting(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'duration' => 'required',
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

            $checkSetting = BackupSettings::where("user_id",\Auth::user()->unique_id)->first();
            if(!empty($checkSetting)){
                $object = BackupSettings::find($checkSetting->id);
            }else{
                $object = new BackupSettings();
                $object->unique_id = randomNumber();
            }
            $object->user_id = \Auth::user()->unique_id;
            $object->dropbox_duration = $request->input("duration");
            $object->save();

            $response['status'] = true;
            $response['message'] = "Backup setting saved successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchOfficialLanguage(Request $request){
        $language_id = $request->input('language');

        $languages = OfficialLanguages::where("unique_id","!=",$language_id)->get();
        $options = '<option value="">Select Language</option>';
        foreach($languages as $option){
            $options .='<option value="'.$option->unique_id.'">'.$option->name.'</option>';
        }
        $response['status'] = true;
        $response['options'] = $options;
        return response()->json($response);
    }

    public function fetchProficiency(Request $request){
        $language_id = $request->input('language');
        $languages = LanguageProficiency::where("official_language",$language_id)->get();
        $options = '<option value="">Select Proficiency</option>';
        foreach($languages as $option){
            $options .='<option value="'.$option->unique_id.'">'.$option->name.'</option>';
        }
        $response['status'] = true;
        $response['options'] = $options;
        return response()->json($response);
    }
    
}
