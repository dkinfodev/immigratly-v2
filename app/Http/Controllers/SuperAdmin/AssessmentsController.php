<?php

namespace App\Http\Controllers\SuperAdmin;

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
use App\Models\UserWithProfessional;

class AssessmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function index(Request $request){
        $viewData['pageTitle'] = "Assessments";
        $viewData['assigned'] = 0;
        $assigned_count = Assessments::where('professional_assigned',"1")->count();
        $new_count = Assessments::where('professional_assigned',"0")->count();        
        $total_assessments = $assigned_count + $new_count;
        $viewData['assigned_count'] = $assigned_count;
        $viewData['new_count'] = $new_count;
        $viewData['total_assessments'] = $total_assessments;
        return view(roleFolder().'.assessments.lists',$viewData);
    }

    public function assigned(Request $request){
        $viewData['pageTitle'] = "Assigned Assessments";
        $viewData['assigned'] = 1;
        $assigned_count = Assessments::where('professional_assigned',"1")->count();
        $new_count = Assessments::where('professional_assigned',"0")->count();        
        $total_assessments = $assigned_count + $new_count;
        $viewData['assigned_count'] = $assigned_count;
        $viewData['new_count'] = $new_count;
        $viewData['total_assessments'] = $total_assessments;
        return view(roleFolder().'.assessments.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {   
        $search = $request->input("search");
        $assigned = $request->input("assigned");
        $records = Assessments::with(['Client'])
                                ->where("professional_assigned",$assigned)
                                ->where(function($query) use($search){
                                    if($search != ''){
                                        $query->where("case_name","LIKE","%$search%");
                                    }
                                })
                                ->orderBy('id',"desc")
                                ->paginate();

        $viewData['records'] = $records;
        $viewData['assigned'] = $assigned;
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
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.assessments.add',$viewData);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'case_name' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
            // 'amount_paid' => 'required',
            // 'payment_status' => 'required',
            // 'payment_response' => 'required',
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
        $visa_service = VisaServices::where("unique_id",$request->input("visa_service_id"))->first();
        $unique_id = randomNumber();
        $object =  new Assessments();
        $object->unique_id = $unique_id;
        $object->case_name = $request->input("case_name");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->case_type = $request->input("case_type");
        $object->user_id = \Auth::user()->unique_id;
        $object->amount_paid = $visa_service->assessment_price;
        // $object->payment_status = $request->input("payment_status");
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
        $viewData['pageTitle'] = "View Assessment";
        $record = Assessments::where("unique_id",$id)->first();
        $vs = VisaServices::where("unique_id",$record->visa_service_id)->first();
        if(!empty($vs)){
            $document_folders = $vs->DocumentFolders($vs->id);
        }else{
            $document_folders = array();
        }
        $viewData['document_folders'] = $document_folders;
        $pay_amount = $record->amount_paid;
        $invoice_id = $record->Invoice->unique_id;
        $viewData['invoice_id'] = $invoice_id;
        $viewData['pay_amount'] = $pay_amount;
        $viewData['record'] = $record;
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.assessments.edit',$viewData);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'case_name' => 'required',
            'visa_service_id' => 'required',
            'case_type' => 'required',
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
                                    ->where("assessment_id",$assessment_id)
                                    ->where("folder_id",$folder_id)
                                    ->get();
        $assessment = Assessments::where("unique_id",$assessment_id)->first();
        $viewData['documents'] = $documents;
        $viewData['assessment'] = $assessment;
        $viewData['folder'] = $folder;
        $user_id = $assessment->user_id;
        $user_details = UserDetails::where("user_id",$user_id)->first();
        $viewData['user_details'] = $user_details;
        $file_dir = userDir($user_id)."/documents";
        $file_url = userDirUrl($user_id)."/documents";
        $viewData['file_dir'] = $file_dir;
        $viewData['file_url'] = $file_url;
        $viewData['assessment_id'] = $assessment_id;
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
                $extension       = $file->getClientOriginalExtension();
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
        $viewData['folder_id'] = $folder_id;
        $viewData['assessment_id'] = $assessment_id;
        $viewData['pageTitle'] = "View Documents";
        return view(roleFolder().'.assessments.view-documents',$viewData);
    }
    
    public function deleteDocument($id){
        $id = base64_decode($id);
        AssessmentDocuments::deleteRecord($id);
        return redirect()->back()->with("success","Document has been deleted!");
    }

    public function assignToProfessional($id,Request $request){

        $assessment = Assessments::where("unique_id",$id)->first();
        $viewData['assessment'] = $assessment;
        $professionals = Professionals::get();
        $viewData['professionals'] = $professionals;
        $viewData['pageTitle'] = "Professioanls";
        $view = View::make(roleFolder().'.assessments.modal.professionals',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function assignAssessment($assessment_id,Request $request){
        $object = Assessments::where("unique_id",$assessment_id)->first();
        $object->professional_assigned = 1;
        $object->professional = $request->input("professional");
        $object->save();

        $assessment = Assessments::with('AssessmentDocuments')->where("unique_id",$assessment_id)->first();

        $apiData['created_by'] = \Auth::user()->unique_id;
        $apiData['assessment'] = $assessment;
        $subdomain = $request->input("professional");
        $check_is_exists = UserWithProfessional::where("professional",$subdomain)->count();
        if($check_is_exists === 0){
            $object2 = new UserWithProfessional();
            $object2->user_id = $object->user_id;
            $object2->professional= $subdomain;
            $object2->status = 1;
            $object2->save();
        }
        $api_response = professionalCurl('cases/add-assessment-case',$subdomain,$apiData);
       

        if($api_response['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "Assessment assigned to professional";

            $mailData = array();
            $user = userDetail($object->user_id);
            $mail_message = "Hello Admin,<Br> ".\Auth::user()->first_name." ".\Auth::user()->last_name." has created the assessment. Please check the panel";
            
            $mailData['mail_message'] = $mail_message;
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = adminInfo('email');
            $parameter['to_name'] = adminInfo('name');
            $parameter['message'] = $message;
            
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);

        }else{
            $response['status'] = false;
            $response['message'] = "Assessment assigned failed, try again";
        }
        return response()->json($response);
    }   

    public function findProfessional(Request $request){

        $professionals = Professionals::get();
        $viewData['professionals'] = $professionals;
        $view = View::make(roleFolder().'.assessments.professionals',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

}
