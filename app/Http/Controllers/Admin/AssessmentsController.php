<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Leads;
use App\Models\ProfessionalDetails;

class AssessmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request){
        $viewData['pageTitle'] = "Assessments";
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.lists',$viewData);
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
       
        $result = curlRequest("assessments?page=".$page,$apiData);
       
        $viewData = array();
        if($result['status'] == 'success'){
            $viewData['records'] = $result['data'];
            
            $response['last_page'] = $result['last_page'];
            $response['current_page'] = $result['current_page'];
            $response['total_records'] = $result['total_records'];
        }else{
            $viewData['records'] = array();
        }
        $view = View::make(roleFolder().'.assessments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function view($id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['assessment_id'] = $id;
        $apiData['mark_as_read'] = 1;
        $result = curlRequest("assessments/detail",$apiData);
   
        $viewData = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $assessment_id = $record['unique_id'];
            $user_id = $record['user_id'];
            $viewData['record'] = $record;
            $assessment = $result['data'];
            $viewData['document_folders'] = $result['document_folders'];
            $viewData['user_id'] = $assessment['user_id'];
            $unread_notes = DB::table(MAIN_DATABASE.'.assessment_notes')
                ->where("assessment_id",$assessment_id)
                ->where("user_id",$user_id)
                ->where("is_read",0)
                ->where("created_by","!=",\Auth::user()->unique_id)
                ->count();
            $viewData['unread_notes'] = $unread_notes;
        }else{
            return redirect(baseUrl('/assessments'))->with("error","Invalid assessment");
        }
        $viewData['pageTitle'] = "Assessment Detail";
        $viewData['visa_services'] = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.view-assessment',$viewData);
    }

    public function fetchDocuments($assessment_id,$folder_id,Request $request){
        

        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['assessment_id'] = $assessment_id;
        $apiData['folder_id'] = $folder_id;
        $apiData['user_id'] = $request->input("user_id");
        $result = curlRequest("assessments/documents",$apiData);
        $viewData = array();
        
        if($result['status'] == 'success'){
            $data = $result['data'];
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }

        $folder = $data['folder'];
        $documents = $data['documents'];
        $assessment = $data['assessment'];
        $viewData['documents'] = $documents;
        $viewData['assessment'] = $assessment;
    
        $viewData['folder'] = $folder;
        $user_details = $data['user_details'];
        $viewData['user_details'] = $user_details;
        $viewData['file_dir'] = $data['file_dir'];
        $viewData['file_url'] = $data['file_url'];
        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;
        $viewData['action'] = "view";
        $view = View::make(roleFolder().'.assessments.document-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);        
    }
    public function fetchNotes(Request $request){
        $assessment_id = $request->input("assessment_id");
        $user_id = $request->input("user_id");
        $viewData['user_id'] = $user_id;
        $viewData['assessment_id'] = $assessment_id;
        $viewData['subdomain'] = \Session::get("subdomain");
        
        $notes = DB::table(MAIN_DATABASE.'.assessment_notes')
                ->where("assessment_id",$assessment_id)
                ->where("user_id",$user_id)
                ->get();

        
        $viewData['notes'] = $notes;
        DB::table(MAIN_DATABASE.'.assessment_notes')
                ->where("assessment_id",$assessment_id)
                ->where("user_id",$user_id)
                ->where("created_by","!=",\Auth::user()->unique_id)
                ->update(['is_read'=>1]);

        $unread_notes = DB::table(MAIN_DATABASE.'.assessment_notes')
                ->where("assessment_id",$assessment_id)
                ->where("user_id",$user_id)
                ->where("is_read",0)
                ->where("created_by","!=",\Auth::user()->unique_id)
                ->count();
        
        $view = View::make(roleFolder().'.assessments.notes',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        $response['unread_notes'] = $unread_notes;
        return response()->json($response);
    }
    public function saveAssessmentNote(Request $request){
        $assessment_id = $request->input("assessment_id");
        $user_id = $request->input("user_id");
        $unique_id = randomNumber();
        $insData['assessment_id'] = $assessment_id;
        $insData['unique_id'] = $unique_id;
        $insData['user_id'] = $user_id;
        $insData['type'] = 'text';
        $insData['message'] = $request->input("message");
        $insData['send_by'] = \Auth::user()->role;
        $insData['created_by'] = \Auth::user()->unique_id;
        $insData['created_at'] = date("Y-m-d H:i:s");
        $insData['updated_at'] = date("Y-m-d H:i:s");
        DB::table(MAIN_DATABASE.'.assessment_notes')->insert($insData);
       
        $response['status'] = true;
        $response['message'] = "Note send successfully";
        
        
        return response()->json($response);
    }

    public function saveAssessmentFile(Request $request){

        if ($file = $request->file('attachment')){
            $assessment_id = $request->input("assessment_id");
            $user_id = $request->input("user_id");
            $unique_id = randomNumber();
            $data['assessment_id'] = $request->input("assessment_id");

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = userDir($user_id)."/assessments/".$assessment_id;
            
            
            if($file->move($destinationPath, $newName)){
               
                $insData['assessment_id'] = $assessment_id;
                $insData['unique_id'] = $unique_id;
                $insData['user_id'] = $user_id;
                $insData['file_name'] = $newName;
                $insData['type'] = 'file';
                $insData['send_by'] = \Auth::user()->role;
                $insData['created_by'] = \Auth::user()->unique_id;
                $insData['created_at'] = date("Y-m-d H:i:s");
                $insData['updated_at'] = date("Y-m-d H:i:s");
                DB::table(MAIN_DATABASE.'.assessment_notes')->insert($insData);
                
                $response['status'] = true;
                $response['message'] = "File send!";
            }else{
                $response['status'] = false;
                $response['message'] = "File send failed, try again!";
            }
        }else{
            $response['status'] = false;
            $response['message'] = "File not selected!";
        }
        
        return response()->json($response);
    }

    public function report($id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['assessment_id'] = $id;
        $result = curlRequest("assessments/detail",$apiData);
        $viewData = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $assessment_id = $record['unique_id'];
            $user_id = $record['user_id'];
            $viewData['record'] = $record;
            $assessment = $result['data'];
            $viewData['document_folders'] = $result['document_folders'];
            $viewData['user_id'] = $assessment['user_id'];
            $unread_notes = DB::table(MAIN_DATABASE.'.assessment_notes')
                ->where("assessment_id",$assessment_id)
                ->where("user_id",$user_id)
                ->where("is_read",0)
                ->where("created_by","!=",\Auth::user()->unique_id)
                ->count();
            $apiData = array();
            $apiData['assessment_id'] = $id;
            $result = curlRequest("assessments/fetch-report",$apiData);
            $report = array();
            if($result['status'] == 'success'){
                $response['status'] = true;
                $report = $result['data'];
            }
            $viewData['report'] = $report;
            $viewData['unread_notes'] = $unread_notes;
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        $viewData['pageTitle'] = "Assessment Report";
        $viewData['visa_services'] = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.report',$viewData);
    }

    public function saveReport($id,Request $request){
        
        
        $validator = Validator::make($request->all(),[
            'case_review' => 'required',
            'strength_of_case' => 'required',
            'weakness_of_case' => 'required',
            'case_quality'=>'required',
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

        $apiData = $request->input();
        $apiData['added_by'] = \Auth::user()->unique_id;
        $apiData['assessment_id'] = $id;
        $result = curlRequest("assessments/save-report",$apiData);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = $result['message'];
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while saving article";

        }
        return response()->json($response);
    }

    public function forms($id,Request $request){
        $viewData['pageTitle'] = "Assessment Forms";
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['assessment_id'] = $id;
        $result = curlRequest("assessments/detail",$apiData);
        if($result['status'] == 'success'){
            $record = $result['data'];
            $assessment_id = $record['unique_id'];
            $user_id = $record['user_id'];
            $viewData['record'] = $record;
            $assessment = $result['data'];
            
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        $viewData['assessment_id'] = $id;
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.forms.lists',$viewData);
    }

    public function getFormList($assessment_id,Request $request)
    {
        $search = $request->input("search");
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['assessment_id'] = $assessment_id;
        $apiData['search'] = $search;
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
        $result = curlRequest("assessments/forms?page=".$page,$apiData);
        $viewData = array();
       
        if($result['status'] == 'success'){
            $viewData['records'] = $result['data'];
            $response['last_page'] = $result['last_page'];
            $response['current_page'] = $result['current_page'];
            $response['total_records'] = $result['total_records'];
        }else{
            $viewData['records'] = array();
        }
        $viewData['assessment_id'] = $assessment_id;
        $view = View::make(roleFolder().'.assessments.forms.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function addForm($id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['assessment_id'] = $id;
        $result = curlRequest("assessments/detail",$apiData);
        $viewData = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $assessment_id = $record['unique_id'];
            $user_id = $record['user_id'];
            $viewData['record'] = $record;
            $viewData['assessment_id'] = $assessment_id;
            $assessment = $result['data'];
            
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        $viewData['pageTitle'] = "Assessment Form";
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.forms.add',$viewData);
    }

    public function saveForm($assessment_id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_title' => 'required',
            'form_json' => 'required'
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
        $form_json = $request->input("form_json");
        $json_data = array();
        foreach($form_json as $json){
            $temp = $json;
            foreach($json as $key => $value){
                if($value == "true"){
                    $temp[$key] = true;
                }
                if($value == "false"){
                    $temp[$key] = false;
                }
            }
            $json_data[] = $temp;
        }
        $apiData['form_title'] = $request->input("form_title");
        $apiData['form_json'] = json_encode($json_data);
        $apiData['assessment_id'] = $assessment_id;
        $apiData['added_by'] = \Auth::user()->unique_id;
        $apiData['subdomain'] = \Session::get("subdomain");
        $result = curlRequest("assessments/save-form",$apiData);
        $viewData = array();
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "Assessment form saved";
            $response['redirect_back'] = baseUrl("assessments/forms/".$assessment_id);
        }else{
            $response['status'] = false;
            $response['message'] = "Error while saving form";
        }
        return response()->json($response);
    }

    public function editForm($assessment_id,$id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['form_id'] = $id;
        $result = curlRequest("assessments/fetch-form",$apiData);
        $viewData = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $assessment_id = $assessment_id;
            $viewData['record'] = $record;
            $viewData['assessment_id'] = $assessment_id;
            $assessment = $result['data'];
            
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        $viewData['pageTitle'] = "Edit Assessment Form";
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.forms.edit',$viewData);
    }

    public function updateForm($assessment_id,$id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_title' => 'required',
            'form_json' => 'required'
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
        $form_json = $request->input("form_json");
        $json_data = array();
        foreach($form_json as $json){
            $temp = $json;
            foreach($json as $key => $value){
                if($value == "true"){
                    $temp[$key] = true;
                }
                if($value == "false"){
                    $temp[$key] = false;
                }
            }
            $json_data[] = $temp;
        }
        $apiData['form_title'] = $request->input("form_title");
        $apiData['form_json'] = json_encode($json_data);
        $apiData['assessment_id'] = $assessment_id;
        $apiData['form_id'] = $id;
        $apiData['subdomain'] = \Session::get("subdomain");
        $result = curlRequest("assessments/update-form",$apiData);
        $viewData = array();
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "Assessment form saved";
            $response['redirect_back'] = baseUrl("assessments/forms/".$assessment_id);
        }else{
            $response['status'] = false;
            $response['message'] = "Error while saving form";
        }
        return response()->json($response);
    }

    public function deleteFormSingle($assessment_id,$id){
       
        $apiData['id'] = $id;
        $apiData['action'] = 'single';
        $result = curlRequest("assessments/delete-form",$apiData,true);

        if($result['status'] == 'success'){
            return redirect()->back()->with("success","Form has been deleted!");
        }else{
            return redirect()->back()->with("error","Some issue while deleting!");
        }
        
    }
    public function deleteFormMultiple($assessment_id,Request $request){
        $ids = $request->input("ids");
        $apiData['ids'] = $ids;
        $apiData['action'] = 'multiple';
        $result = curlRequest("assessments/delete-form",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('assessments/forms/'.$assessment_id);
            $response['message'] = $result['message'];
            $response['status'] = true;
            \Session::flash('success', 'Records deleted successfully'); 
            
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while deleting";
            \Session::flash('success', 'Some issue while deleting'); 
        }
        return response()->json($response);
    }

    public function viewForm($assessment_id,$id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['form_id'] = $id;
        $result = curlRequest("assessments/fetch-form",$apiData);
        $viewData = array();
        $form_json = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $viewData['record'] = $record;
            $form_json = json_decode($record['form_json'],true);
            if($record['form_reply'] != ''){
                $postData = json_decode($record['form_reply'],true);
                $form_reply = array();
                foreach($form_json as $form){
                    $temp = array();
                   
                    if(isset($form['name']) && isset($postData[$form['name']])){
                        if(isset($form['values'])){
                            $values = $form['values'];
                            $final_values = array();
                            foreach($values as $value){
                                $tempVal = $value;
                                if(is_array($postData[$form['name']])){
                                    if(in_array($value['value'],$postData[$form['name']])){
                                        $tempVal['selected'] = true;
                                        
                                    }else{
                                        $tempVal['selected'] = false;
                                    }
                                }else{
                                    if($value['value'] == $postData[$form['name']]){
                                        $tempVal['selected'] = true;
                                        if($form['type'] == 'autocomplete'){
                                            $temp['value'] = $value['label'];
                                        }
                                    }else{
                                        $tempVal['selected'] = false;
                                    }
                                }
                                $final_values[] = $tempVal;
                            }
                        }else{
                            $temp['value'] = $postData[$form['name']];
                        }
                    }
                    if(isset($temp['value'])){
                        $temp['label'] = $form['label'];
                        $form_reply[] = $temp;
                    }
                }
                $form_json = $form_reply;
            }
            $viewData['assessment_id'] = $assessment_id;
            $viewData['form_json'] = $form_json;
            
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        
        $viewData['pageTitle'] = "Assessment Reply";
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.forms.view',$viewData);
    }

    public function viewDocument($doc_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $folder_id = $request->get("folder_id");
        $ext = fileExtension($filename);
        $subdomain = $request->get("p");

        $viewData['url'] = $url;
        $viewData['extension'] = $ext;
        $viewData['subdomain'] = $subdomain;
        $viewData['document_id'] = $doc_id;
        $viewData['folder_id'] = $folder_id;
        $viewData['pageTitle'] = "View Documents";
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.view-documents',$viewData);
    }

    

    public function sendAssessmentToMail($assessment_id,$form_id,Request $request)
    {
        $viewData = array();
        $viewData['pageTitle'] = "Send Assessment Link to Mail";
        $viewData['assessment_id'] = $assessment_id;
        $viewData['form_id'] = $form_id;
        $view = View::make(roleFolder().'.assessments.forms.send-mail',$viewData);
        $contents = $view->render();
        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function sendAssessmentLink($assessment_id,$form_id,Request $request){
        $validator = Validator::make($request->all(), [
            'emails' => 'required',
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
        $emails = json_decode($request->input("emails"),true);
        $valid_email = 1;
        for($i=0;$i < count($emails);$i++){
            $email = $emails[$i]['value'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $valid_email = 0;
            }
        }
        if($valid_email ==  0){
            $response['message'] = "Please enter valid email address!";
            $response['status'] = false;
            $response['error_type'] = 'invalid_data';
            return response()->json($response);
        }

        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['form_id'] = $form_id;
        $result = curlRequest("assessments/fetch-form",$apiData);
        $viewData = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $assessment_id = $assessment_id;
            $viewData['record'] = $record;
            $viewData['assessment_id'] = $assessment_id;
            
            $professional = ProfessionalDetails::first();
            $url = site_url()."/assessment/u/".$record['uuid'];
            $mail_message = "Hi User,<br> ".$professional->company_name." has send you the assessment form. Please click to below link.<br> <a href='".$url."'>".$url."</a>";
            $mailData['mail_message'] = $mail_message;
            $view = View::make('emails.notification',$mailData);
            $message = $view->render();
           
            $mail_failed = 0;
            for($i=0;$i < count($emails);$i++){
                $email = $emails[$i]['value'];
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $parameter['to'] = $email;
                    $parameter['message'] = $message;
                    $parameter['view'] = "emails.notification";
                    $parameter['subject'] = "Assessment for send by ".$professional->company_name;
                    $parameter['data'] = $mailData;
                    // pre($parameter);
                    $mailRes = sendMail($parameter);
                    if(!$mailRes){
                        $mail_failed = 1;
                    }
                }
            }
            if($mail_failed != 1){
                $response['status'] = true;
                $response['message'] = "Mail has beend sent successfullly";
            }else{
                $response['status'] = false;
                $response['message'] = "Error while sending email";
            }
            return response()->json($response);
        }else{
            $response['message'] = "Invalid assessment";
            $response['status'] = false;
            $response['error_type'] = 'invalid_data';
            return response()->json($response);
        }

        
    }
}
