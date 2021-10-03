<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use Validator;
use DB;
use View;
use File;

use App\Models\User;

class BackendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function sendVerifyCode(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
                'country_code' => 'required',
                'phone_no' => 'required',
            ]);

            
            session(['redirect_back' => $request->input('redirect_back')]);
            if ($validator->fails()) {
                $response['status'] = false;
                $response['status'] = false;
                $error = $validator->errors()->toArray();
                $errMsg = array();
                
                foreach($error as $key => $err){
                    $errMsg[$key] = $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $verify_by = $request->input("verify_by");
            $value = $request->input("value");
            if($verify_by == 'email'){
                $checkExists = User::where("email",$value)->count();
                if($checkExists > 0){
                    $response['status'] = false;
                    $response['message'] = "Email already exists try another email";
                    return response()->json($response);
                }
                \Session::forget("verify_code");
                $verify_code = mt_rand(1000,9999);
                VerificationCode::where("match_string",$value)->delete();
                $date = date("Y-m-d H:i:s");
                $object = new VerificationCode();
                $object->verify_by = $verify_by;
                $object->match_string = $value;
                $object->verify_code = $verify_code;
                $object->expiry_time = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($date)));
                $object->save();

                $mailData['verify_code'] = $verify_code;
                $view = View::make('emails.verify-mail',$mailData);
                $message = $view->render();
                $parameter['to'] = $value;
                $parameter['to_name'] = '';
                $parameter['message'] = $message;
                $parameter['subject'] = companyName()." verfication code";
                // echo $message;
                // exit;
                $parameter['view'] = "emails.verify-mail";
                $parameter['data'] = $mailData;
                $mailRes = sendMail($parameter);
                \Session::put("verify_code",$verify_code);
                if($mailRes['status'] == true){
                    \Session::put("verify_code",$verify_code);
                    $response['status'] = true;
                    $response['message'] = "Check your email for verfication code";
                }else{
                    $response['status'] = false;
                    $response['message'] = $mailRes['message'];
                }
            }else{
                $checkExists = User::whereRaw("CONCAT(`country_code`, `phone_no`) = ?", [$value])->count();
                if($checkExists > 0){
                    $response['status'] = false;
                    $response['message'] = "Mobile Number already exists";
                    return response()->json($response);
                }
                $smsRes = sendVerifyCode($value);
                \Session::forget("verify_code");
                \Session::forget("service_code");
                if($smsRes['status'] == true){
                    \Session::put("service_code",$smsRes['service_code']);
                    $response['status'] = true;
                    $response['message'] = "Verfication code send to your mobile";
                }else{
                    $response['status'] = false;
                    $response['message'] = $smsRes['message'];
                }
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }   
}
