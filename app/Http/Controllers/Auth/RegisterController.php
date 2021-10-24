<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DB;
use View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Professionals;
use App\Models\Countries;
use App\Models\VerificationCode;
use App\Models\Settings;
use App\Models\Assessments;
use App\Models\AssessmentForms;
use App\Models\UserWithProfessional;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function userSignup(Request $request){
        if(\Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $viewData['pageTitle'] = 'Sign Up as User';
        $viewData['countries'] = DB::table(MAIN_DATABASE.".countries")->get();
        if($request->get("assessment")){
            $viewData['query_string'] = "?assessment=".$request->get("assessment");
        }else{
            $viewData['query_string'] = '';
        }
        return view('auth.user-signup',$viewData);   
    }

    public function professionalSignup(Request $request){
        if(\Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $subdomain = "dkdev";
        $rootdomain = DB::table(MAIN_DATABASE.".settings")->where("meta_key",'rootdomain')->first();
        $rootdomain = $rootdomain->meta_value;

        $url = "http://".$subdomain.".".$rootdomain."/";

        $viewData['pageTitle'] = 'Sign Up as Professional';
        $viewData['countries'] = Countries::get();
        return view('auth.professional-signup',$viewData);   
    }
    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
            // 'country_code' => 'required',
            // 'phone_no' => 'required',
            'termsAndConditions'=>'required'
            // 'verify_by'=>'required',
            // 'verification_code'=>'required',
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
        $phone = $request->input("country_code").$request->input("phone_no");
        if($request->input("verify_status") != 'true'){
            if($request->input("verify_by")){
                $verify_code = $request->input("verify_type");
                if(\Session::get('verify_by') == 'email'){
                    if(\Session::get('verify_code') != $verify_code){
                        $response['status'] = false;
                        $response['error_type'] = 'verify_failed';
                        $response['message'] = 'Verification code mismatch';
                        return response()->json($response);
                    }
                }
            }else{
                $response['status'] = false;
                $response['error_type'] = 'not_verified';
                $response['email'] = $request->input("email");
                $response['mobile_no'] = $phone;
                return response()->json($response);
            }
        }

        
        if($request->input("verify_status") == 'true'){
            $object = new User();
            $unique_id = randomNumber();
            $object->unique_id = $unique_id ;
            $object->first_name = $request->input("first_name");
            $object->last_name = $request->input("last_name");
            $object->email = $request->input("email");
            $object->password = bcrypt($request->input("password"));
            $object->country_code = $request->input("country_code");
            $object->phone_no = $request->input("phone_no");
            $object->role = "user";
            $object->is_active = 1;
            $object->is_verified = 1;

            $object->save();
            $user_id = $object->id;


            $object2 = new UserDetails();
            $object2->user_id = $unique_id;
            $object2->save();

            
            \Auth::loginUsingId($user_id);
            \Session::forget("verify_code");
            $response['status'] = true;
            if(!empty($request->input('redirect_back'))){
                $response['redirect_back']= $request->input('redirect_back');    
            }else{
                $response['redirect_back'] = url('home');  
            }
            if($request->get('assessment')){
                $assessment_form = AssessmentForms::with('Assessment')
                                        ->where("uuid",$request->get("assessment"))
                                        ->whereHas("Assessment")
                                        ->first();
                if(!empty($assessment_form)){
                    $uspr_object = new UserWithProfessional();
                    $uspr_object->user_id = $unique_id;
                    $uspr_object->professional = $assessment_form->Assessment->professional;
                    $uspr_object->status = 1;
                    $uspr_object->save();
                }
                $response['redirect_back'] = url('assessment/u/'.$request->get('assessment')); 
            }
             // Professional Mail

             $name = $request->input('first_name')." ".$request->input('last_name');
            

             $mailData = array();
             $mailData['mail_message'] = "Hello ".$name.",<Br> Welcome to ".companyName().". We are happy to have you with us.";
             $view = View::make('emails.notification',$mailData);
             
             $message = $view->render();
             $parameter['to'] = $request->input('email');
             $parameter['to_name'] = $request->input('first_name')." ". $request->input('last_name');
             $parameter['message'] = $message;
             $parameter['subject'] = companyName()." Welcome Mail";
             $parameter['view'] = "emails.notification";
             $parameter['data'] = $mailData;
             $mailRes = sendMail($parameter);
 
            
             // Admin Mail
 
             $mailData = array();
             $mailData['mail_message'] = "Hello Admin,<Br> New user ".$name." has been registered to our panel.";
             $view = View::make('emails.notification',$mailData);
             $message = $view->render();
             $parameter['to'] = adminInfo('email');
             $parameter['to_name'] = adminInfo('name');
             $parameter['message'] = $message;
             $parameter['subject'] = companyName()." Welcome Mail";
             $parameter['view'] = "emails.notification";
             $parameter['data'] = $mailData;
             $mailRes = sendMail($parameter);

        }else{
            $response['status'] = false;
            $response['error_type'] = "verification_pending";
            $response['message'] = "OTP verification pending";
        }
        return response()->json($response);
    }
    public function registerProfessional(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:professionals',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
            'country_code' => 'required',
            //'phone_no' => 'required|unique:professionals',
            'termsAndConditions'=>'required',
            //'company_name'=>'required',
            //'termsCheckbox'=>'required',
            'subdomain'=>'required|unique:professionals|max:14|min:6',
        ]);

        
        // session(['redirect_back' => $request->input('redirect_back')]);
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['error_type'] = 'validation';
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        

        $phone = $request->input("country_code").$request->input("phone_no");
        if($request->input("verify_status") != 'true'){
            if($request->input("verify_by")){
                $verify_code = $request->input("verify_type");
                if(\Session::get('verify_by') == 'email'){
                    if(\Session::get('verify_code') != $verify_code){
                        $response['status'] = false;
                        $response['error_type'] = 'verify_failed';
                        $response['message'] = 'Verification code mismatch';
                        return response()->json($response);
                    }
                }
            }else{
                $response['status'] = false;
                $response['error_type'] = 'not_verified';
                $response['email'] = $request->input("email");
                $response['mobile_no'] = $phone;
                return response()->json($response);
            }
        }

        
        if($request->input("verify_status") == 'true'){
            $subdomain = trim($request->input("subdomain"));
            $subdomain = strtolower(str_replace(" ","",$subdomain));
            $client_secret = generateString(50);
            $object = new Professionals();
            $object->unique_id = randomNumber();
            $object->first_name = $request->input("first_name");
            $object->last_name = $request->input("last_name");
            $object->email = $request->input("email");
            $object->country_code = $request->input("country_code");
            $object->phone_no = $request->input("phone_no");
            $object->company_name = $request->input("company_name");
            $object->subdomain = $subdomain;
            $object->client_secret = $client_secret;
            $object->panel_status = 1;
            $object->save();
            $user_id = $object->id;


            $db_prefix = Settings::where("meta_key","database_prefix")->first();
            $db_prefix = $db_prefix->meta_value;
            $sample_db = Settings::where("meta_key","sample_database")->first();
            $sample_db = $sample_db->meta_value;

            $database_name = $db_prefix.$subdomain;
            if($_SERVER['SERVER_NAME'] != 'localhost'){
                $response = createSubDomain($subdomain,$database_name);

                if($response['status'] == 'error'){
                    $response['status'] = false;
                    $response['message'] = $response['message']." Process of creating panel interrupted. Try again!";
                    \Session::flash('error_message', $response['message']." Process of creating panel interrupted. Try again!"); 
                    Professionals::where("id",$user_id)->delete();
                    return response()->json($response);
                    // return redirect()->back()->with('error_message',$response['message']." Process of creating panel interrupted. Try again!");
                }
            }else{
                $sql = "CREATE DATABASE IF NOT EXISTS `$database_name` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
                DB::statement($sql);
            }

            $sql = "SHOW TABLES FROM ".$sample_db;
            $sample_tables = DB::select($sql);
            
            for($i=0;$i < count($sample_tables);$i++){
                $sdb = "Tables_in_".$sample_db;
                $table = $sample_tables[$i]->$sdb;
                

                DB::statement('CREATE TABLE IF NOT EXISTS '.$database_name.'.'.$table.' LIKE '.$sample_db.'.'.$table.';');
            }
            $now = \Carbon\Carbon::now();
            $password = $request->input("password");
            $user_data = array(
                    "unique_id"=> randomNumber(),
                    "first_name"=>$request->input('first_name'),
                    "last_name"=>$request->input('last_name'),
                    "email"=>$request->input('email'),
                    "country_code"=>$request->input('country_code'),
                    "phone_no"=>$request->input('phone_no'),
                    "role"=>"admin",
                    "is_active"=>"1",
                    "is_verified"=>"1",
                    "password"=>bcrypt($password),
                    "created_at"=>$now,
                    "updated_at"=>$now
            );
            DB::table($database_name.'.users')->insert($user_data);

            $company_name = array(
                    "company_name"=>$request->input('company_name'),
                    "created_at"=>$now,
                    "updated_at"=>$now
            );
            DB::table($database_name.'.professional_details')->insert($company_name);

            $api_keys = array(
                    "client_secret"=>$client_secret,
                    "subdomain"=>$subdomain,
                    "master_id"=>$user_id,
                    "created_at"=>$now,
                    "updated_at"=>$now
            );
            DB::table($database_name.'.domain_details')->insert($api_keys);
            $rootdomain = DB::table(MAIN_DATABASE.".settings")->where("meta_key",'rootdomain')->first();
            $rootdomain = $rootdomain->meta_value;
            $portal_url = "http://".$subdomain.".".$rootdomain."/";
            // $portal_url = url("signup/professional");
            if($_SERVER['SERVER_NAME'] == 'localhost'){
                $response['status'] = true;
                $response['redirect_back'] = url('welcome');
                // $response['message'] = "Your panel has been created successfully";
                $response['message'] = "Your panel has been created successfully. Mail has been sent to your emailm please check it.";
                \Session::flash('success_message', "Your panel has been created successfully. You can login to your panel with the access you entered."); 
                \Session::put('professional_register', true); 
                \Session::put('portal_url', $portal_url); 
            }else{
                $response['status'] = true;
                
                $url = url('welcome');
                // $url = url("signup/professional");
                $response['redirect_back'] = $url;
                $response['message'] = "Your panel has been created successfully. Mail has been sent to your emailm please check it.";
                \Session::flash('success_message', "Your panel has been created successfully. You can login to your panel with the access you entered."); 
                \Session::put('professional_register', true); 
                \Session::put('portal_url', $portal_url); 
            }
            
            // Professional Mail

            $mailData['first_name'] = $request->input('first_name');
            $mailData['last_name'] = $request->input('last_name');
            $mailData['subdomain'] = $request->input('subdomain');
            $mailData['portal_url'] = $portal_url;
            $mailData['email']  = $request->input('email');
            $view = View::make('emails.panel-notification',$mailData);
            $message = $view->render();
            $parameter['to'] = $request->input('email');
            $parameter['to_name'] = $request->input('first_name')." ". $request->input('last_name');
            $parameter['message'] = $message;
            $parameter['subject'] = companyName()." Welcome Mail";
            // echo $message;
            // exit;
            $parameter['view'] = "emails.panel-notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);


            // Admin Mail

            $mailData = array();
            $mailData['mail_message'] = "Hello Admin,<Br> New professional ".$request->input("company_name")." has been registered to our panel.";
            $view = View::make('emails.notification',$mailData);
            $message = $view->render();
            $parameter['to'] = adminInfo('email');
            $parameter['to_name'] = adminInfo('name');
            $parameter['message'] = $message;
            $parameter['subject'] = "New Professional Signup";
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);
        }else{
            $response['status'] = false;
            $response['error_type'] = "verification_pending";
            $response['message'] = "OTP verification pending";
        }
        return response()->json($response);
    }

    public function verifyOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'verify_code' => 'required',
            'verify_by' => 'required',
        ]);
        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = '';

            foreach($error as $key => $err){
                $errMsg .= $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        if($request->input("verify_code")){
            $verify_code = $request->input("verify_code");
            $verify_by = explode(":",$request->input("verify_by"));
            
            if($verify_by[0] == 'email'){
                if(\Session::get('verify_code') != $verify_code){
                    $response['status'] = false;
                    $response['error_type'] = 'verify_failed';
                    $response['message'] = 'Verification code mismatch';
                    return response()->json($response);
                }else{
                    $response['status'] = true;
                    $response['message'] = 'Verification successfull';
                    return response()->json($response);
                }
            }else{
                $phone = $verify_by[1];
                $return = verifyCode(\Session::get("service_code"),$verify_code,$phone);
                if($return['status'] == 1){
                    $response['status'] = true;
                    $response['message'] = $return['message'];
                    return response()->json($response);
                }else{
                    $response['status'] = false;
                    $response['error_type'] = 'verify_failed';
                    $response['message'] = 'Verification code mismatch';
                    return response()->json($response);
                }
            }
        }else{
            $response['status'] = false;
            $response['error_type'] = 'verify_failed';
            $response['message'] = 'Verification code required';
            return response()->json($response);
        }
    }
}
