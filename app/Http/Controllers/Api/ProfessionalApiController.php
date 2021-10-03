<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\User;
use App\Models\DomainDetails;
use App\Models\Cases;
use App\Models\ProfessionalServices;
use App\Models\ServiceDocuments;
use App\Models\CaseTeams;
use App\Models\CaseDocuments;
use App\Models\DocumentFolder;
use App\Models\CaseFolders;
use App\Models\Documents;
use App\Models\DocumentChats;
use App\Models\Chats;
use App\Models\Invoices;
use App\Models\CaseInvoices;
use App\Models\CaseInvoiceItems;
use App\Models\ProfessionalDetails;
use App\Models\AssessmentCase;
use App\Models\CaseTasks;
use App\Models\ChatRead;

class ProfessionalApiController extends Controller
{
    var $subdomain;
    public function __construct(Request $request)
    {
    	$headers = $request->header();
        $this->subdomain = $headers['subdomain'][0];
        $this->middleware('professional_curl');
        \Config::set('database.connections.mysql.database',PROFESSIONAL_DATABASE.$this->subdomain);
    }
    public function clientCases(Request $request)
    {
    	try{
    		$postData = $request->input();
            $request->request->add($postData);

	       	$cases = Cases::with(['AssingedMember','VisaService','Chats','Documents'])
                        ->where("client_id",$request->input("client_id"))
                        ->orderBy("id","desc")
                        ->get();
	       	$data = array();
	       	foreach($cases as $key => $record){
	       		$temp = $record;
	       		$temp->MainService = $record->Service($record->VisaService->service_id);
                $temp->unread_chat = $record->UnreadChat($record->unique_id,"user",$request->input("client_id"),'count');
	       		$data[] = $temp;
	       	}

	        $response['data'] = $data;
	        $response['status'] = 'success';
       	} catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function caseDetail(Request $request)
    {
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $client_id = $request->input("client_id");
            $record = Cases::with(['AssingedMember','VisaService'])
                            ->where("unique_id",$request->input("case_id"))
                            ->where("client_id",$client_id)
                            ->first();
            if(!empty($record)){
                $temp = $record;
                $temp->MainService = $record->Service($record->VisaService->service_id);
                $data = $temp;
                $response['data'] = $data;
                $response['status'] = 'success';
            }else{
                $response['status'] = "error";
                $response['message'] = "Case not found";
            }
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function chats(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $case_id = $request->input("case_id");
            $user_id = $request->input("user_id");
            $case = Cases::with(['AssingedMember','VisaService'])->where("unique_id",$request->input("case_id"))->first();
            $unread_case_chat = $case->UnreadChat($case_id,'user',$user_id,'count');
       
            $total_general_chat = Chats::where("case_id",0)
                                    ->where('chat_client_id',$user_id)
                                    ->where("created_by","!=",$user_id)
                                    ->count();
            $unread_general_chat = Chats::where("case_id",0)
                                        ->whereDoesntHave("UserChatGenRead",function($query) use($user_id){
                                            $query->where("user_id",$user_id);
                                        })
                                        ->where('chat_client_id',$user_id)
                                        ->count();
            $response['status'] = "success";
            $response['unread_case_chat'] = $unread_case_chat;
            $response['unread_general_chat'] = array("total_chat"=>$total_general_chat,"unread_chat"=>$unread_general_chat);
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function caseDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $id = $request->input("case_id");
            $record = Cases::where("unique_id",$id)->first();
            $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
            $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
            $case_folders = CaseFolders::where("case_id",$record->unique_id)->get();
            $service->MainService = $service->Service($service->service_id);
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
            $data['service'] = $service;
            $data['documents'] = $documents;
            $data['case_folders'] = $case_folders;
            $data['record'] = $record;

            $response['data'] = $data;
            $response['status'] = "success";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function defaultDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $doc_id = $request->input("doc_id");
            $record = Cases::where("unique_id",$case_id)->first();
            $document = DB::table(MAIN_DATABASE.".documents_folder")->where("unique_id",$doc_id)->first();
            $folder_id = $document->unique_id;
            $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
            $service->MainService = $service->Service($service->service_id);
            $case_documents = CaseDocuments::with(['FileDetail','Chats','ChatUsers'])->where("case_id",$case_id)
                                            ->where("folder_id",$folder_id)
                                            ->orderBy("id","desc")
                                            ->get();
            foreach($case_documents as $doc){
                foreach($doc->ChatUsers as $chat){
                    if($chat->send_by == 'client'){
                        $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$chat->created_by)->first();
                        $chat->user_name = $user->first_name." ".$user->last_name;
                    }else{
                        $user = User::where("unique_id",$chat->created_by)->first();
                        $chat->user_name = $user->first_name." ".$user->last_name;
                    }
                }
            }
            $data['service'] = $service;
            $data['case_documents'] = $case_documents;
            $data['document'] = $document;
            $data['record'] = $record;
            $data['doc_type'] = "default";
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;

            $response['status'] = "success";
            $response['data'] = $data;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function otherDocuments(Request $request){
        try{

            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $doc_id = $request->input("doc_id");
            $record = Cases::where("unique_id",$case_id)->first();

            $document = ServiceDocuments::where("unique_id",$doc_id)->first();
            $folder_id = $document->unique_id;
            $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
            $service->MainService = $service->Service($service->service_id);
            $case_documents = CaseDocuments::with(['FileDetail','Chats','ChatUsers'])->where("case_id",$case_id)
                                            ->where("folder_id",$folder_id)
                                            ->orderBy("id","desc")
                                            ->get();
            foreach($case_documents as $doc){
                foreach($doc->ChatUsers as $chat){
                    if($chat->send_by == 'client'){
                        $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$chat->created_by)->first();
                        $chat->user_name = $user->first_name." ".$user->last_name;
                    }else{
                        $user = User::where("unique_id",$chat->created_by)->first();
                        $chat->user_name = $user->first_name." ".$user->last_name;
                    }
                }
            }
            $data['service'] = $service;
            $data['case_documents'] = $case_documents;
            $data['document'] = $document;
            $data['record'] = $record;
            $data['doc_type'] = "other";
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;

            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function extraDocuments(Request $request){
        try{

            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $doc_id = $request->input("doc_id");

            $record = Cases::where("unique_id",$case_id)->first();
           
            $document = CaseFolders::where("unique_id",$doc_id)->first();
            $folder_id = $document->unique_id;
            $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
            $service->MainService = $service->Service($service->service_id);
            $case_documents = CaseDocuments::with(['FileDetail','Chats','ChatUsers'])->where("case_id",$case_id)
                                            ->where("folder_id",$folder_id)
                                            ->orderBy("id","desc")
                                            ->get();
            foreach($case_documents as $doc){
                foreach($doc->ChatUsers as $chat){
                    if($chat->send_by == 'client'){
                        $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$chat->created_by)->first();
                        $chat->user_name = $user->first_name." ".$user->last_name;
                    }else{
                        $user = User::where("unique_id",$chat->created_by)->first();
                        $chat->user_name = $user->first_name." ".$user->last_name;
                    }
                }
            }
            $data['service'] = $service;
            $data['case_documents'] = $case_documents;
            $data['document'] = $document;
            $data['record'] = $record;
            $data['pageTitle'] = "Files List for ".$document->name;
            $data['doc_type'] = "extra";
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;

            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function uploadDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $folder_id = $request->input("folder_id");
            $record = Cases::where("unique_id",$case_id)->first();
            $document_type = $request->input("document_type");
            $original_name  = $request->input("original_name");
            $newName = $request->input("newName");

            $unique_id = randomNumber();
            $object = new Documents();
            $object->file_name = $newName;
            $object->original_name = $original_name;
            $object->unique_id = $unique_id;
            $object->save();

            $object2 = new CaseDocuments();
            $object2->case_id = $record->unique_id;
            $object2->unique_id = randomNumber();
            $object2->folder_id = $folder_id;
            $object2->file_id = $unique_id;
            $object2->added_by = 'client';
            $object2->created_by = $request->input("created_by");
            $object2->document_type = $document_type;
            $object2->save();

            $response['status'] = "success";
            $response['message'] = "File uploaded!";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    
    public function documentsExchanger(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $client_id = $request->input("client_id");
            $record = Cases::where("unique_id",$case_id)->where('client_id',$client_id)->first();
            if(empty($record)){
                $response['status'] = "error";
                $response['message'] = "Case not found";
            }else{
                $service = ProfessionalServices::where("unique_id",$record->visa_service_id)->first();
                $default_documents = $service->DefaultDocuments($service->service_id);
    
                foreach($default_documents as $document){
                    $document->files = $record->caseDocuments($record->unique_id,$document->unique_id);
                }
                
    
                $service->Documents = $default_documents;
                $service->MainService = $service->Service($service->service_id);
                $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
                $case_folders = CaseFolders::where("case_id",$record->unique_id)->get();
                foreach($documents as $document){
                    $document->files = $record->caseDocuments($record->unique_id,$document->unique_id);
                }
                foreach($case_folders as $document){
                    $document->files = $record->caseDocuments($record->unique_id,$document->unique_id);
                }
                $file_url = professionalDirUrl($this->subdomain)."/documents";
                $file_dir = professionalDir($this->subdomain)."/documents";
                $data['file_url'] = $file_url;
                $data['file_dir'] = $file_dir;
                $data['service'] = $service;
                $data['documents'] = $documents;
                $data['case_folders'] = $case_folders;
                $data['record'] = $record;
                
                $response['status'] = "success";
                $response['data'] = $data;
            }

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function saveExchangeDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
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

            $response['status'] = "success";
            $response['message'] = "File transfered successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function exchangeUserDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $document_type = $request->input("document_type");
            $folder_id = $request->input("folder_id");
            $case_id = $request->input("case_id");
            $files = $request->input("files");
            $created_by = $request->input("created_by");
            $user_files = $request->input("user_files");
            $case_doc_id = array();
            foreach($user_files as $file){

                $check_document = Documents::where("is_shared",1)
                                ->where("shared_id",$file['unique_id'])
                                ->first();

                $source = userDir($file['user_id'])."/documents/".$file['file_name'];
                $new_name = randomNumber(5)."-".$file['original_name'];
                $destination = professionalDir($this->subdomain)."/documents/".$new_name;
                if(empty($check_document)){
                    copy($source, $destination);
                    $document_id = randomNumber();
                    $object = new Documents();
                    $object->file_name = $new_name;
                    $object->original_name = $file['original_name'];
                    $object->unique_id = $document_id;
                    $object->is_shared = 1;
                    $object->shared_id = $file['unique_id'];
                    $object->created_by = $created_by;

                    $object->save();
                }else{
                    $document_id = $check_document->unique_id;
                    if(!file_exists(professionalDir($this->subdomain)."/documents/".$check_document->file_name)){
                        $destination = professionalDir($this->subdomain)."/documents/".$check_document->file_name;
                        copy($source, $destination);
                    }
                }
                $case_document = CaseDocuments::where("case_id",$case_id)
                                            ->where("file_id",$document_id)
                                            ->first();
                if(empty($case_document)){
                    $object2 = new CaseDocuments();
                    $object2->case_id = $case_id;
                    $object2->unique_id = randomNumber();
                }else{
                    $object2 = CaseDocuments::find($case_document->id);
                }
                
                $object2->folder_id = $folder_id;
                $object2->file_id = $document_id;
                $object2->document_type = $document_type;
                $object2->created_by = $created_by;
                $object2->added_by = "client";
                $object2->save();
            }
            $response['status'] = "success";
            $response['message'] = "File transfered successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function removeCaseDocument(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $case_id = $request->input("case_id");
            $folder_id = $request->input("folder_id");
            $file_id = $request->input("file_id");
            $document_type = $request->input("document_type");
            // pre($postData);
            $document = Documents::where("shared_id",$file_id)->first();
            // pre($document->toArray());
            if(!empty($document)){
                
                $check_document = CaseDocuments::where("case_id",$case_id)
                                    ->where("folder_id",$folder_id)
                                    ->where("document_type",$document_type)
                                    ->where("file_id",$document->unique_id)
                                    ->first();
                
                if(!empty($check_document)){
                    CaseDocuments::deleteRecord($check_document->id);
    
                    $response['status'] = "success";
                    $response['message'] = "File removed successfully"; 
                }else{
                    $response['status'] = "error";
                    $response['message'] = "Issue in file removing"; 
                }     
            }else{
                $response['status'] = "error";
                $response['message'] = "File not found"; 
            }
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function caseDocumentDetail(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $document_id = $request->input("document_id");
            $record = CaseDocuments::with('FileDetail')->where("unique_id",$document_id)->first();  
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;
            $data['record'] = $record;
            $response['status'] = "success";
            $response['data'] = $data; 

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function documentDetail(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $document_id = $request->input("document_id");
            $record = Documents::where("unique_id",$document_id)->first();  
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;
            $data['record'] = $record;
            $response['status'] = "success";
            $response['data'] = $data; 

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function fetchDocumentChats(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $chats = DocumentChats::with('FileDetail')->where("case_id",$request->input("case_id"))
                                ->where("document_id",$request->input("document_id"))
                                ->get();
            $data['chats'] = $chats;
            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function saveDocumentChat(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $object = new DocumentChats();
            $object->case_id = $request->input("case_id");
            $object->document_id = $request->input("document_id");
            $object->message = $request->input("message");
            $object->type = $request->input("type");
            if($request->input("type") == 'file'){
                $document_id = randomNumber();
                $object2 = new Documents();
                $object2->file_name = $request->input("file_name");
                $object2->original_name = $request->input("original_name");
                $object2->unique_id = $document_id;
                $object2->created_by = 0;
                $object2->save();

                $object->file_id = $document_id;
            }
            $object->send_by = 'client';
            $object->created_by = $request->input("created_by");
            $object->save();

            $response['status'] = "success";
            $response['message'] = "Message send successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function fetchCaseDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $documents = CaseDocuments::with(['FileDetail','Chats'])
                        ->where("case_id",$request->input("case_id"))
                        ->get();

            $response['status'] = "success";
            $response['data'] = $documents;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function fetchChats(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $chat_type = $request->input("chat_type");
            $case_id = '';
            if($request->input("case_id")){
                $case_id = $request->input("case_id");
                $case = Cases::with(['AssingedMember','VisaService'])->where("unique_id",$case_id)->first();
            }
            $chats = Chats::with('FileDetail')
                                ->where("chat_type",$request->input("chat_type"))
                                ->where(function($query) use($chat_type,$case_id){
                                    if($chat_type == 'case_chat'){
                                        $query->where("case_id",$case_id);
                                    }
                                })
                                ->where("chat_client_id",$request->input("client_id"))
                                ->get();
            if($chat_type == 'case_chat'){
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
                                        ->whereDoesntHave("UserChatGenRead",function($query) use($user_id){
                                            $query->where("user_id",$user_id);
                                        })
                                        ->where('chat_client_id',$user_id)
                                        ->get();
                foreach($unread_general_chat as $chat){
                    $object = new ChatRead();
                    $object->chat_id = $chat->id;
                    $object->user_type = 'user';
                    $object->user_id = $request->input("client_id");
                    $object->chat_type = 'general';
                    $object->save();
                }
            }
            $data['chats'] = $chats;
            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function saveChat(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            
            $object = new Chats();
            if($request->input("chat_type") == 'case_chat'){
                $object->case_id = $request->input("case_id");
            }
            $object->message = $request->input("message");
            $object->type = $request->input("type");
            $object->chat_type = $request->input("chat_type");
            
            if($request->input("type") == 'file'){
                $document_id = randomNumber();
                $object2 = new Documents();
                $object2->file_name = $request->input("file_name");
                $object2->original_name = $request->input("original_name");
                $object2->unique_id = $document_id;
                $object2->created_by = 0;
                $object2->save();

                $object->file_id = $document_id;
            }
            $object->send_by = 'client';
            $object->created_by = $request->input("client_id");
            $object->chat_client_id = $request->input("client_id");
            $object->save();

            $response['status'] = "success";
            $response['message'] = "Message send successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function fetchCaseInvoice(Request $request)
    {
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $client_id = $request->input("client_id");
            if($request->input("invoice_type") == 'all'){
                $records = CaseInvoices::with(['Invoice'])
                ->whereHas("Invoice",function($query) use($client_id){
                    $query->where("client_id",$client_id);
                })
                ->orderBy('id',"desc")
                ->get();
                $data['records'] = $records;
            }else{
                $records = CaseInvoices::with(['Invoice'])
                ->where("case_id",$case_id)
                ->orderBy('id',"desc")
                ->paginate();
                $data['records'] = $records->items();
                $data['last_page'] = $records->lastPage();
                $data['current_page'] = $records->currentPage();
                $data['total_records'] = $records->total();
            }
           
            
            $response['status'] = "success";
            $response['data'] = $data;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function viewCaseInvoice(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $id = $request->input("invoice_id");
            $invoice = CaseInvoices::with(["Invoice","InvoiceItems"])->where("unique_id",$id)->first();

            $case_id = $invoice->case_id;
            $case = Cases::where("unique_id",$case_id)->first();
            $client = $case->Client($case->client_id);
            $professional = ProfessionalDetails::first();
            $data['professional'] = $professional;
            $data['case'] = $case;
            $data['client'] = $client;
            $data['invoice'] = $invoice;

            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function fetchInvoice(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $id = $request->input("invoice_id");
            $invoice = Invoices::with(['CaseInvoice'])->where("unique_id",$id)->first();
            $data['invoice'] = $invoice;
            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function sendInvoiceData(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $id = $request->input("invoice_id");

            $object = Invoices::where("unique_id",$id)->first();
            $object->payment_method = $request->input("payment_method");
            $object->paid_amount = $request->input("amount_paid");
            $object->transaction_response = $request->input("transaction_response");
            $object->paid_date = date("Y-m-d H:i:s");
            $object->paid_by = $request->input("paid_by");
            $object->payment_status = 'paid';
            $object->save();
            $response['link_to'] = $object->link_to;
            $response['status'] = "success";
            $response['message'] = "Payment detail submitted";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }
    public function professionalInfo(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $company = ProfessionalDetails::first();
            $admin = User::where("role","admin")->first();
            $services = ProfessionalServices::orderBy('id',"desc")->get();
            foreach ($services as $value) {
                 $value->service_info = $value->Service($value->service_id);
            }

            $data['company'] = $company;
            $data['admin'] = $admin;
            $data['services'] = $services;
            $response['status'] = 'success';
            $response['data'] = $data;  
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function addAssessmentCase(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $unique_id = randomNumber();
            $created_by = $request->input("created_by");
            $assessment = $request->input("assessment");
            
            $check_assessment = AssessmentCase::where("assessment_id",$assessment['unique_id'])->first();

            $service = ProfessionalServices::where("service_id",$assessment['visa_service_id'])->first();
            if(!empty($check_assessment)){
                $object = Cases::where("unique_id",$check_assessment->case_id)->first();
            }else{
                $object = new Cases();
                $object->unique_id = $unique_id;
            }
            
            $object->case_title = $assessment['assessment_title'];
            $object->visa_service_id = $service->unique_id;
            $object->client_id = $assessment['user_id'];
            $object->save();

            if(!empty($check_assessment)){
                $ass_object = AssessmentCase::where("assessment_id",$check_assessment->assessment_id)->first();
            }else{
                $ass_object = new AssessmentCase();
            }
            $ass_object->case_id = $unique_id;
            $ass_object->assessment_id = $assessment['unique_id'];
            $ass_object->client_id = $assessment['user_id'];
            $ass_object->save();

            $documents = $assessment['assessment_documents'];
            foreach($documents as $ass_document){
                $document = Documents::where("shared_id",$ass_document['file_id'])->first();
                if(!empty($document)){
                    $document_id = $document->unique_id;
                }else{
                    $file = $ass_document['file_detail'];
                    $source = userDir($file['user_id'])."/documents/".$file['file_name'];
                    $new_name = randomNumber(5)."-".$file['original_name'];
                    $destination = professionalDir($this->subdomain)."/documents/".$new_name;
                    
                    copy($source, $destination);
                    $document_id = randomNumber();
                    $object = new Documents();
                    $object->file_name = $new_name;
                    $object->original_name = $file['original_name'];
                    $object->unique_id = $document_id;
                    $object->is_shared = 1;
                    $object->shared_id = $file['unique_id'];
                    $object->created_by = $created_by;

                    $object->save();
                    
                }
                $object2 = new CaseDocuments();
                $object2->case_id = $unique_id;
                $object2->unique_id = randomNumber();
                $object2->folder_id = $ass_document['folder_id'];
                $object2->file_id = $document_id;
                $object2->added_by = 'client';
                $object2->created_by = $created_by;
                $object2->document_type = "default";
                $object2->save();
            }
            $response['status'] = "success";
            $response['message'] = "Case created successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }

    public function getTasksList(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $task_status = '';
            if($request->input("task_status")){
                $task_status = $request->input("task_status");
            }
            if($request->input("task_type") == 'all'){
                $client_id = $request->input("client_id");
                $records = CaseTasks::with('Case')->orderBy('id',"desc")
                        ->where(function($query) use($search,$task_status){
                            if($search != ''){
                                $query->where("task_title","LIKE","%$search%");
                            }
                            if($task_status != ''){
                                $query->where("status",$task_status);
                            }
                        })
                        ->where("client_id",$client_id)
                        ->get();
                $data['records'] = $records;
            }else{
                $records = CaseTasks::with(['Invoice'])
                ->where("case_id",$case_id)
                ->orderBy('id',"desc")
                ->paginate();
                $data['records'] = $records->items();
                $data['last_page'] = $records->lastPage();
                $data['current_page'] = $records->currentPage();
                $data['total_records'] = $records->total();
            }
            $response['status'] = "success";
            $response['data'] = $data;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }
    
    public function viewCaseTask(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $id = $request->input("task_id");
            $record = CaseTasks::with(['CaseTaskFiles'])->where("unique_id",$id)->first();
            
            $professional = ProfessionalDetails::first();
            $response['professional'] = $professional;
            $response['status'] = 'success';
            $response['record'] = $record;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }
    
}
