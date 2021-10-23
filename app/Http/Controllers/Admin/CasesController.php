<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Cases;
use App\Models\ProfessionalServices;
use App\Models\ServiceDocuments;
use App\Models\Leads;
use App\Models\User;
use App\Models\CaseTeams;
use App\Models\CaseDocuments;
use App\Models\DocumentFolder;
use App\Models\CaseFolders;
use App\Models\Documents;
use App\Models\DocumentChats;
use App\Models\Chats;
use App\Models\ChatRead;
use App\Models\ProfessionalDetails;
use App\Models\CaseTasks;
use App\Models\CaseTaskComments;
use App\Models\CaseTaskFiles;
use App\Models\CaseActivityLogs;

use File;

class CasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function cases(Request $request){
        $viewData['pageTitle'] = "Cases";
        return view(roleFolder().'.cases.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = Cases::withCount(['Chats','Documents'])
                        ->orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("case_title","LIKE","%$search%");
                            }
                        })
                        ->paginate(5);

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function createClient(Request $request){
       
        $viewData['pageTitle'] = "Create Client";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $view = View::make(roleFolder().'.cases.modal.new-client',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function createNewClient(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country_code' => 'required',
            'phone_no' => 'required',
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
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['email'] = $request->input('email');
        $data['country_code'] = $request->input('country_code');
        $data['phone_no'] = $request->input('phone_no');
        $postData['professional'] = ProfessionalDetails::first();
        $postData['data'] = $data;
        $result = curlRequest("create-client",$postData);
        if($result['status'] == 'error'){
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = $result['message'];
        }else if($result['status'] == 'success'){
            $clients = User::ProfessionalClients(\Session::get('subdomain'));
            $options = '<option value="">Select Client</option>';
            foreach($clients as $client){
                $selected = ($client->email == $request->input("email"))?'selcted':'';
                $options .='<option '.$selected.' value="'.$client->unique_id.'">'.$client->first_name.' '.$client->last_name.'</option>';
            }
            $response['status'] = true;
            $response['options'] = $options;
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Issue while creating client";
        }
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Create Case";
        $viewData['staffs'] = User::where("role","!=","admin")->get();

        $viewData['clients'] = User::ProfessionalClients(\Session::get('subdomain'));

        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        return view(roleFolder().'.cases.add',$viewData);
    } 
    
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'case_title' => 'required',
            'start_date' => 'required',
            'visa_service_id'=>'required',
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
        
        $case_unique_id = randomNumber();
        $object = new Cases();
        $object->client_id = $request->input("client_id");
        $object->case_title = $request->input("case_title");
        $object->start_date = $request->input("start_date");
        $object->unique_id = $case_unique_id;
        if($request->input("end_date")){
            $object->end_date = $request->input("end_date");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->created_by = \Auth::user()->unique_id;
        $object->save();

        $case_id = $case_unique_id;
        $assign_teams = $request->input("assign_teams");
        if(!empty($assign_teams)){
            for($i=0;$i < count($assign_teams);$i++){
                $object2 = new CaseTeams();
                $object2->unique_id = randomNumber();
                $object2->user_id = $assign_teams[$i];
                $object2->case_id = $case_id;
                $object2->save();
            }
        }

        //Email NOTIFICATION FOR CASE
        $mailData = array();
        $uuid = $request->input("client_id");
        $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$uuid)->first();
        $professional = ProfessionalDetails::first();
        $mail_message = "Hello ".$user->first_name." ".$user->last_name.",<br>".$professional->company_name." has created the case. You can approve the case by login to website.";
        $parameter['subject'] = "New case added to your profile. ";
        $mailData['mail_message'] = $mail_message;
        $view = View::make('emails.notification',$mailData);
        $message = $view->render();
        $parameter['to'] = $user->email;
        $parameter['to_name'] = $user->first_name." ".$user->last_name;
        $parameter['message'] = $message;
        $parameter['view'] = "emails.notification";
        $parameter['data'] = $mailData;
        $mailRes = sendMail($parameter);
        //End Email NOTIFICATION FOR CASE

        $response['status'] = true;
        $response['message'] = "Case created successfully";
        $response['redirect_back'] = baseUrl('cases');
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Cases::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Cases::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function edit($id){
        $id = base64_decode($id);
        $record = Cases::with('AssingedMember')->find($id);
        $assignedMember = $record->AssingedMember;
        $viewData['record'] = $record;
        $viewData['assignedMember'] = $assignedMember;
        $viewData['staffs'] = User::where("role","!=","admin")->get();
        $viewData['clients'] = User::ProfessionalClients(\Session::get('subdomain'));
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        $viewData['pageTitle'] = "Edit Case";
        return view(roleFolder().'.cases.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'case_title' => 'required',
            'start_date' => 'required',
            'visa_service_id'=>'required',
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

        $object = Cases::find($id);
        $object->client_id = $request->input("client_id");
        $object->case_title = $request->input("case_title");
        $object->start_date = $request->input("start_date");
        if($request->input("end_date")){
            $object->end_date = $request->input("end_date");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->created_by = \Auth::user()->id;
        $object->save();

        $case_id = $object->unique_id;
        $assign_teams = $request->input("assign_teams");
        if(!empty($assign_teams)){
            $checkRemoved = CaseTeams::whereNotIn("user_id",$assign_teams)->where("case_id",$case_id)->get();
            if(!empty($checkRemoved)){
                foreach($checkRemoved as $rec){
                    CaseTeams::deleteRecord($rec->id);
                }
            }
            for($i=0;$i < count($assign_teams);$i++){
                $checkExists = CaseTeams::where("user_id",$assign_teams[$i])->where("case_id",$case_id)->count();
                if($checkExists == 0){
                    $object2 = new CaseTeams();
                    $object2->unique_id = randomNumber();
                    $object2->user_id = $assign_teams[$i];
                    $object2->case_id = $case_id;
                    $object2->save();
                }
            }
        }
        $response['status'] = true;
        $response['message'] = "Case edited successfully";
        $response['redirect_back'] = baseUrl('cases');
        return response()->json($response);
    }

    public function pinnedFolder(Request $request){
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required',
            'case_id' => 'required',
            'doc_type' => 'required',
        ]);
        $case_id = $request->input("case_id");
        $folder_id = $request->input("folder_id");
        $doc_type =  $request->input("doc_type");
        $case = Cases::find($case_id);
        $pinned_folders = $case->pinned_folders;
        if($pinned_folders != ''){
            $pinned_folders = json_decode($pinned_folders,true);
        }
        if(isset($pinned_folders[$doc_type])){
            $folders = $pinned_folders[$doc_type];
            if(!in_array($folder_id,$folders)){
                $folders[] = $folder_id;    
            }
        }else{
            $folders[] = $folder_id;
        }
        $pinned_folders[$doc_type] = $folders;
        
        $case->pinned_folders = json_encode($pinned_folders);
        $case->save();
        $response['status'] = true;
        $response['message'] = "Folder pinned!";
        \Session::flash('success', 'Folder pinned!');
        return response()->json($response);
    }

    public function unpinnedFolder(Request $request){
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required',
            'case_id' => 'required',
            'doc_type' => 'required',
        ]);
        $case_id = $request->input("case_id");
        $folder_id = $request->input("folder_id");
        $doc_type =  $request->input("doc_type");
        $case = Cases::find($case_id);
        $pinned_folders = $case->pinned_folders;
        if($pinned_folders != ''){
            $pinned_folders = json_decode($pinned_folders,true);
        }
        if(isset($pinned_folders[$doc_type])){
            $folders = $pinned_folders[$doc_type];
            $key = array_search($folder_id, $folders);
            if (false !== $key) {
                unset($folders[$key]);
            }
            $pinned_folders[$doc_type] = $folders;
        }
        $case->pinned_folders = json_encode($pinned_folders);
        $case->save();
        $response['status'] = true;
        $response['message'] = "Folder unpinned!";
        \Session::flash('success', 'Folder unpinned!');
        return response()->json($response);
    }
    public function caseDocuments_new($id){
        $id = base64_decode($id);
        $record = Cases::where("id",$id)->first();
        $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
        $case_folders = CaseFolders::where("case_id",$record->unique_id)->get();
        $service->MainService = $service->Service($service->service_id);
        
        // $visa_service = $service->MainService;
        $subdomain = \Session::get("subdomain");
        $default_documents = $service->DefaultDocuments($service->service_id);
        foreach($default_documents as $document){
            $document->files_count = $record->caseDocuments($record->unique_id,$document->unique_id,'count');
        }
        foreach($documents as $document){
            $document->files_count = $record->caseDocuments($record->unique_id,$document->unique_id,'count');
        }
        foreach($case_folders as $document){
            $document->files_count = $record->caseDocuments($record->unique_id,$document->unique_id,'count');
        }
        $service->Documents = $default_documents;
        $viewData['pageTitle'] = "Documents for ".$service->Service($service->service_id)->name;
        $user_file_url = userDirUrl($record->client_id)."/documents";
        $user_file_dir = userDir($record->client_id)."/documents";
        $pinned_folders = $record->pinned_folders;
        if($pinned_folders != ''){
            $pin_folders = json_decode($pinned_folders,true);
            $is_pinned = true;
        }else{
            $pin_folders = array('default'=>array(),"other"=>array(),"extra"=>array());
            $is_pinned = false;
        }
        $pin_folders = array();
        $viewData['is_pinned'] = $is_pinned;
        $viewData['pin_folders'] = $pin_folders;

        $viewData['user_file_url'] = $user_file_url;
        $viewData['user_file_dir'] = $user_file_dir;
        $viewData['case_id'] = $record->unique_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['active_nav'] = "files";

        // if(!empty($visa_service)){
        //     $viewData['pageTitle'] = "Documents for ".$service->Service($service->service_id)->name;
        // }else{
        //     return redirect()->back()->with("error","No visa service found");
        // }

        return view(roleFolder().'.cases.document-folders',$viewData);

    }
    public function caseDocuments($id){
        $id = base64_decode($id);
        $record = Cases::find($id);
        $subdomain = \Session::get("subdomain");
        $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$service->unique_id)->get();
        $case_folders = CaseFolders::where("case_id",$record->unique_id)->get();
        $pinned_folders = $record->pinned_folders;
        if($pinned_folders != ''){
            $pinned_folders = json_decode($pinned_folders,true);
            
            $is_pinned = true;
        }else{
            $pinned_folders = array('default'=>array(),"other"=>array(),"extra"=>array());
            $is_pinned = false;
        }
        $viewData['subdomain'] = $subdomain;
        $viewData['is_pinned'] = $is_pinned;
        $viewData['pinned_folders'] = $pinned_folders;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        // $viewData['case_id'] = $record->id;
        $viewData['case_id'] = $record->unique_id;
        $visa_service = $service->Service($service->service_id);
        if(!empty($visa_service)){
            $viewData['pageTitle'] = "Documents for ".$service->Service($service->service_id)->name;
        }else{
            return redirect()->back()->with("error","No visa service found");
        }

        return view(roleFolder().'.cases.document-folders',$viewData);
    }

    public function defaultDocuments($case_id,$doc_id){
        // $case_id = base64_decode($case_id);
        // $doc_id = base64_decode($doc_id);
        $record = Cases::where("unique_id",$case_id)->first();
        $document = DB::table(MAIN_DATABASE.".documents_folder")->where("unique_id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
        $case_documents = CaseDocuments::with(['FileDetail','Chats'])
                                        ->where("case_id",$record->unique_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['record'] = $record;
        $viewData['doc_type'] = "default";
        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] = \Session::get("subdomain");
        
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function otherDocuments($case_id,$doc_id){
        
        // $doc_id = base64_decode($doc_id);
        $record = Cases::where("unique_id",$case_id)->first();
        $document = ServiceDocuments::where("unique_id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $case_documents = CaseDocuments::with(['FileDetail','Chats'])
                                        ->where("case_id",$record->unique_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['doc_type'] = "other";
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function extraDocuments($case_id,$doc_id){
        
        // $doc_id = base64_decode($doc_id);
        $record = Cases::where("unique_id",$case_id)->first();
        $document = CaseFolders::where("unique_id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
        $case_documents = CaseDocuments::with(['FileDetail','Chats'])
                                        ->where("case_id",$record->unique_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['doc_type'] = "extra";
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] =\Session::get("subdomain");
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    
    public function uploadDocuments($id,Request $request){
        $id = base64_decode($id);
        $folder_id = $request->input("folder_id");
        $record = Cases::find($id);
        $document_type = $request->input("doc_type");
        $failed_files = array();
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir()."/documents";
                if($file->move($destinationPath, $newName)){
                    $unique_id = randomNumber();
                    $object = new Documents();
                    $object->file_name = $newName;
                    $object->original_name = $fileName;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->id;
                    $object->save();

                    $object2 = new CaseDocuments();
                    $object2->case_id = $record->unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->added_by = \Auth::user()->role;
                    $object2->created_by = \Auth::user()->id;
                    $object2->document_type = $document_type;
                    $object2->save();
                    $response['status'] = true;
                    $response['message'] = 'File uploaded!';
                    $case_id = $record->unique_id;
                    $user_id = \Auth::user()->unique_id;
                    if($document_type == 'default'){
                        $document = DB::table(MAIN_DATABASE.".documents_folder")
                                    ->where("unique_id",$folder_id)
                                    ->first();
                        $comment = "File addded to folder ".$document->name; 
        
                    }
                    
                    if($document_type == 'other'){
                        $document = ServiceDocuments::where("unique_id",$folder_id)->first();
                        $comment = "File addded to folder ".$document->name;         
                    }
                    if($document_type == 'extra'){
                        $document = CaseFolders::where("unique_id",$folder_id)->first();
                        $comment = "File addded to folder ".$document->name;         
                    }
                    caseActivityLog(\Session::get('subdomain'),$case_id,$user_id,$comment,\Auth::user()->role);
                }else{
                    $response['status'] = false;
                    $response['message'] = 'File not uploaded!';
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
            }
            return response()->json($response);
        }
    }

    public function removeDocuments(Request $request){
        $files = $request->input("files");
        pre($files);
        exit;
    }

    public function addFolder($id,Request $request){
        // $id = base64_decode($id);
        $viewData['case_id'] = $id;
        $viewData['pageTitle'] = "Add Folder";
        $view = View::make(roleFolder().'.cases.modal.add-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function createFolder($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
        $object = new CaseFolders();
        $object->case_id = $id;
        $object->name = $request->input("name");
        $object->unique_id = randomNumber();
        $object->created_by = \Auth::user()->id;
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder added successfully";
        
        return response()->json($response);
    }

    public function editFolder($id,Request $request){
        $id = base64_decode($id);
        $record = CaseFolders::find($id);
        $viewData['case_id'] = $id;
        $viewData['pageTitle'] = "Edit Folder";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.cases.modal.edit-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function updateFolder($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $id = base64_decode($id);
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
        $object = CaseFolders::find($id);
        $object->name = $request->input("name");
        $object->created_by = \Auth::user()->id;
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder edited successfully";
        
        return response()->json($response);
    }

    public function deleteFolder($id){
        $id = base64_decode($id);
        CaseFolders::deleteRecord($id);
        return redirect()->back()->with("success","Folder has been deleted!");
    }

    public function deleteDocument($id){
        $id = base64_decode($id);
        CaseDocuments::deleteRecord($id);
        return redirect()->back()->with("success","Document has been deleted!");
    }
    public function deleteMultipleDocuments(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            CaseDocuments::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Documents deleted successfully'); 
        return response()->json($response);
    }

    public function fileMoveTo($id,$case_id,$doc_id){
        $id = base64_decode($id);
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $case = Cases::find($case_id);
        echo $doc_id;
        $documents = ServiceDocuments::where("service_id",$case->visa_service_id)->get();
        $document = ServiceDocuments::where("id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("unique_id",$case->visa_service_id)->first();
        
        $case_folders = CaseFolders::where("case_id",$case->id)->get();
        $viewData['service'] = $service;
        $viewData['case'] = $case;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['document'] = $document;
        $record = CaseDocuments::find($id);
        $viewData['id'] = $id;
        $viewData['pageTitle'] = "Move File";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.cases.modal.move-to',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function moveFileToFolder(Request $request){
        $id = base64_decode($request->input("id"));
        $folder_id = $request->input("folder_id");
        $doc_type = $request->input("doc_type");

        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        CaseDocuments::where("id",$id)->update($data);

        $response['status'] = true;
        $response['message'] = "File moved to folder successfully";
        \Session::flash('success', 'File moved to folder successfully'); 
        return response()->json($response);       
    }

    public function documentsExchanger($case_id){
        $id = base64_decode($case_id);
        $record = Cases::find($id);
        
        $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
        $case_folders = CaseFolders::where("case_id",$record->id)->get();
        
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record->id;
        $viewData['pageTitle'] = "Documents Exchanger";

        return view(roleFolder().'.cases.documents-exchanger',$viewData);
    }

    public function saveExchangeDocuments(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $files = $request->input("files");
        $existing_files = CaseDocuments::where("case_id",$case_id)
                        ->where("document_type",$doc_type)
                        ->where("folder_id",$folder_id)
                        ->pluck("file_id");
        if(!empty($existing_files)){
            $existing_files = $existing_files->toArray();
            $new_files = array_diff($files,$existing_files);
            $new_files = array_values($new_files);
        }else{
            $new_files = $files;
        }
        for($i=0;$i < count($new_files);$i++){
            $data = array();
            $data['folder_id'] = $folder_id;
            $data['document_type'] = $doc_type;
            CaseDocuments::where("file_id",$new_files[$i])->update($data);
        }

        $response['status'] = true;
        $response['message'] = "File transfered successfully";
        return response()->json($response); 
    }

    public function fetchDocumentChats(Request $request){
        $case_id = $request->input("case_id");
        $document_id = $request->input("document_id");
        $subdomain = $request->input("subdomain");
        $viewData['case_id'] = $case_id;
        $viewData['document_id'] = $document_id;
        $viewData['subdomain'] = \Session::get("subdomain");
        $data = array();
        $data['case_id'] = $case_id;
        $data['document_id'] = $document_id;
        $subdomain = $request->input("subdomain");
        $data['type'] = $request->input("type");

        $unread_chat = DocumentChats::where("case_id",$case_id)
                ->where('document_id',$document_id)
                ->where("send_by","!=","admin")
                ->where('admin_read',0)
                ->count();

        DocumentChats::where("case_id",$case_id)
                ->where('document_id',$document_id)
                ->update(['admin_read'=>1]);
        $chats = DocumentChats::with('FileDetail')->where("case_id",$case_id)->where('document_id',$document_id)->get();
        $viewData['chats'] = $chats;
        $view = View::make(roleFolder().'.cases.document-chats',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        $response['unread_chat'] = $unread_chat;
        return response()->json($response);
    }

    public function saveDocumentChat(Request $request){
        // $data['case_id'] = $request->input("case_id");
        // $data['document_id'] = $request->input("document_id");
        // $data['message'] = $request->input("message");
        
        // $data['created_by'] = \Auth::user()->unique_id;
        $case_id = $request->input("case_id");
        $case = Cases::where("unique_id",$case_id)->first();
        $document_id = $request->input("document_id");
        $case_document = CaseDocuments::where("unique_id",$document_id)
                                        ->where("case_id",$case_id)
                                        ->first();
        $folder_id = $case_document->folder_id;
        $object = new DocumentChats();
        $object->case_id = $request->input("case_id");
        $object->document_id = $request->input("document_id");
        $object->message = $request->input("message");
        $object->type = $request->input("type");
        $object->send_by = \Auth::user()->role;
        $object->created_by = \Auth::user()->unique_id;
        $object->save();
    
        $response['status'] = true;
        $response['message'] = "Message send successfully";
        
        $not_data['send_by'] = \Auth::user()->role;
        $not_data['added_by'] = \Auth::user()->unique_id;
        // $not_data['user_id'] = $case->client_id;
        $not_data['type'] = "chat";
        $not_data['notification_type'] = "document_chat";
        $not_data['title'] = "Message on document by ".\Auth::user()->first_name." ".\Auth::user()->last_name;
        $not_data['comment'] = $request->input("message");
        $subdomain = \Session::get("subdomain");
        // if($case_document->document_type == 'extra'){
        //     $not_data['url'] = "cases/documents/".$subdomain."/extra/".$case_id."/".$folder_id;
        // }
        // if($case_document->document_type == 'other'){
        //     $not_data['url'] = "cases/documents/other/".$subdomain."/".$case_id."/".$folder_id;
        // }
        // if($case_document->document_type == 'default'){
        //     $not_data['url'] = "cases/documents/default/".$subdomain."/".$case_id."/".$folder_id;
        // }
        
        $other_data[] = array("key"=>"case_id","value"=>$case_id);
        $other_data[] = array("key"=>"document_id","value"=>$document_id);
        
        $not_data['other_data'] = $other_data;
        
        // to professional
        if($case_document->document_type == 'extra'){
            $not_data['url'] = "cases/case-documents/extra/".$case_id."/".$folder_id;
        }
        if($case_document->document_type == 'other'){
            $not_data['url'] = "cases/case-documents/other/".$case_id."/".$folder_id;
        }
        if($case_document->document_type == 'default'){
            $not_data['url'] = "cases/case-documents/default/".$case_id."/".$folder_id;
        }
        sendNotification($not_data,"professional",\Session::get('subdomain'));

        // to user
        $not_data['user_id'] = $case->client_id;
        if($case_document->document_type == 'extra'){
            $not_data['url'] = "cases/documents/extra/".$subdomain."/".$case_id."/".$folder_id;
        }
        if($case_document->document_type == 'other'){
            $not_data['url'] = "cases/documents/other/".$subdomain."/".$case_id."/".$folder_id;
        }
        if($case_document->document_type == 'default'){
            $not_data['url'] = "cases/documents/default/".$subdomain."/".$case_id."/".$folder_id;
        }
        sendNotification($not_data,"user");
        // sendNotification($not_data,"user");
        
        $user_id = \Auth::user()->unique_id;
        $comment = "Message sent on document (".$request->input("message").")";
        caseActivityLog($subdomain,$case_id,$user_id,$comment,'user');

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
            $destinationPath = professionalDir()."/documents";
            
            
            if($file->move($destinationPath, $newName)){
               
                $file_id = randomNumber();
                $object2 = new Documents();
                $object2->file_name = $newName;
                $object2->original_name = $fileName;
                $object2->unique_id = $file_id;
                $object2->created_by = 0;
                $object2->save();

                $object = new DocumentChats();
                $object->case_id = $request->input("case_id");
                $object->document_id = $request->input("document_id");
                $object->message = $fileName;
                $object->type = 'file';
                if($request->input("message")){
                    $object->file_message = $request->input("message");
                }
                $object->file_id = $file_id;
                $object->send_by = \Auth::user()->role;
                $object->created_by = \Auth::user()->unique_id;
                $object->save();
            
                $response['status'] = true;
                $response['message'] = "File send successfully";
                
                $not_data['send_by'] = \Auth::user()->role;
                $not_data['added_by'] = \Auth::user()->unique_id;
                // $not_data['user_id'] = $case->client_id;
                $not_data['type'] = "chat";
                $not_data['notification_type'] = "document_chat";
                $not_data['title'] = "Message on document by ".\Auth::user()->first_name." ".\Auth::user()->last_name;
                $not_data['comment'] = "Document send in chat";
                $subdomain = \Session::get("subdomain");
                // if($case_document->document_type == 'extra'){
                //     $not_data['url'] = "cases/documents/extra/".$subdomain."/".$case_id."/".$folder_id;
                // }
                // if($case_document->document_type == 'other'){
                //     $not_data['url'] = "cases/documents/other/".$subdomain."/".$case_id."/".$folder_id;
                // }
                // if($case_document->document_type == 'default'){
                //     $not_data['url'] = "cases/documents/default/".$subdomain."/".$case_id."/".$folder_id;
                // }
                $case_id = $request->input("case_id");
                $document_id = $request->input("document_id");
                $case = Cases::where("unique_id",$case_id)->first();
                $case_document = CaseDocuments::where("unique_id",$document_id)
                                        ->where("case_id",$case_id)
                                        ->first();
                $folder_id = $case_document->folder_id;
                $other_data[] = array("key"=>"case_id","value"=>$case_id);
                $other_data[] = array("key"=>"document_id","value"=>$document_id);
                
                $not_data['other_data'] = $other_data;
                
                // sendNotification($not_data,"user");         

                // to professional
                if($case_document->document_type == 'extra'){
                    $not_data['url'] = "cases/case-documents/extra/".$case_id."/".$folder_id;
                }
                if($case_document->document_type == 'other'){
                    $not_data['url'] = "cases/case-documents/other/".$case_id."/".$folder_id;
                }
                if($case_document->document_type == 'default'){
                    $not_data['url'] = "cases/case-documents/default/".$case_id."/".$folder_id;
                }
                sendNotification($not_data,"professional",\Session::get('subdomain'));

                // to user
                $not_data['user_id'] = $case->client_id;
                if($case_document->document_type == 'extra'){
                    $not_data['url'] = "cases/documents/extra/".$subdomain."/".$case_id."/".$folder_id;
                }
                if($case_document->document_type == 'other'){
                    $not_data['url'] = "cases/documents/other/".$subdomain."/".$case_id."/".$folder_id;
                }
                if($case_document->document_type == 'default'){
                    $not_data['url'] = "cases/documents/default/".$subdomain."/".$case_id."/".$folder_id;
                }
                sendNotification($not_data,"user");
                
                $user_id = \Auth::user()->unique_id;
                $comment = "File sent on document (".$request->input("message").")";
                caseActivityLog($subdomain,$case_id,$user_id,$comment,'user');

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

    public function chats($case_id,Request $request){
        $case = Cases::where("unique_id",$case_id)->first();
        
        $viewData['client_id'] = $case->client_id;
        if($request->get("type")){
            $chat_type = $request->get("type");
            $sub_title = $case->case_title;
            if($chat_type == 'case_chat'){
                $unread_case_chat = Chats::where("case_id",$case_id)
                                    ->doesntHave("AdminChatRead")
                                    ->where("created_by","!=",\Auth::user()->unique_id)
                                    ->get();
                foreach($unread_case_chat as $chat){
                    $object = new ChatRead();
                    $object->chat_id = $chat->id;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->user_type = \Auth::user()->role;
                    $object->chat_type = 'case_chat';
                    $object->save();
                }
            }
        }else{
            $chat_type = 'general';
            $sub_title = "General Chats";
            // $unread_general_chat = Chats::where("case_id",0)->doesntHave("AdminChatRead")->get();
            // foreach($unread_general_chat as $chat){
            //     $object = new ChatRead();
            //     $object->chat_id = $chat->id;
            //     $object->user_type = \Auth::user()->role;
            //     $object->user_id = \Auth::user()->unique_id;
            //     $object->chat_type = 'general';
            //     $object->save();
            // }
        }
       
        // $unread_case_chat = Chats::where("case_id",$case_id)->doesntHave("AdminChatRead")->count();
        $unread_case_chat = $case->UnreadChat($case->unique_id,\Auth::user()->role,\Auth::user()->unique_id,'count');
        $user_id = \Auth::user()->unique_id;
        $total_general_chat = Chats::where("case_id",0)
                                ->whereDoesntHave("AdminChatGenRead",function($query) use($user_id){
                                    $query->where("user_id",$user_id);
                                })
                                ->where('chat_client_id',$case->client_id)
                                ->where("created_by","!=",\Auth::user()->unique_id)
                                ->count();
        $user_id = \Auth::user()->unique_id;                         
        $unread_general_chat = Chats::where("case_id",0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->where('chat_client_id',$case->client_id)
                                    ->count();

        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_general_chat'] = array("total_chat"=>$total_general_chat,"unread_chat"=>$unread_general_chat);
        $viewData['chat_type'] = $chat_type;
        $viewData['sub_title'] = $sub_title;
       
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Chats";
        $viewData['case_id'] = $case_id;
        return view(roleFolder().'.cases.chats',$viewData);
    }

    public function fetchChats(Request $request){
        $case_id = $request->input("case_id");
        $chat_type = $request->input("chat_type");
        $client_id = $request->input("client_id");
        $viewData['case_id'] = $case_id;
        $viewData['chat_type'] = $chat_type;
        $viewData['subdomain'] = \Session::get("subdomain");
        $data = array();
        if($request->input("chat_type") == 'case_chat'){
            $data['case_id'] = $case_id;
        }
        $data['client_id'] = $client_id;
        $data['chat_type'] = $chat_type;
        $chats = Chats::with('FileDetail')
            ->where("chat_type",$chat_type)
            ->where(function($query) use($chat_type,$case_id){
                if($chat_type == 'case_chat'){
                    $query->where("case_id",$case_id);
                }
            })
            ->where("chat_client_id",$client_id)
            ->get();
            if($chat_type == 'case_chat'){
                $case = Cases::with(['AssingedMember','VisaService'])->where("unique_id",$case_id)->first();
                $unread_case_chat = $case->UnreadChat($case_id,'user',$request->input("client_id"),'data');
                if(count($unread_case_chat['unread_chat']) > 0){
                    foreach($unread_case_chat['unread_chat'] as $chat){
                        $object = new ChatRead();
                        $object->chat_id = $chat->id;
                        $object->user_type = 'user';
                        $object->user_id = $request->input("client_id");
                        $object->chat_type = 'case_chat';
                        $object->save();
                    }
                }
            }else{
                $user_id = $request->input("client_id");
                $unread_general_chat = Chats::where("case_id",0)
                                        ->whereDoesntHave("AdminChatGenRead",function($query) use($user_id){
                                            $query->where("user_id",$user_id);
                                        })
                                        ->where('chat_client_id',$user_id)
                                        ->get();
                foreach($unread_general_chat as $chat){
                    $object = new ChatRead();
                    $object->chat_id = $chat->id;
                    $object->user_type = 'admin';
                    $object->user_id = $request->input("client_id");
                    $object->chat_type = 'general';
                    $object->save();
                }
            }
        $viewData['chats'] = $chats;
        $view = View::make(roleFolder().'.cases.chat-list',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function saveChat(Request $request){
        $data['case_id'] = $request->input("case_id");
        $data['document_id'] = $request->input("document_id");
        $data['message'] = $request->input("message");
        
        $data['created_by'] = \Auth::user()->unique_id;
        $subdomain = $request->input("subdomain");
        
        $object = new Chats();
        if($request->input("chat_type") == 'case_chat'){
            $object->case_id = $request->input("case_id");
        }
        $object->chat_type = $request->input("chat_type");
        $object->message = $request->input("message");
        $object->type = 'text';
        $object->send_by = \Auth::user()->role;
        $object->created_by = \Auth::user()->unique_id;
        $object->chat_client_id = $request->input("client_id");
        $object->save();
        
        $subdomain = \Session::get("subdomain");
        $not_data['send_by'] = \Auth::user()->role;
        $not_data['added_by'] = \Auth::user()->unique_id;
        // $not_data['user_id'] = $request->input("client_id");
        $not_data['type'] = "chat";
        $not_data['notification_type'] = "case_chat";
        $professional = ProfessionalDetails::first();
        $not_data['title'] = $professional->company_name." send message on document";
        $not_data['comment'] = $request->input("message");
        // if($request->input("chat_type") == 'general'){
        //     $not_data['notification_type'] = "general";
        //     $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id");
        // }else{
        //     $not_data['notification_type'] = "case_chat";
        //     $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id")."?chat_type=case_chat";
        // }
        
        $other_data[] = array("key"=>"chat_type","value"=>$request->input("chat_type"));
        if($request->input("chat_type") == 'case_chat'){
            $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
        }
        $not_data['other_data'] = $other_data;
        
        // to professional
        if($request->input("chat_type") == 'general'){
            $not_data['notification_type'] = "general";
            $not_data['url'] = "cases/chats/".$request->input("case_id");
        }else{
            $not_data['notification_type'] = "case_chat";
            $not_data['url'] = "cases/chats/".$request->input("case_id")."?chat_type=case_chat";
        }
        sendNotification($not_data,"professional",\Session::get('subdomain'));

        // to user
        if($request->input("chat_type") == 'general'){
            $not_data['notification_type'] = "general";
            $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id");
        }else{
            $not_data['notification_type'] = "case_chat";
            $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id")."?chat_type=case_chat";
        }
        $not_data['user_id'] = $request->input("client_id");
        sendNotification($not_data,"user");
        
        

        $response['status'] = true;
        $response['message'] = "Message send successfully";
        
        return response()->json($response);
    }

    public function saveChatFile(Request $request){

        if ($file = $request->file('attachment')){
           

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = professionalDir()."/documents";
            
            
            if($file->move($destinationPath, $newName)){
               
                $file_id = randomNumber();
                $object2 = new Documents();
                $object2->file_name = $newName;
                $object2->original_name = $fileName;
                $object2->unique_id = $file_id;
                $object2->created_by = 0;
                $object2->save();

                $object = new Chats();
                $object->case_id = $request->input("case_id");
                $object->chat_type = $request->input("chat_type");
                $object->message = $fileName;
                $object->type = 'file';
                $object->file_id = $file_id;
                $object->send_by = \Auth::user()->role;
                $object->created_by = \Auth::user()->unique_id;
                $object->chat_client_id = $request->input("client_id");
                $object->save();
            
                $response['status'] = true;
                $response['message'] = "File send successfully";
                
                $subdomain = \Session::get("subdomain");
                $not_data['send_by'] = \Auth::user()->role;
                $not_data['added_by'] = \Auth::user()->unique_id;
                // $not_data['user_id'] = $request->input("client_id");
                $not_data['type'] = "chat";
                $not_data['notification_type'] = "case_chat";
                $professional = ProfessionalDetails::first();
                $not_data['title'] = $professional->company_name." send message on document";
                $not_data['comment'] = "Document send in chat";
                // if($request->input("chat_type") == 'general'){
                //     $not_data['notification_type'] = "general";
                //     $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id");
                // }else{
                //     $not_data['notification_type'] = "case_chat";
                //     $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id")."?chat_type=case_chat";
                // }
                
                $other_data[] = array("key"=>"chat_type","value"=>$request->input("chat_type"));
                if($request->input("chat_type") == 'case_chat'){
                    $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
                }
                $not_data['other_data'] = $other_data;
                
                // to professional
                if($request->input("chat_type") == 'general'){
                    $not_data['notification_type'] = "general";
                    $not_data['url'] = "cases/chats/".$request->input("case_id");
                }else{
                    $not_data['notification_type'] = "case_chat";
                    $not_data['url'] = "cases/chats/".$request->input("case_id")."?chat_type=case_chat";
                }
                sendNotification($not_data,"professional",\Session::get('subdomain'));

                // to user
                $not_data['user_id'] = $request->input("client_id");
                if($request->input("chat_type") == 'general'){
                    $not_data['notification_type'] = "general";
                    $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id");
                }else{
                    $not_data['notification_type'] = "case_chat";
                    $not_data['url'] = "cases/chats/".$subdomain."/".$request->input("case_id")."?chat_type=case_chat";
                }
                sendNotification($not_data,"user");
                $response['status'] = true;
                $response['message'] = "File send successfully";
                                
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

    public function viewDocument($case_id,$doc_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $ext = fileExtension($filename);
        $subdomain = $request->get("p");

        $viewData['url'] = $url;
        $viewData['extension'] = $ext;
        $viewData['subdomain'] = $subdomain;
        $viewData['case_id'] = $case_id;
        $viewData['document_id'] = $doc_id;
        $viewData['pageTitle'] = "View Documents";
        return view(roleFolder().'.cases.view-documents',$viewData);
    }

    public function addNewTask($case_id,Request $request){
       
        $viewData['pageTitle'] = "Add case task";
        $case_id = base64_decode($case_id);
        $case = Cases::where("id",$case_id)->first();
        $viewData['case'] = $case;
        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;
        $viewData['timestamp'] = time();
        return view(roleFolder().'.cases.add-task',$viewData);
        // $view = View::make(roleFolder().'.cases.modal.add-task',$viewData);
        // $contents = $view->render();
        // $response['contents'] = $contents;
        // $response['status'] = true;
        // return response()->json($response);
    }
    public function saveTask($case_id,Request $request){

        $validator = Validator::make($request->all(), [
            'task_title' => 'required',
            'description' => 'required',
            'response_type' => 'required'
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
        $case = Cases::where("unique_id",$case_id)->first();
        $task_unique_id = randomNumber();
        $object = new CaseTasks();
        $object->case_id = $case_id;
        $object->client_id = $case->client_id;
        $object->task_title = $request->input("task_title");
        $object->description = $request->input("description");
        $object->added_by = \Auth::user()->unique_id;
        $object->unique_id = $task_unique_id;
        $object->status = 'pending';
        $object->response_type = $request->input("response_type");
        $filename = array();
        if($request->input("timestamp")){
            $timestamp = $request->input("timestamp");
            
            if(is_dir(public_path()."/uploads/temp/". $timestamp)){
                $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                
                
                for($f = 0; $f < count($files);$f++){
                    $file_arr = explode("/",$files[$f]);
                    $filename[] = end($file_arr);
                    $file_name =  end($file_arr);
                    $destinationPath = professionalDir()."/cases/tasks/";
                    if(!is_dir($destinationPath)){
                        // mkdir($path, "0777");
                        $result = \File::makeDirectory($destinationPath, 0777, true);
                    }
                    $destinationPath = professionalDir()."/cases/tasks/".$file_name;
                    // copy($files[$f], $destinationPath);
                    File::copy($files[$f], $destinationPath);
                    // unlink($files[$f]);
                }
                if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                    // rmdir(public_path()."/uploads/temp/". $timestamp);
                }
                // if(!empty($filename)){
                //     // $object->files = implode(",",$filename);
                // }
            }
        }
        $object->save();
        for($i=0;$i < count($filename);$i++){
            $obj_file = new CaseTaskFiles();
            $obj_file->task_id = $task_unique_id;
            $obj_file->file_name = $filename[$i];
            $obj_file->save();
        }
        $response['status'] = true;
        $response['message'] = "Task added successfully";
        $response['redirect'] = baseUrl('cases/tasks/list/'.base64_encode($case->id));
        return response()->json($response);
    }
    public function tasks($case_id,Request $request){
        $case_id = base64_decode($case_id);
        $case = Cases::where("id",$case_id)->first();
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Tasks List";
        
        return view(roleFolder().'.cases.tasks',$viewData);
    }

    public function getTasksList(Request $request)
    {
        $search = $request->input("search");
        $records = CaseTasks::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("task_title","LIKE","%$search%");
                            }
                        })
                        ->where("case_id",$request->input("case_id"))
                        ->paginate(5);
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.tasks-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function editTask($id,Request $request){
       
        $viewData['pageTitle'] = "Edit case task";
        $record = CaseTasks::where("unique_id",$id)->first();
        $case_id = $record->case_id;
        $case = Cases::where("unique_id",$case_id)->first();
        $viewData['case'] = $case;
        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;
        $viewData['timestamp'] = time();
        $viewData['record'] = $record;
        return view(roleFolder().'.cases.edit-task',$viewData);
        // $view = View::make(roleFolder().'.cases.modal.edit-task',$viewData);
        // $contents = $view->render();
        // $response['contents'] = $contents;
        // $response['status'] = true;
        // return response()->json($response);
    }
    public function updateTask($id,Request $request){
        $validator = Validator::make($request->all(), [
            'task_title' => 'required',
            'description' => 'required',
            'response_type' => 'required'
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
        
        $record = CaseTasks::where("unique_id",$id)->first();
        $case_id = $record->case_id;
        $case = Cases::where("unique_id",$case_id)->first();
        $object = CaseTasks::where("unique_id",$id)->first();
        $object->client_id = $case->client_id;
        $object->task_title = $request->input("task_title");
        $object->description = $request->input("description");
        $object->added_by = \Auth::user()->unique_id;
        $object->response_type = $request->input("response_type");
        $filename = array();
        if($request->input("timestamp")){
            $timestamp = $request->input("timestamp");
            if(is_dir(public_path()."/uploads/temp/". $timestamp)){
                $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
               
                for($f = 0; $f < count($files);$f++){
                    $file_arr = explode("/",$files[$f]);
                    $filename[] = end($file_arr);
                    $file_name =  end($file_arr);
                    // $destinationPath = professionalDir()."/tasks/".$file_name;
                    $destinationPath = professionalDir()."/cases/tasks/".$file_name;
                    File::copy($files[$f], $destinationPath);
                    unlink($files[$f]);
                }
                if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                    rmdir(public_path()."/uploads/temp/". $timestamp);
                }
                // if(!empty($filename)){
                //     $object->files = implode(",",$filename);
                // }
            }
        }
        $object->save();
        for($i=0;$i < count($filename);$i++){
            $obj_file = new CaseTaskFiles();
            $obj_file->task_id = $record->unique_id;
            $obj_file->file_name = $filename[$i];
            $obj_file->save();
        }
        $response['status'] = true;
        $response['message'] = "Task edited successfully";
        $response['redirect'] = baseUrl('cases/tasks/list/'.base64_encode($case->id));
        return response()->json($response);
    }

    public function removeTaskFile($id){
        $id = base64_decode($id);
        $file = CaseTaskFiles::where("id",$id)->first();
        if(file_exists(professionalDir()."/cases/tasks/".$file->file_name)){
            unlink(professionalDir()."/cases/tasks/".$file->file_name);
        }
        CaseTaskFiles::where("id",$id)->delete();

        return redirect()->back()->with("success","File has been deleted!");
    }
    public function deleteSingleTask($id){
        $id = base64_decode($id);
        CaseTasks::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultipleTasks(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            CaseTasks::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function viewTask($id){
        $record = CaseTasks::where("unique_id",$id)->first();
        $viewData['pageTitle'] = "View Task";
        $viewData['record'] = $record;
        $viewData['task_id'] = $id;
        return view(roleFolder().'.cases.view-task',$viewData);

    }
    public function sendTaskComment(Request $request){
        $subdomain = $request->input("subdomain");
        $task_id =  $request->input("task_id");
        $data['task_id'] = $task_id;
        $data['send_by'] = \Auth::user()->unique_id;
        $data['unique_id'] = randomNumber();
        $data['user_type'] = "professional";
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        if($request->input("message")){
            $data['message'] = $request->input("message");
        }
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir($subdomain)."/cases/tasks";
                if($file->move($destinationPath, $newName)){
                    $data['file_name'] = $newName;
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
                return response()->json($response);
            } 
        }

        CaseTaskComments::insert($data);

        $response['status'] = true;
        $response['message'] = "Task comment added successfully";
        return response()->json($response);
    }

    public function fetchTaskComments($task_id, Request $request){
 
        $comments = CaseTaskComments::where('task_id',$task_id)->get();
        $viewData['comments'] = $comments;
        $subdomain = \Session::get("subdomain");
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.task-comments',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function changeTaskComment(Request $request){
        $id = $request->input("id");
        $data['status'] = $request->input("status");
        CaseTasks::where("unique_id",$id)->update($data);

        $response['status'] = true;
        $response['message'] = "Task status changed";
        return response()->json($response);
    }

    public function view($case_id){
        $case_id = base64_decode($case_id);
        $subdomain = \Session::get("subdomain");
        $record = Cases::with(['AssingedMember','VisaService'])
                    ->where("id",$case_id)
                    ->first();
        $temp = $record;
        $temp->MainService = $record->Service($record->VisaService->service_id);
        $data = $temp;
            
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Case";
        $viewData['record'] = $data;
        $viewData['case_id'] = $record->unique_id;
        $viewData['active_nav'] = "overview";
        $viewData['visa_services'] = array();
        return view(roleFolder().'.cases.view',$viewData);
    } 

    public function previewDocument($case_id,$doc_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $extension = fileExtension($filename);
        $subdomain = $request->get("p");
        $folder_id = $request->get("folder_id");
        
        $doc_type = $request->get("doc_type");
        $document = '';
        if($extension == 'image'){
            $document = '<div class="text-center"><img src="'.$url.'" class="img-fluid" /></div>';
        }else{
            if(google_doc_viewer($extension)){
                $document = '<iframe src="http://docs.google.com/viewer?url='.$url.'&embedded=true" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>';
            }else{
                $document = '<iframe src="'.$url.'" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>';
            }
        }
        $response['status'] = true;
        $response['content'] = $document;
        return response()->json($response);
    }

    public function activityLog($case_id){
        $case_id = base64_decode($case_id);
        $record = Cases::with(['AssingedMember','VisaService'])
                    ->where("id",$case_id)
                    ->first();
        $temp = $record;
        $temp->MainService = $record->Service($record->VisaService->service_id);
        $data = $temp;
        $subdomain = \Session::get("subdomain");
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Case";
        $viewData['record'] = $data;
        $viewData['case_id'] = $record->unique_id;

        $activity_logs = CaseActivityLogs::where("case_id",$record->unique_id)
                        ->orderBy("id","desc")
                        ->get();
       
        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Case";
        $viewData['record'] = $record;
        $viewData['active_nav'] = "activity";
        $viewData['activity_logs'] = $activity_logs;
        return view(roleFolder().'.cases.activity-logs',$viewData);
    }
}
