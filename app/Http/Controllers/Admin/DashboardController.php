<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use View;

use App\Models\RolePrivileges;
use App\Models\ReminderNotes;
use App\Models\Notifications;
use App\Models\DomainDetails;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function dashboard()
    {
       	$viewData['pageTitle'] = "Dashboard";
        $viewData['activeTab'] = 'dashboard';
        $subdomain = \Session::get("subdomain");
        $unread_chats = DB::table(MAIN_DATABASE.".support_chats")
            ->where("subdomain",$subdomain)
            ->where("sender_id","!=",\Auth::user()->unique_id)
            ->where("professional_read",0)
            ->count();
        $viewData['unread_chats'] = $unread_chats;
        return view(roleFolder().'.dashboard',$viewData);
    }

    public function profile()
    {
       	$viewData['pageTitle'] = "Profile";
        $viewData['activeTab'] = 'dashboard';
       	$viewData['active_tab'] = "profile_tab";
       	$user = User::where("id",\Auth::user()->id)->first();
       	$viewData['user'] = $user;
        return view(roleFolder().'.profile.profile',$viewData);
    }

    public function services()
    {
       	$viewData['pageTitle'] = "Services";
        $viewData['activeTab'] = 'dashboard';
       	$viewData['active_tab'] = "service_tab";
       	$user = User::where("id",\Auth::user()->id)->first();
       	$viewData['user'] = $user;
        return view(roleFolder().'.profile.services',$viewData);
    }

    public function articles()
    {
        $viewData['pageTitle'] = "Articles";
        $viewData['active_tab'] = "article_tab";
        $viewData['activeTab'] = 'dashboard';
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.articles',$viewData);
    }

    public function events()
    {
        $viewData['pageTitle'] = "Events";
        $viewData['activeTab'] = 'dashboard';
        $viewData['active_tab'] = "event_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.events',$viewData);
    }

    public function editProfile()
    {
       	$viewData['pageTitle'] = "Edit Profile";
        $viewData['activeTab'] = 'dashboard';
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.edit-profile',$viewData);
    }

    public function completeProfile()
    {
        $setting = DomainDetails::first();

        if($setting->profile_status == 2){
            return redirect(baseUrl('/'));
        }
        $viewData['pageTitle'] = "Complete Profile";
        $viewData['active_tab'] = "personal_tab";
        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        return view(roleFolder().'.profile.complete-profile',$viewData);
    }

    public function rolePrivileges()
    {
        $viewData['pageTitle'] = "Role Privileges";
       
        $api_response = curlRequest("roles");
        $roles = staffRoles();
        // if(isset($api_response['status']) && $api_response['status'] == 'success'){
        //     $roles = $api_response['data'];
        // }
        
        $viewData['roles'] = $roles;
        $api_response = curlRequest("privileges");
        $privileges = array();
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $privileges = $api_response['data'];
        }
        $role_privileges = RolePrivileges::get();
        $temp = array();
        foreach($role_privileges as $value){
            $temp[$value->role][$value->module][] = $value->action;
        }
        
        $viewData['role_privileges'] = $temp;
        $viewData['privileges'] = $privileges;
        $viewData['activeTab'] = 'role-privileges';
        return view(roleFolder().'.role-privileges',$viewData);
    }

    public function savePrivileges(Request $request){
        
        RolePrivileges::truncate();
        if($request->input("privileges")){
            $privileges = $request->input("privileges");
            foreach($privileges as $role => $values){
                foreach($values as $module => $actions){
                   for($i=0;$i < count($actions);$i++){
                        $object = new RolePrivileges();
                        $object->role = $role;       
                        $object->module = $module;
                        $object->action = $actions[$i];
                        $object->save();
                    }     
                }
            }
            $response['status'] = true;
            $response['message'] = "Privileges added to roles";
        }else{
            $response['status'] = 'true';
            $response['message'] = 'Reset privileges from all roles';
        }
        return response()->json($response);
    }

    public function addReminderNote(Request $request){
        $viewData['pageTitle'] = "Add Reminder Notes";
        $view = View::make(roleFolder().'.modal.add-reminder-note',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function saveReminderNote(Request $request){

        $validator = Validator::make($request->all(), [
            'reminder_date' => 'required',
            'notes' => 'required',
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

        $object = new ReminderNotes();
        $object->user_id = \Auth::user()->unique_id;
        $object->unique_id = randomNumber();
        $object->notes = $request->input("notes");
        $date = str_replace("/","-",$request->input("reminder_date"));
        $object->reminder_date = dateFormat($date,"Y-m-d");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Notes added successfully";

        return response()->json($response);  
    }

    public function fetchReminderNotes(Request $request){
        $unique_id = \Auth::user()->unique_id;
        
        $notes = ReminderNotes::where("user_id",$unique_id)
                            ->orderBy("reminder_date","desc")
                            ->get();
        $viewData['current_date'] = date("Y-m-d");
        $viewData['notes'] = $notes;
        $view = View::make(roleFolder().'.modal.reminder-list',$viewData);
        $contents = $view->render();
        
        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function editReminderNote($id,Request $request){
        $viewData['pageTitle'] = "Edit Reminder Notes";
        $record = ReminderNotes::where("unique_id",$id)->first();
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.modal.edit-reminder-note',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function updateReminderNote($id,Request $request){

        $validator = Validator::make($request->all(), [
            'reminder_date' => 'required',
            'notes' => 'required',
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

        $object = ReminderNotes::where("unique_id",$id)->first();
        $object->user_id = \Auth::user()->unique_id;
        $object->unique_id = randomNumber();
        $object->notes = $request->input("notes");
        $date = str_replace("/","-",$request->input("reminder_date"));
        $object->reminder_date = dateFormat($date,"Y-m-d");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Notes edited successfully";

        return response()->json($response);  
    }

    public function deleteReminderNote($id){
        $note = ReminderNotes::where("unique_id",$id)->first();
        ReminderNotes::deleteRecord($note->id);
        return redirect()->back()->with("success","Note has been deleted!");
    }

    public function notifications(){
        $viewData['pageTitle'] = "All Notifications";
        $notification_type = Notifications::with('Read')->where('type','chat')
                        ->orderBy("id","desc")
                        ->groupBy("notification_type")
                        ->get();
     
        $notifications = array();
        if(\Session::get("login_to") == 'professional_panel'){
            foreach($notification_type as $type){
                
                $data = Notifications::with('Read')->where('notification_type',$type->notification_type)
                        ->orderBy("id","desc")
                        ->get();
                $notifications[$type->notification_type] = $data;
            }
            $chat_notifications = Notifications::with('Read')->where('type','chat')
                        ->orderBy("id","desc")
                        ->get();
            $other_notifications = Notifications::with('Read')->where('type','other')
                        ->orderBy("id","desc")
                        ->get();
            
        }else{
            foreach($notification_type as $type){
                
                $data = Notifications::with('Read')->where('notification_type',$type->notification_type)
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
                $notifications[$type->notification_type] = $data;
            }
            $chat_notifications = Notifications::with('Read')->where('type','chat')
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
            $other_notifications = Notifications::with('Read')->where('type','other')
                        ->where("user_id",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }
        $viewData['notifications'] = $notifications;
        $viewData['chat_notifications'] = $chat_notifications;
        $viewData['other_notifications'] = $other_notifications;
        $viewData['activeTab'] = 'notification';
        return view(roleFolder().'.allnotification',$viewData);        
    }

    public function connectApps(){
        $viewData = array();
        return view(roleFolder().'.connect-apps',$viewData);           
    }

    public function googleAuthention(){
        $url = google_auth_url();
        return redirect($url);
    }
    public function connectGoogle(Request $request){
        if(isset($_GET['code'])){
            $url = google_callback($_GET['code']);
        }else{
            return redirect(baseUrl('/connect-apps'))->with("error","Google connection failed");
        }   
    }

    

}
