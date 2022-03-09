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

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function completeProfile()
    {
        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
       
        $setting = DomainDetails::first();
     
        if($setting->profile_status == 2){
            return redirect(baseUrl('/'));
        }
        $viewData['profile_status'] = $setting->profile_status;
        $viewData['pageTitle'] = "Complete Profile";
        $viewData['active_tab'] = "personal_tab";
        $viewData['admin_notes'] = $setting->admin_notes;
        $viewData['notes_updated_on'] = $setting->notes_updated_on;
        $user = User::where("id",\Auth::user()->id)->first();
        $company_details = ProfessionalDetails::first();

        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $viewData['languages'] = $languages;
        $licence_bodies = DB::table(MAIN_DATABASE.".licence_bodies")->where('country_id',$company_details->country_id)->get();
        $viewData['licence_bodies'] = $licence_bodies;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$user->country_id)->get();
        $viewData['states'] = $states;
        $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$user->state_id)->get();
        $viewData['cities'] = $cities;

        $viewData['user'] = $user;
        $viewData['company_details'] = $company_details;
        $subdomain = \Session::get("subdomain");
        $unread_chats = DB::table(MAIN_DATABASE.".support_chats")
                ->where("subdomain",$subdomain)
                ->where("sender_id","!=",\Auth::user()->unique_id)
                ->where("professional_read",0)
                ->count();
        $viewData['unread_chats'] = $unread_chats;
        return view(roleFolder().'.complete-profile',$viewData);
    }

    public function saveProfile(Request $request){
        // pre($request->all());
        $id = \Auth::user()->id;
        $object = User::find($id);
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|unique:users,email,'.$object->id,
            //'first_name' => 'required',
            //'last_name' => 'required',
            //'country_code' => 'required',
            //'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            //'license_body'=>'required',
            'member_of_good_standing'=>'required',
            'years_of_expirences'=>'required',
            'company_name'=>'required',
            'website_url'=>'required',
            'cp_email' => 'required',
            'cp_country_code'=>'required',
            'cp_phone_no'=>'required',
            'date_of_register'=>'required',
            'cp_address'=>'required',
            'cp_zip_code'=>'required',
            'cp_address'=>'required',
            'cp_country_id'=>'required',
            'cp_state_id'=>'required',
            'cp_city_id'=>'required',
            'termsAndConditions'=>'required',
            // 'owner_id_proof'=>'required',
            // 'company_address_proof'=>'required',
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
        $id = \Auth::user()->id;
        $object = User::find($id);
        //$object->first_name = $request->input("first_name");
        //$object->last_name = $request->input("last_name");
        // $object->email = $request->input("email");
        //$object->country_code = $request->input("country_code");
        //$object->phone_no = $request->input("phone_no");
        $object->date_of_birth = $request->input("date_of_birth");
        $object->gender = $request->input("gender");
        $object->country_id = $request->input("country_id");
        $object->state_id = $request->input("state_id");
        $object->city_id = $request->input("city_id");
        $object->address = $request->input("address");
        $object->zip_code = $request->input("zip_code");
        $object->languages_known = json_encode($request->input("languages_known"));
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = professionalDir()."/profile";
            
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
            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;                    
            }
        }
        $object->save();

        $id = $object->id;

        $professional = ProfessionalDetails::first();
        $object2 = ProfessionalDetails::find($professional->id);
        $object2->company_name = $request->input("company_name");
        $object2->email = $request->input("cp_email");
        $object2->website_url = $request->input("website_url");
        $object2->country_code = $request->input("cp_country_code");
        $object2->phone_no = $request->input("cp_phone_no");
        $object2->country_id = $request->input("cp_country_id");
        $object2->state_id = $request->input("cp_state_id");
        $object2->city_id = $request->input("cp_city_id");
        $object2->country_id = $request->input("cp_country_id");
        $object2->zip_code = $request->input("cp_zip_code");
        $object2->address = $request->input("cp_address");
        $object2->date_of_register = $request->input("date_of_register");
        $object2->license_body = $request->input("license_body");
        $object2->member_of_good_standing = $request->input("member_of_good_standing");
        $object2->licence_number = $request->input("licence_number");
        $object2->years_of_expirences = $request->input("years_of_expirences");
        if($request->input("member_of_other_designated_body")){
            $object2->member_of_other_designated_body = $request->input("member_of_other_designated_body");
        }
        if ($file = $request->file('licence_certificate')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/documents";
            if($file->move($destinationPath, $newName)){
                $object2->licence_certificate = $newName;                    
            }
        }
        if ($file = $request->file('owner_id_proof')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/documents";
            if($file->move($destinationPath, $newName)){
                $object2->owner_id_proof = $newName;                    
            }
        }

        if ($file = $request->file('company_address_proof')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/documents";
            if($file->move($destinationPath, $newName)){
                $object2->company_address_proof = $newName;                    
            }
        }
        $object2->save();

        $domain_details = DomainDetails::first();
        $domain_data['profile_status'] = 1;
        $domain = DomainDetails::where("id",$domain_details->id)->update($domain_data);


        $response['status'] = true;
        $response['message'] = "Profile successfully completed";

        $mailData = array();
        $mailData['mail_message'] = "Hello Admin,<Br> ".$request->input("company_name")." has completed his profile. Waiting for your approval.";
        $view = View::make('emails.notification',$mailData);
        
        $message = $view->render();
        $parameter['to'] = adminInfo("email");
        $parameter['to_name'] = adminInfo("name");
        $parameter['message'] = $message;
        $parameter['subject'] = "Professional profile submitted";
        $parameter['view'] = "emails.notification";
        $parameter['data'] = $mailData;
        $mailRes = sendMail($parameter);


        $not_data['send_by'] = \Auth::user()->role;
        $not_data['added_by'] = \Auth::user()->unique_id;
        $not_data['user_id'] = adminInfo()->unique_id;
        $not_data['type'] = "other";
        $not_data['notification_type'] = "professional_profile";
        $not_data['title'] = "Professional Profile submitted his profile";
        $not_data['comment'] = $professional->company_name." submitted his profile";;
        $not_data['url'] = "super-admin/professionals";
        
        sendNotification($not_data,"super_admin");

        return response()->json($response);
    }


    public function EditProfile()
    {
        if(\Auth::user()->role != 'admin'){
            return redirect(baseUrl('/'));
        }
        $setting = DomainDetails::first();
        $viewData['profile_status'] = $setting->profile_status;
        $viewData['pageTitle'] = "Edit Profile";
        $viewData['active_tab'] = "personal_tab";

        $user = User::where("id",\Auth::user()->id)->first();
        $company_details = ProfessionalDetails::first();

        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $viewData['languages'] = $languages;
        $licence_bodies = DB::table(MAIN_DATABASE.".licence_bodies")->where('country_id',$company_details->country_id)->get();
        $viewData['licence_bodies'] = $licence_bodies;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$user->country_id)->get();
        $viewData['states'] = $states;
        $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$user->state_id)->get();
        $viewData['cities'] = $cities;

        $viewData['user'] = $user;
        $viewData['company_details'] = $company_details;
        return view(roleFolder().'.edit-profile',$viewData);
    }


    public function updateProfile(Request $request){
        // pre($request->all());
        $id = \Auth::user()->id;
        $object = User::find($id);
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            'license_body'=>'required',
            'member_of_good_standing'=>'required',
            'years_of_expirences'=>'required',
            'company_name'=>'required',
            'website_url'=>'required',
            'cp_email' => 'required',
            'cp_country_code'=>'required',
            'cp_phone_no'=>'required',
            'date_of_register'=>'required',
            'cp_address'=>'required',
            'cp_zip_code'=>'required',
            'cp_address'=>'required',
            'cp_country_id'=>'required',
            'cp_state_id'=>'required',
            'cp_city_id'=>'required',
            // 'licence_certificate'=>'required',
            // 'owner_id_proof'=>'required',
            // 'company_address_proof'=>'required',
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
        $id = \Auth::user()->id;
        $object = User::find($id);
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        // $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->date_of_birth = $request->input("date_of_birth");
        $object->gender = $request->input("gender");
        $object->country_id = $request->input("country_id");
        $object->state_id = $request->input("state_id");
        $object->city_id = $request->input("city_id");
        $object->address = $request->input("address");
        $object->zip_code = $request->input("zip_code");
        $object->languages_known = json_encode($request->input("languages_known"));
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = professionalDir()."/profile";
            
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
            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;                    
            }
        }
        $object->save();

        $id = $object->id;

        $professional = ProfessionalDetails::first();
        $object2 = ProfessionalDetails::find($professional->id);
        $object2->company_name = $request->input("company_name");
        $object2->email = $request->input("cp_email");
        $object2->website_url = $request->input("website_url");
        $object2->country_code = $request->input("cp_country_code");
        $object2->phone_no = $request->input("cp_phone_no");
        $object2->country_id = $request->input("cp_country_id");
        $object2->state_id = $request->input("cp_state_id");
        $object2->city_id = $request->input("cp_city_id");
        $object2->country_id = $request->input("cp_country_id");
        $object2->zip_code = $request->input("cp_zip_code");
        $object2->address = $request->input("cp_address");
        $object2->date_of_register = $request->input("date_of_register");
        $object2->license_body = $request->input("license_body");
        $object2->member_of_good_standing = $request->input("member_of_good_standing");
        $object2->licence_number = $request->input("licence_number");
        $object2->years_of_expirences = $request->input("years_of_expirences");
        if($request->input("member_of_other_designated_body")){
            $object2->member_of_other_designated_body = $request->input("member_of_other_designated_body");
        }
        if ($file = $request->file('licence_certificate')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/documents";
            if($file->move($destinationPath, $newName)){
                $object2->licence_certificate = $newName;                    
            }
        }
        if ($file = $request->file('owner_id_proof')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/documents";
            if($file->move($destinationPath, $newName)){
                $object2->owner_id_proof = $newName;                    
            }
        }

        if ($file = $request->file('company_address_proof')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = professionalDir()."/documents";
            if($file->move($destinationPath, $newName)){
                $object2->company_address_proof = $newName;                    
            }
        }
        if ($file = $request->file('company_logo')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = professionalDir()."/profile";
            
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
            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object2->company_logo = $newName;                    
            }
        }
        $object2->save();

        //$domain_details = DomainDetails::first();
        //$domain_data['profile_status'] = 1;
        //$domain = DomainDetails::where("id",$domain_details->id)->update($domain_data);


        $response['status'] = true;
        $response['message'] = "Profile updated sucessfully";

        return response()->json($response);
    }

    public function fetchSupportChats(Request $request){
        $subdomain = \Session::get("subdomain");
        $chats = DB::table(MAIN_DATABASE.".support_chats")
                    ->where("subdomain",$subdomain)
                    ->orderBy("id","asc")
                    ->get();

        DB::table(MAIN_DATABASE.".support_chats")
                ->where("subdomain",$subdomain)
                ->where("sender_id","!=",\Auth::user()->unique_id)
                ->where("professional_read",0)
                ->update(['professional_read'=>1]);
        $viewData['chats'] = $chats;
        $view = View::make(roleFolder().'.support-chats',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }
    public function sendChatToSupport(Request $request){
        $file_id = randomNumber();
        $insData = array();
        $insData['unique_id'] = $file_id;
        $insData['subdomain'] = \Session::get("subdomain");
        $insData['message'] = $request->input("message");
        $insData['type'] = 'text';
        $insData['send_by'] = \Auth::user()->role;
        $insData['sender_id'] = \Auth::user()->unique_id;
        $insData['created_at'] = date("Y-m-d H:i:s");
        $insData['updated_at'] = date("Y-m-d H:i:s");
        DB::table(MAIN_DATABASE.".support_chats")->insert($insData);
    
        $response['status'] = true;
        $response['message'] = "Message send successfully";
        
        
        return response()->json($response);
    }

    public function saveDocumentChatFile(Request $request){

        if ($file = $request->file('attachment')){
            $data['case_id'] = $request->input("case_id");
            $data['document_id'] = $request->input("document_id");

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = public_path('uploads/support');
            
            
            if($file->move($destinationPath, $newName)){
               
                $file_id = randomNumber();

                $insData = array();
                $insData['unique_id'] = $file_id;
                $insData['subdomain'] = \Session::get("subdomain");
                $insData['file_name'] = $newName;
                $insData['type'] = 'file';
                $insData['send_by'] = \Auth::user()->role;
                $insData['sender_id'] = \Auth::user()->unique_id;
                $insData['created_at'] = date("Y-m-d H:i:s");
                $insData['updated_at'] = date("Y-m-d H:i:s");
                DB::table(MAIN_DATABASE.".support_chats")->insert($insData);
               
            
                $response['status'] = true;
                $response['message'] = "File send successfully";
                
                
            }else{
                $response['status'] = true;
                $response['message'] = "File send failed, try again!";
            }
        }else{
            $response['status'] = false;
            $response['message'] = "File not selected!";
        }
        
        return response()->json($response);
    }

    
}
