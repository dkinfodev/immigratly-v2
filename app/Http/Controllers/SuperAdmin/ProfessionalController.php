<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use DB;

use App\Models\User;
use App\Models\Professionals;
use App\Models\Countries;
use App\Models\States;
use App\Models\Cities;
use App\Models\Settings;
class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function activeProfessionals()
    {
        $viewData['total_users'] = Professionals::count();
        $viewData['active_users'] = Professionals::where('panel_status','1')->count();
        $viewData['inactive_users'] = Professionals::where('panel_status','0')->count();
       	$viewData['pageTitle'] = "Active Professionals";
        $viewData['activeTab'] = "professionals";
        return view(roleFolder().'.professionals.active-lists',$viewData);
    }

    public function getActiveList(Request $request)
    {
        $records = Professionals::orderBy('id',"desc")->where('panel_status',1)->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.professionals.ajax-active',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function inactiveProfessionals()
    {
        $viewData['total_users'] = Professionals::count();
        $viewData['active_users'] = Professionals::where('panel_status','1')->count();
        $viewData['inactive_users'] = Professionals::where('panel_status','0')->count();
        $viewData['pageTitle'] = "Inactive Professionals";
        $viewData['activeTab'] = "professionals";
        return view(roleFolder().'.professionals.inactive-lists',$viewData);
    }
    public function createDatabase(Request $request){
        $subdomain = $request->input("subdomain");
        $db_prefix = Settings::where("meta_key","database_prefix")->first();
        $db_prefix = $db_prefix->meta_value;
        $sample_db = Settings::where("meta_key","sample_database")->first();
        $sample_db = $sample_db->meta_value;
        $professional = Professionals::where('subdomain',$subdomain)->first();
        $user_id = $professional->id;
       
        $database_name = $db_prefix.$subdomain;

        if($_SERVER['SERVER_NAME'] != 'localhost'){
            $response = createDatabase($database_name);
            if($response['status'] == false){
                return response()->json($response);
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
        
        $checkUser = \DB::table($database_name.".users")->where("email",$professional->email)->first();
        $password = generatePassword();
        $user_data = array(
            "unique_id"=> randomNumber(),
            "first_name"=>$professional->first_name,
            "last_name"=>$professional->last_name,
            "email"=>$professional->email,
            "country_code"=>$professional->country_code,
            "phone_no"=>$professional->phone_no,
            "role"=>"admin",
            "is_active"=>"1",
            "is_verified"=>"1",
            "password"=>bcrypt($password),
            "created_at"=>$now,
            "updated_at"=>$now
        );
        if(empty($checkUser)){
            \DB::table($database_name.'.users')->insert($user_data);
        }else{
            \DB::table($database_name.'.users')->where("id",$checkUser->id)->update($user_data);
        }
        $professional_detail = \DB::table($database_name.".professional_details")->where("company_name",$professional->company_name)->first();
        if(empty($professional_detail)){
            $company_name = array(
                    "company_name"=>$professional->company_name,
                    "created_at"=>$now,
                    "updated_at"=>$now
            );
            DB::table($database_name.'.professional_details')->insert($company_name);
        }
        
        $domain_details = \DB::table($database_name.".domain_details")->where("subdomain",$professional->subdomain)->first();
        if(empty($domain_details)){
            $api_keys = array(
                    "client_secret"=>$professional->client_secret,
                    "subdomain"=>$professional->subdomain,
                    "master_id"=>$user_id,
                    "created_at"=>$now,
                    "updated_at"=>$now
            );
            DB::table($database_name.'.domain_details')->insert($api_keys);
        }
        $rootdomain = DB::table(MAIN_DATABASE.".settings")->where("meta_key",'rootdomain')->first();
        $rootdomain = $rootdomain->meta_value;
        $portal_url = "http://".$subdomain.".".$rootdomain."/";
        // $portal_url = url("signup/professional");
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            $response['status'] = true;
            $response['redirect_back'] = url('welcome');
            // $response['message'] = "Your panel has been created successfully";
            $response['message'] = "Professional Database has been created successfully.";
            // \Session::flash('success_message', "Your panel has been created successfully. You can login to your panel with the access you entered."); 
            // \Session::put('professional_register', true); 
            // \Session::put('portal_url', $portal_url); 
        }else{
            $response['status'] = true;
            
            $url = url('welcome');
            // $url = url("signup/professional");
            $response['redirect_back'] = $url;
            $response['message'] = "Professional Database has been created successfully.";
            // $response['message'] = "Your panel has been created successfully. Mail has been sent to your emailm please check it.";
            // \Session::flash('success_message', "Your panel has been created successfully. You can login to your panel with the access you entered."); 
            // \Session::put('professional_register', true); 
            // \Session::put('portal_url', $portal_url); 
        }
        
        // Professional Mail

        $mailData['first_name'] = $professional->first_name;
        $mailData['last_name'] = $professional->last_name;
        $mailData['subdomain'] = $professional->subdomain;
        $mailData['portal_url'] = $portal_url;
        $mailData['password'] = $password;
        $mailData['email']  = $professional->email;
        $view = View::make('emails.panel-notification',$mailData);
        $message = $view->render();
        $parameter['to'] = $professional->email;
        $parameter['to_name'] = $professional->first_name." ". $professional->last_name;
        $parameter['message'] = $message;
        $parameter['subject'] = companyName()." Welcome Mail";
        // echo $message;
        // exit;
        $parameter['view'] = "emails.panel-notification";
        $parameter['data'] = $mailData;
        $mailRes = sendMail($parameter);


        // Admin Mail

        $mailData = array();
        $mailData['mail_message'] = "Hello Admin,<Br> New professional ".$professional->company_name." has been registered to our panel.";
        $view = View::make('emails.notification',$mailData);
        $message = $view->render();
        $parameter['to'] = adminInfo('email');
        $parameter['to_name'] = adminInfo('name');
        $parameter['message'] = $message;
        $parameter['subject'] = "New Professional Signup";
        $parameter['view'] = "emails.notification";
        $parameter['data'] = $mailData;
        $mailRes = sendMail($parameter);
        
        return response()->json($response);
    }
    public function getPendingList(Request $request)
    {
        $records = Professionals::orderBy('id',"desc")->where('panel_status',0)->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.professionals.ajax-active',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function changeStatus($status,Request $request)
    {
        $id = $request->input("id");
        $professional = Professionals::where("id",$id)->first();
        $subdomain = $professional->subdomain;

        if($status == 'active'){
            $upData['panel_status'] = 1;

            $professional_detail = professionalDetail($subdomain);
            $mailData = array();
            $mailData['mail_message'] = "Hello ".$professional_detail->company_name.",<Br> Your professional panel has been activated. You are now ready to use the panel. You can <a href='".professionalDomain($subdomain)."'>Click Here</a>";
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = professionalAdmin($subdomain)->email;
            $parameter['to_name'] = professionalAdmin($subdomain)->first_name." ".professionalAdmin($subdomain)->last_name;
            $parameter['message'] = $message;
            $parameter['subject'] = "Professional panel approved";
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);
        }else{
            $upData['panel_status'] = 0;

            $professional_detail = professionalDetail($subdomain);
            $mailData = array();
            $mailData['mail_message'] = "Hello ".$professional_detail->company_name.",<Br> Your professional panel has been suspended. You can contact support team for further details.";
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = professionalAdmin($subdomain)->email;
            $parameter['to_name'] = professionalAdmin($subdomain)->first_name." ".professionalAdmin($subdomain)->last_name;
            $parameter['message'] = $message;
            $parameter['subject'] = "Professional panel suspended";
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);

        }
        Professionals::where("id",$id)->update($upData);
        
        $response['status'] = true;
        $response['message'] = "Professional status change to ".$status;
        return response()->json($response);
    }

    public function profileStatus($status,Request $request)
    {
        $id = $request->input("id");
        $db_prefix = db_prefix();
        $professional = Professionals::where("id",$id)->first();
        $subdomain = $professional->subdomain;
        $database = $db_prefix.$subdomain;
        $professional_status = DB::table($database.".domain_details")->first();

        if($status == 'active'){
            $upData['profile_status'] = 2;
            $response['message'] = "Professional profile verified";
            $professional_detail = professionalDetail($subdomain);
            $mailData = array();
            $mailData['mail_message'] = "Hello ".$professional_detail->company_name.",<Br> Your professional profile has been approved. You are now ready to use the panel. You can <a href='".professionalDomain($subdomain)."'>Click Here</a>";
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = professionalAdmin($subdomain)->email;
            $parameter['to_name'] = professionalAdmin($subdomain)->first_name." ".professionalAdmin($subdomain)->last_name;
            $parameter['message'] = $message;
            $parameter['subject'] = "Professional profile approved";
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);
        }else{
            $upData['profile_status'] = 0;
            $response['message'] = "Professional profile unverified";

            $professional_detail = professionalDetail($subdomain);
            $mailData = array();
            $mailData['mail_message'] = "Hello ".$professional_detail->company_name.",<Br> Your professional profile has been inactivated. You can contact support team for further details.";
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = professionalAdmin($subdomain)->email;
            $parameter['to_name'] = professionalAdmin($subdomain)->first_name." ".professionalAdmin($subdomain)->last_name;
            $parameter['message'] = $message;
            $parameter['subject'] = "Professional profile inactivated";
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);
        }
        DB::table($database.".domain_details")->where('id',$professional_status->id)->update($upData);
        $response['status'] = true;
        
        return response()->json($response);
    }

    public function viewDetail($id){

        $id = base64_decode($id);

        $record = Professionals::where("id",$id)->first();
        $pd = $record->PersonalDetail($record->subdomain);
        $cd = $record->CompanyDetail($record->subdomain);
        $subdomain = $record->subdomain;
        $viewData['subdomain'] = $record->subdomain;

        $viewData['record'] = $record;
        $viewData['user'] = $pd;
        $viewData['company_details'] = $cd;
        $viewData['pageTitle'] = $pd->first_name;

        $language_id = $pd->languages_known;
        if($language_id != ''){
            $language_id = json_decode($language_id,true);
        }else{
            $language_id = array();    
        }

        $languages_known = array();
        foreach ($language_id as $key => $l) {
            $languages_known[] = $record->getLanguage($l);
        }

        $viewData['languages'] = implode(",",$languages_known);


        $license_id = $cd->license_body;
        if($license_id != ''){
            $license_id = json_decode($license_id,true);
        }else{
            $license_id = array();
        }

        $license_bodies = array();
        foreach ($license_id as $key => $l) {
            $license_bodies[] = $record->getLicenceBodies($l);
        }

        $viewData['licenceBodies'] = implode("<br>",$license_bodies);
        
        $countries = Countries::where('id',$pd->country_id)->first();

        $viewData['countries'] = $countries;

        $comp_countries = Countries::where('id',$cd->country_id)->first();
        $viewData['comp_countries'] = $comp_countries;

        $states = States::where('id',$pd->state_id)->first();
        $viewData['states'] = $states;

        $comp_states = States::where('id',$cd->state_id)->first();
        $viewData['comp_states'] = $comp_states;

        $cities = Cities::where('id',$pd->city_id)->first();
        $viewData['cities'] = $cities;

        $comp_cities = Cities::where('id',$cd->city_id)->first();
        $viewData['comp_cities'] = $comp_cities;

        $viewData['phonecode'] = $cities;
        $unread_chats = DB::table(MAIN_DATABASE.".support_chats")
                ->where("subdomain",$subdomain)
                ->where("sender_id","!=",\Auth::user()->unique_id)
                ->where("support_read",0)
                ->count();
        $viewData['unread_chats'] = $unread_chats;
        $viewData['activeTab'] = "professionals";
        return view(roleFolder().'.professionals.view-details',$viewData);
    }

    public function addNotes($id){
    
        $id = base64_decode($id);        
        $db_prefix = db_prefix();
        $record = Professionals::where("id",$id)->first();
        $subdomain = $record->subdomain;
        $database = $db_prefix.$subdomain;
        $notes = DB::table($database.".domain_details")->first();
        $viewData['notes'] = $notes->admin_notes;
        $viewData['notes_updated_on'] = $notes->notes_updated_on;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Add Notes";
        $view = View::make(roleFolder().'.professionals.modal.add-notes',$viewData);
        
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveNotes(Request $request){
        $id = $request->input("id");
        $db_prefix = db_prefix();
        $professional = Professionals::where("id",$id)->first();
        $subdomain = $professional->subdomain;
        $database = $db_prefix.$subdomain;
        $professional_status = DB::table($database.".domain_details")->first();

        if(!empty($request->input('notes'))){
            $upData['admin_notes'] = $request->input('notes');
            $upData['notes_updated_on'] = date('d-m-Y H:m:s');
        }

        DB::table($database.".domain_details")->where('id',$professional_status->id)->update($upData);
        $response['status'] = true;
        
        return response()->json($response);
    }

    public function editAllDatabase(){
        $viewData['pageTitle'] = "Upgrade all database";
        $view = View::make(roleFolder().'.professionals.modal.update-db',$viewData);
        
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateAllDatabase(Request $request){
        try{
            $records = Professionals::where('subdomain',"!=","fastzone")->get();
            foreach($records as $record){
                $database = PROFESSIONAL_DATABASE.$record->subdomain;

                $url = url('/replicate-db.php?database='.$database);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Content-Type: application/json',
                ));
                curl_setopt($ch, CURLOPT_POST, 1);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                
                $return = curl_exec($ch);
                
                $info = curl_getinfo($ch);
                curl_close($ch);
                $curl_response = json_decode($return,true);
                $response['status'] = true;
                $response['message'] = $curl_response['html'];
            }
            return $response;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchSupportChats(Request $request){
        $subdomain = $request->input("subdomain");

        DB::table(MAIN_DATABASE.".support_chats")
                ->where("subdomain",$subdomain)
                ->where("sender_id","!=",\Auth::user()->unique_id)
                ->where("support_read",0)
                ->update(['support_read'=>1]);

        $chats = DB::table(MAIN_DATABASE.".support_chats")
                ->where("subdomain",$subdomain)
                ->orderBy("id","asc")
                ->get();
        
        $viewData['chats'] = $chats;
        $view = View::make(roleFolder().'.professionals.chatbox',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }
    public function sendChatToSupport(Request $request){
        $file_id = randomNumber();
        $subdomain = $request->input("subdomain");
        $insData = array();
        $insData['unique_id'] = $file_id;
        $insData['subdomain'] = $subdomain;
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
        $subdomain = $request->input("subdomain");
        
        if ($file = $request->file('attachment')){
           

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = public_path('uploads/support');
            
            
            if($file->move($destinationPath, $newName)){
               
                $file_id = randomNumber();

                $insData = array();
                $insData['unique_id'] = $file_id;
                $insData['subdomain'] = $subdomain;
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

    // public function updateDatabase(Request $request){
    //     $professionals = Professionals::get();        
    //     foreach($professionals as $professional){

    //     }
    // }

    public function deleteProfessional(Request $request){
        try{
            $professional = Professionals::where("unique_id",$request->input("user_id"))->first();
            Professionals::deleteRecord($professional->id);
            $response['status'] = true;
            $response['message'] = "Professional deleted successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        
        return response()->json($response);
    }
}
