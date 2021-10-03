<?php

namespace App\Http\Controllers\Executive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;

use App\Models\User;
use App\Models\Countries;
use App\Models\Notifications;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('executive');
    }
    public function dashboard()
    {
       	$viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }


    public function editProfile(Request $request){
        $id = \Auth::user()->id;

        $viewData['pageTitle'] = "Edit Profile";
        $record = User::where("id",$id)->first();

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record->country_id)->get();
        $viewData['states'] = $states;
        $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record->state_id)->get();
        $viewData['cities'] = $cities;
        
        $viewData['record'] = $record;
        return view(roleFolder().'.edit-profile',$viewData);
    }
    
    public function updateProfile(Request $request){
        // pre($request->all());
        $id = \Auth::user()->id;
        $object =  User::find($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            // 'gender'=>'required',
            // 'date_of_birth'=>'required',
            // 'languages_known'=>'required',
            // 'country_id'=>'required',
            // 'state_id'=>'required',
            // 'city_id'=>'required',
            // 'address'=>'required',
            // 'zip_code'=>'required',
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
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        // $object->date_of_birth = $request->input("date_of_birth");
        // $object->gender = $request->input("gender");
        // $object->country_id = $request->input("country_id");
        // $object->state_id = $request->input("state_id");
        // $object->city_id = $request->input("city_id");
        // $object->address = $request->input("address");
        // $object->zip_code = $request->input("zip_code");
        
        // $object->languages_known = json_encode($request->input("languages_known"));
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('edit-profile');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }

    public function changePassword()
    {
        $id = \Auth::user()->id;
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
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
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }

    public function notifications(){
        $viewData['pageTitle'] = "All Notifications";

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

}
