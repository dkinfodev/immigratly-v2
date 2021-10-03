<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;
use App\Models\Assessments;
use App\Models\AssessmentDocuments;
use App\Models\UserInvoices;
use App\Models\InvoiceItems;
use App\Models\VisaServices;
use App\Models\DocumentFolder;
use App\Models\UserDetails;
use App\Models\FilesManager;
use App\Models\Professionals;
use App\Models\ClientAssessments;
use App\Models\AssessmentReports;
use App\Models\AssessmentForms;
use App\Models\CvTypes;

class AssessmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function index(Request $request){
        $viewData['pageTitle'] = "Assessments";
        
        return view(roleFolder().'.assessments.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = Assessments::orderBy('id',"desc")
                                ->where(function($query) use($search){
                                    if($search != ''){
                                        $query->where("assessment_title","LIKE","%$search%");
                                    }
                                })
                            ->where("user_id",\Auth::user()->unique_id)
                            ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.assessments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(Request $request){
       
        $viewData['pageTitle'] = "Add Assessment";
        $visa_services = VisaServices::where('cv_type',\Auth::user()->UserDetail->cv_type)->get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.assessments.add',$viewData);
    }

    public function save(Request $request){
        $validation = array(
            'assessment_title' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
            'choose_professional' => 'required',
        );
        if($request->input("choose_professional") == 'manual'){
            $validation['professional'] = "required";
        }
        $validator = Validator::make($request->all(), $validation);
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
        
        $visa_service = VisaServices::where("unique_id",$request->input("visa_service_id"))->first();
        $unique_id = randomNumber();
        $object =  new Assessments();
        $object->unique_id = $unique_id;
        $object->assessment_title = $request->input("assessment_title");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->case_type = $request->input("case_type");
        $object->additional_comment = $request->input("additional_comment");
        
        $object->user_id = \Auth::user()->unique_id;
        $object->amount_paid = $visa_service->assessment_price;
        $object->choose_professional = $request->input("choose_professional");
        if($request->input("choose_professional") == 'manual'){
            $object->professional = $request->input("professional");
            $object->professional_assigned = 1;
        }else{
            $professionals = Professionals::get();
            $prof_ids = array();
            foreach($professionals as $prof){
                $check_service = professionalService($prof->subdomain,$request->input("visa_service_id"));
                $checkprof = checkProfessionalDB($prof->subdomain);

                if($checkprof == true){
                    $company_data = professionalDetail($prof->subdomain);
                    if(!empty($check_service) && !empty($company_data)){
                        $prof_ids[] = $prof->subdomain;
                    }
                }
            }
            if(!empty($prof_ids)){
                $key = array_rand($prof_ids);
                $professional = $prof_ids[$key];
                $object->professional = $professional;
                $object->professional_assigned = 1;
            }
        }
        
        // $object->payment_response = $request->input("payment_response");
        $object->save();
        
        $inv_unique_id = randomNumber();
        $object2 = new UserInvoices();
        $object2->unique_id = $inv_unique_id;
        $object2->client_id = \Auth::user()->unique_id;
        $object2->payment_status = "pending";
        $object2->amount = $visa_service->assessment_price;
        $object2->link_to = 'assessment';
        $object2->link_id = $unique_id;
        $object2->invoice_date = date("Y-m-d"); 
        $object2->created_by = \Auth::user()->unique_id;
        $object2->save();

        $object2 = new InvoiceItems();
        $object2->invoice_id = $inv_unique_id;
        $object2->unique_id = randomNumber();
        $object2->particular = "Assessment Fee";
        $object2->amount = $visa_service->assessment_price;
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('assessments/edit/'.$unique_id.'?step=2');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function edit($id,Request $request){
        if($request->get('step')){
            $viewData['active_step'] = $request->get("step");
        }else{
            $viewData['active_step'] = 1;
        }
        $viewData['pageTitle'] = "Edit Assessment";
        $record = Assessments::where("unique_id",$id)->first();
        $vs = VisaServices::where("unique_id",$record->visa_service_id)->first();
        
        if(!empty($vs)){
            $document_folders = $vs->DocumentFolders($vs->id);
        }else{
            $document_folders = array();
        }
        $viewData['document_folders'] = $document_folders;

        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;

        $pay_amount = $record->amount_paid;
        $invoice_id = $record->Invoice->unique_id;
        $viewData['invoice_id'] = $invoice_id;
        $viewData['pay_amount'] = $pay_amount;
        $viewData['record'] = $record;
        $visa_services = VisaServices::where('cv_type',\Auth::user()->UserDetail->cv_type)->get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.assessments.edit',$viewData);
    }
    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'assessment_title' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
            'choose_professional' => 'required',
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

        $validation = array(
            'assessment_title' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
            'choose_professional' => 'required',
        );
        if($request->input("choose_professional") == 'manual'){
            $validation['professional'] = "required";
        }
        $validator = Validator::make($request->all(), $validation);
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
        $subdomain = $request->input("professional");
        $assessment = Assessments::where('unique_id',$id)->first();
        $visa_service = VisaServices::where("unique_id",$request->input("visa_service_id"))->first();
        $unique_id = randomNumber();
        $object =  Assessments::find($assessment->id);
        $object->assessment_title = $request->input("assessment_title");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->case_type = $request->input("case_type");
        $object->additional_comment = $request->input("additional_comment");
        $object->user_id = \Auth::user()->unique_id;
        $object->amount_paid = $visa_service->assessment_price;
        $object->choose_professional = $request->input("choose_professional");
        if($request->input("choose_professional") == 'manual'){
            $object->professional = $request->input("professional");
            $object->professional_assigned = 1;
            $not_data = array();
            $not_data['send_by'] = 'client';
            $not_data['added_by'] = \Auth::user()->unique_id;
            $not_data['type'] = "assessment";
            $not_data['notification_type'] = "assessment";
            $not_data['title'] = "Assessment added by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
            
            if($request->input("doc_type") == 'extra'){
                $not_data['url'] = "cases/case-documents/extra/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("doc_type") == 'other'){
                $not_data['url'] = "cases/case-documents/other/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("doc_type") == 'default'){
                $not_data['url'] = "cases/case-documents/default/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("case_id") != ''){
                $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
            }
            if($request->input("document_id") != ''){
                $other_data[] = array("key"=>"document_id","value"=>$request->input("document_id"));
            }
            if(isset($other_data)){
                $not_data['other_data'] = $other_data;
            }
            
            sendNotification($not_data,"professional",$subdomain);
        }else{
            $professionals = Professionals::get();
            $prof_ids = array();
            foreach($professionals as $prof){
                $check_service = professionalService($prof->subdomain,$request->input("visa_service_id"));
                $company_data = professionalDetail($prof->subdomain);
                if(!empty($check_service) && !empty($company_data)){
                    $prof_ids[] = $prof->subdomain;
                }
            }
            if(!empty($prof_ids)){
                $key = array_rand($prof_ids);
                $professional = $prof_ids[$key];
                $object->professional = $professional;
                $object->professional_assigned = 1;
            }
        }
        // $object->payment_status = $request->input("payment_status");
        // $object->payment_response = $request->input("payment_response");
        $object->save();
       
        $check_inv = UserInvoices::where("link_to","assessment")->where("link_id",$assessment->unique_id)->first();
        if(!empty($check_inv)){
            $object2 = UserInvoices::find($check_inv->id);
            $inv_unique_id = $check_inv->unique_id;
        }else{
            $inv_unique_id = randomNumber();
            $object2 = new UserInvoices();
            $object2->unique_id = $inv_unique_id;
            $object2->payment_status = "pending";
            $object2->invoice_date = date("Y-m-d"); 
        }
        
        $object2->client_id = \Auth::user()->unique_id;
        
        $object2->amount = $visa_service->assessment_price;
        $object2->link_to = 'assessment';
        $object2->link_id = $assessment->unique_id;
        
        $object2->created_by = \Auth::user()->unique_id;
        $object2->save();

        $check_inv_item = InvoiceItems::where("invoice_id",$inv_unique_id)->first();
        if(!empty($check_inv_item)){
            $object2 = InvoiceItems::find($check_inv_item->id);
        }else{
            $object2 = new InvoiceItems();
            $object2->invoice_id = $inv_unique_id;
            $object2->unique_id = randomNumber();
        }
        
        
        $object2->particular = "Assessment Fee";
        $object2->amount = $visa_service->assessment_price;
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('assessments');
        $response['message'] = "Assessment submitted successfully";
        
        return response()->json($response);
    }

    public function view($id,Request $request){
        if($request->get('step')){
            $viewData['active_step'] = $request->get("step");
        }else{
            $viewData['active_step'] = 1;
        }
        $viewData['pageTitle'] = "View Assessment";
        $record = Assessments::with('Report')->where("unique_id",$id)->first();
        $vs = VisaServices::where("unique_id",$record->visa_service_id)->first();
        if(!empty($vs)){
            $document_folders = $vs->DocumentFolders($vs->id);
        }else{
            $document_folders = array();
        }
        $viewData['document_folders'] = $document_folders;

        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;

        $pay_amount = $record->amount_paid;
        $invoice_id = $record->Invoice->unique_id;
        $viewData['invoice_id'] = $invoice_id;
        $viewData['pay_amount'] = $pay_amount;
        $viewData['record'] = $record;
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        $assessment_id = $record->unique_id;
        $user_id = $record->user_id;
        $unread_notes = DB::table(MAIN_DATABASE.'.assessment_notes')
                ->where("assessment_id",$assessment_id)
                ->where("user_id",$user_id)
                ->where("is_read",0)
                ->where("created_by","!=",\Auth::user()->unique_id)
                ->count();
        $viewData['unread_notes'] = $unread_notes;
        return view(roleFolder().'.assessments.view-assessment',$viewData);
    }

    public function update2($id,Request $request){
        $validation = array(
            'assessment_title' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
            'choose_professional' => 'required',
        );
        if($request->input("choose_professional") == 'manual'){
            $validation['professional'] = "required";
        }
        $validator = Validator::make($request->all(), $validation);
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
        $visa_service = VisaServices::where("unique_id",$request->input("visa_service_id"))->first();
        $service_changed = 0;
        $object =  Assessments::where("unique_id",$id)->first();;
        $object->case_name = $request->input("case_name");
        if($object->visa_service_id != $request->input("visa_service_id")){
            $service_changed = 1;
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->case_type = $request->input("case_type");
        $object->additional_comment = $request->input("additional_comment");
        $object->amount_paid = $visa_service->assessment_price;
        $object->save();
        
        if($request->input("step") == 1){
            $assessment = Assessments::where("id",$object->id)->first();
            $object2 = UserInvoices::where("link_id",$assessment->unique_id)->where('link_to','assessment')->first();
            $object2->amount = $visa_service->assessment_price;
            if($service_changed == 1){
                $object2->payment_status = "pending";
            }
            $object2->save();
            
            $assessment_invoice = UserInvoices::where("link_id",$assessment->unique_id)->where('link_to','assessment')->first();
            $object2 = InvoiceItems::where('invoice_id',$assessment_invoice->unique_id)->first();
            $object2->amount = $visa_service->assessment_price;
            $object2->save();
        }
        $response['status'] = true;
        if($request->input("step")){
            $next_step = (int)$request->input("step") + 1;
            $response['redirect_back'] = baseUrl('assessments/edit/'.$object->unique_id."?step=".$next_step);
        }else{
            $response['redirect_back'] = baseUrl('assessments');    
        }
        
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Assessments::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Assessments::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function fetchDocuments($assessment_id,$folder_id,Request $request){
        
        $folder = DocumentFolder::where("unique_id",$folder_id)->first();
        $documents = AssessmentDocuments::orderBy('id',"desc")
                                    ->where("user_id",\Auth::user()->unique_id)
                                    ->where("assessment_id",$assessment_id)
                                    ->where("folder_id",$folder_id)
                                    ->get();
        $assessment = Assessments::where("unique_id",$assessment_id)->first();
        $viewData['documents'] = $documents;
        $viewData['assessment_id'] = $assessment_id;
        $viewData['assessment'] = $assessment;
        $viewData['folder'] = $folder;
        $user_details = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $viewData['user_details'] = $user_details;
        $file_dir = userDir()."/documents";
        $file_url = userDirUrl()."/documents";
        $viewData['file_dir'] = $file_dir;
        $viewData['file_url'] = $file_url;
        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;
        $viewData['action'] = $request->input("action");
        $view = View::make(roleFolder().'.assessments.document-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);        
    }
    
    public function fetchGoogleDrive($folder_id,Request $request){

        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $assessment_id = $request->input("assessment_id");
        $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
        $drive = create_crm_gservice($google_drive_auth['access_token']);
        $drive_folders = get_gdrive_folder($drive);
        if(isset($drive_folders['gdrive_files'])){
            $drive_folders = $drive_folders['gdrive_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['pageTitle'] = "Google Drive Folders";
        $viewData['drive_folders'] = $drive_folders;
        $viewData['folder_id'] = $folder_id;
        $viewData['assessment_id'] = $assessment_id;
        $view = View::make(roleFolder().'.assessments.modal.google-drive',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);  
    }

    public function googleDriveFilesList(Request $request){
        $folder_id = $request->input("folder_id");
        $folder = $request->input("folder_name");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
        $drive = create_crm_gservice($google_drive_auth['access_token']);
        $drive_folders = get_gdrive_folder($drive,$folder_id,$folder);
        if(isset($drive_folders['gdrive_files'])){
            $drive_folders = $drive_folders['gdrive_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['drive_folders'] = $drive_folders;
        $view = View::make(roleFolder().'.assessments.modal.google-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function uploadFromGdrive(Request $request){
        
        if($request->input("files")){
            $files = $request->input("files");
            $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
            $access_token = $google_drive_auth['access_token'];
            $folder_id = $request->input("folder_id");
            $assessment_id = $request->input("assessment_id");
            
            foreach($files as $key => $fileId){
                $i = $key;
                $ch = curl_init();
                $method = "GET";
                // get file type
                $endpoint = 'https://www.googleapis.com/drive/v3/files/'.$fileId;
                curl_setopt($ch, CURLOPT_URL,$endpoint);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$access_token['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $curl_response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $file = json_decode($curl_response,true);
                // get file base64 format
                $ch = curl_init();
                $endpoint = 'https://www.googleapis.com/drive/v3/files/'.$fileId.'?alt=media';
                curl_setopt($ch, CURLOPT_URL,$endpoint);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$access_token['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $api_response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $base64_code = $api_response;
                $original_name = $file['name'];
                
                $newName = time()."-".$original_name;
                $path = userDir()."/documents";
                if(file_put_contents($path."/".$newName, $base64_code)){
                    $unique_id = randomNumber();
                    $object = new FilesManager();
                    $object->file_name = $newName;
                    $object->original_name = $original_name;
                    $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                    $object->file_type = $ext;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->save();

                    $object2 = new AssessmentDocuments();
                    $object2->user_id = \Auth::user()->unique_id;
                    $object2->assessment_id = $assessment_id;
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->added_by = \Auth::user()->unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = 'File uploaded from google drive successfully!';
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }

    public function fetchDropboxFolder($folder_id,Request $request){

        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
        $assessment_id = $request->input("assessment_id");
        $drive_folders = dropbox_files_list($dropbox_auth);
        
        if(isset($drive_folders['dropbox_files'])){
            $drive_folders = $drive_folders['dropbox_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['pageTitle'] = "Dropbox Folders";
        $viewData['drive_folders'] = $drive_folders;
        $viewData['folder_id'] = $folder_id;
        $viewData['assessment_id'] = $assessment_id;
        $view = View::make(roleFolder().'.assessments.modal.dropbox-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);  
    }

    public function dropboxFilesList(Request $request){
        $folder_id = $request->input("folder_id");
        $folder = $request->input("folder_name");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
        $drive_folders = dropbox_files_list($dropbox_auth,$folder_id);
        
        if(isset($drive_folders['dropbox_files'])){
            $drive_folders = $drive_folders['dropbox_files'];
        }else{
            $drive_folders = array();
        }
        // pre($drive_folders);
        $viewData['drive_folders'] = $drive_folders;
        $view = View::make(roleFolder().'.assessments.modal.dropbox-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function uploadFromDropbox(Request $request){
        
        if($request->input("files")){
            $files = $request->input("files");
            $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
            $folder_id = $request->input("folder_id");
            $assessment_id = $request->input("assessment_id");
            foreach($files as $key => $fileId){
                $i = $key;
                $fileinfo = explode(":::",$fileId);
                $original_name = $fileinfo[1];
                $file_path = $fileinfo[0];
                $newName = time()."-".$original_name;
                $path = userDir()."/documents";
                $destinationPath = $path."/".$newName;
                
                $is_download = dropbox_file_download($dropbox_auth,$file_path,$destinationPath);

                if(file_exists($destinationPath)){
                    $unique_id = randomNumber();
                    $object = new FilesManager();
                    $object->file_name = $newName;
                    $object->original_name = $original_name;
                    $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                    $object->file_type = $ext;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->save();

                    $object2 = new AssessmentDocuments();
                    $object2->user_id = \Auth::user()->unique_id;
                    $object2->assessment_id = $assessment_id;
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->added_by = \Auth::user()->unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = 'File uploaded from google drive successfully!';
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }
    
    public function uploadDocuments(Request $request){
        try{
            $id = \Auth::user()->unique_id;
            $folder_id = $request->input("folder_id");
            $assessment_id = $request->input("assessment_id");
            $failed_files = array();
            if($file = $request->file('file'))
            {
                $fileName        = $file->getClientOriginalName();
                $extension       = ".".$file->getClientOriginalExtension();
                $allowed_extension = allowed_extension();
               
                if(in_array($extension,$allowed_extension)){
                    $newName        = randomNumber(5)."-".$fileName;
                    $source_url = $file->getPathName();
                    $destinationPath = userDir()."/documents";
                    if($file->move($destinationPath, $newName)){
                        $unique_id = randomNumber();
                        $object = new FilesManager();
                        $object->file_name = $newName;
                        $object->original_name = $fileName;
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $object->file_type = $ext;
                        $object->user_id = $id;
                        $object->unique_id = $unique_id;
                        $object->created_by = \Auth::user()->unique_id;
                        $object->save();

                        $object2 = new AssessmentDocuments();
                        $object2->user_id = \Auth::user()->unique_id;
                        $object2->assessment_id = $assessment_id;
                        $object2->folder_id = $folder_id;
                        $object2->file_id = $unique_id;
                        $object2->added_by = \Auth::user()->unique_id;
                        $object2->unique_id = randomNumber();
                        $object2->save();
                        $response['status'] = true;
                        $response['message'] = 'File uploaded!';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'File not uploaded!';
                    }
                }else{
                    $response['status'] = false;
                    $response['message'] = "File not allowed";
                } 
            }else{
                $response['status'] = false;
                $response['message'] = 'Please select the file';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    
    public function viewDocument($file_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $folder_id = $request->get("folder_id");
         $assessment_id = $request->get("assessment_id");
        $ext = fileExtension($filename);
        $subdomain = $request->get("p");

        $viewData['url'] = $url;
        $viewData['extension'] = $ext;
        $viewData['document_id'] = $file_id;
        $viewData['assessment_id'] = $assessment_id;
        $viewData['folder_id'] = $folder_id;
        $viewData['pageTitle'] = "View Documents";
        return view(roleFolder().'.assessments.view-documents',$viewData);
    }
    
    public function deleteDocument($id){
        $id = base64_decode($id);
        AssessmentDocuments::deleteRecord($id);
        return redirect()->back()->with("success","Document has been deleted!");
    }

    public function findProfessional(Request $request){


        $results = Professionals::get();
        $professionals = array();
        foreach ($results as $key => $prof) {
            $checkprof = checkProfessionalDB($prof->subdomain);

            if($checkprof == true){
                $professionals[] = $prof;
            }   
        }
        $viewData['professionals'] = $professionals;
        $viewData['visa_service_id'] = $request->input("visa_service_id");
        if($request->input("professional")){
            $viewData['professional'] = $request->input("professional");
        }else{
            $viewData['professional'] = '';
        }
        $view = View::make(roleFolder().'.assessments.professionals',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function findDocuments(Request $request){
        $vs = VisaServices::where("unique_id",$request->input("visa_service_id"))->first();
        if(!empty($vs)){
            $document_folders = $vs->DocumentFolders($vs->id);
        }else{
            $document_folders = array();
        }
        $viewData['document_folders'] = $document_folders;
       
        $view = View::make(roleFolder().'.assessments.visa-documents',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function fetchNotes(Request $request){
        $assessment_id = $request->input("assessment_id");
        $user_id = $request->input("user_id");
        $assessment = Assessments::where("unique_id",$assessment_id)->first();
        $viewData['user_id'] = $user_id;
        $viewData['assessment_id'] = $assessment_id;
        $viewData['assessment'] = $assessment;
        $viewData['subdomain'] = $assessment->professional;
        
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
        $insData['send_by'] = 'client';
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
                $insData['send_by'] = 'client';
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

    public function downloadReport($id){
        $report = AssessmentReports::where("assessment_id",$id)->first();
        $assessment = Assessments::with('VisaService')->where("unique_id",$id)->first();
        $viewData['report'] = $report->toArray();
        $viewData['record'] = $assessment->toArray();

        // $view = View::make(roleFolder().'.assessments.report',$viewData);
        // $contents = $view->render();
        // echo $contents;
        // exit;
        $pdf_doc = \PDF::loadView(roleFolder().'.assessments.report', $viewData);
        return $pdf_doc->download('report.pdf');
    }

    public function forms($id,Request $request){
        $viewData['pageTitle'] = "Assessment Forms";
        $assessment = Assessments::where("unique_id",$id)->first();
        $viewData['record'] = $assessment;
        $viewData['user_id'] = $assessment->user_id;
        $viewData['assessment_id'] = $id;
        
        return view(roleFolder().'.assessments.forms.lists',$viewData);
    }

    public function getFormList($assessment_id,Request $request)
    {
        $search = $request->input("search");
        $records = AssessmentForms::orderBy('id',"desc")
                    ->where(function($query) use($search){
                        if($search != ''){
                            $query->where("form_title","LIKE","%$search%");
                        }
                    })
                    ->where("assessment_id",$assessment_id)
                    ->paginate();
        $viewData['assessment_id'] = $assessment_id;
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.assessments.forms.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function viewForm($assessment_id,$id,Request $request){
        $record = AssessmentForms::where("unique_id",$id)->first();
        $form_json = json_decode($record->form_json,true);
        if($record->form_reply != ''){
            $postData = json_decode($record->form_reply,true);
            
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
                                        $temp['value'] = $value['value'];
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
            $form_json = json_encode($form_reply);
        }
        else{
            $form_json = $record->form_json;
        }
        
        $viewData['form_json'] = $form_json;
        $viewData['record'] = $record;
        $viewData['assessment_id'] = $assessment_id;
        $viewData['pageTitle'] = "Assessment Form";
        
        return view(roleFolder().'.assessments.forms.view',$viewData);
    }

    public function saveForm($assessment_id,$id,Request $request)
    {
        $postData = $request->all();
        unset($postData['_token']);
        $record = AssessmentForms::where("unique_id",$id)->first();
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
            $object = AssessmentForms::where("unique_id",$id)->first();
            $object->form_reply = json_encode($postData);
            $object->save();

            return redirect()->back()->with("success","Record saved successfully");
        }else{
            return redirect()->back()->with("error","Something went wrong, try again!");
        }
    }

    public function visaServices(){
        $viewData['pageTitle'] = "Choose Visa Service";
        $cv_types = CvTypes::whereHas('VisaServices')->get();
        $viewData['cv_types'] = $cv_types;
        $view = View::make(roleFolder().'.assessments.modal.visa-services',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }
}
