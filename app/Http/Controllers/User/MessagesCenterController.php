<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\UserDependants;
use App\Models\Chats;
use App\Models\ProfessionalDetails;
use App\Models\Documents;
use App\Models\DocumentChats;
use App\Models\Cases;
use App\Models\CaseDocuments;
use App\Models\UserWithProfessional;

class MessagesCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function professionals(){
        $viewData['pageTitle'] = "Messages Center";

        $viewData['activeTab'] = "messages";

        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)->get();
     
        $viewData['professionals'] = $professionals;
        return view(roleFolder().'.messages.professionals',$viewData);
    }
    public function allMessages(Request $request)
    {
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "all_messages";

        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)->get();
        $pendingApproval = 0;
        $unread_general_chat = 0;
        $unread_case_chat = 0;
        $unread_doc_chat = 0;
        $grouped_messages = array();
        foreach($professionals as $professional){
            // $cases = $professional->Cases($professional->professional,$professional->user_id);
            $subdomain = $professional->professional;
            $data = array();
            $data['client_id'] = \Auth::user()->unique_id;
            $apiResponse = professionalCurl('messages-center/all-messages',$subdomain,$data);
            if(isset($apiResponse['status']) && $apiResponse['status'] == 'success'){
                $response['status'] = true;
                $unread_general_chat += $apiResponse['unread_general_chat'];
                $unread_doc_chat += $apiResponse['unread_doc_chat'];
                $unread_case_chat += $apiResponse['unread_case_chat'];
                $grouped_messages = array_merge($apiResponse['grouped_messages'],$grouped_messages);
            }  
        }
        
        // foreach($grouped_messages as $chat){
        //     $chat = (object)$chat;
        //     // pre($chat);
        //     if($chat->send_by != 'client'){
        //         $user = docChatSendBy($chat->send_by,$chat->created_by,$chat->subdomain);
        //         echo $chat->subdomain."<br>";
        //         echo "Prof Profile: ".professionalProfile($chat->created_by,'t',$chat->subdomain)."<br>";
        //     }else{
        //         $user = docChatSendBy($chat->send_by,$chat->created_by);   
        //         echo "User Profile: ".userProfile($chat->created_by,'t')."<br>";
        //     }
         
        //     $chat_users = $chat->chat_users;
        //     // pre($chat_users);    
        // }
        // exit;
        $messages = array();
        array_multisort( array_column($grouped_messages, "created_at"), SORT_DESC, $grouped_messages );

        $viewData['subdomain'] = '';
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_doc_chat'] = $unread_doc_chat;
        $viewData['grouped_messages'] = $grouped_messages;
        $viewData['messages'] = $messages;
        $viewData['activeTab'] = "messages";
        return view(roleFolder().'.messages.messages',$viewData);
    } 

    public function generalChats(Request $request)
    {
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "general_chats";
        $professional = '';
        if($request->get("professional")){
            $professional = $request->get("professional");
        }
        
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)
                                            ->where(function($query) use($professional){
                                                if($professional != ''){
                                                    $query->where("professional",$professional);
                                                }
                                            })
                                            ->get();
        $pendingApproval = 0;
        $unread_general_chat = 0;
        $unread_case_chat = 0;
        $unread_doc_chat = 0;
        $grouped_messages = array();
        $messages = array();
        foreach($professionals as $professional){
            // $cases = $professional->Cases($professional->professional,$professional->user_id);
            $subdomain = $professional->professional;
            $data = array();
            $data['client_id'] = \Auth::user()->unique_id;
            $apiResponse = professionalCurl('messages-center/general-chats',$subdomain,$data);
            if(isset($apiResponse['status']) && $apiResponse['status'] == 'success'){
                $response['status'] = true;
                $unread_general_chat += $apiResponse['unread_general_chat'];
                $unread_doc_chat += $apiResponse['unread_doc_chat'];
                $unread_case_chat += $apiResponse['unread_case_chat'];
                $grouped_messages = array_merge($apiResponse['grouped_messages'],$grouped_messages);
                $messages = array_merge($apiResponse['messages'],$messages);
            }  
        }
        array_multisort( array_column($grouped_messages, "created_at"), SORT_DESC, $grouped_messages );
        
        $viewData['subdomain'] = $messages[0]['subdomain'];
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_doc_chat'] = $unread_doc_chat;
        $viewData['grouped_messages'] = $grouped_messages;
        $viewData['messages'] = $messages;
        return view(roleFolder().'.messages.messages',$viewData);
    } 

    public function caseChats(Request $request)
    {
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "case_chats";
        $professional = '';
        if($request->get("professional")){
            $professional = $request->get("professional");
        }
        
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)
                                            ->where(function($query) use($professional){
                                                if($professional != ''){
                                                    $query->where("professional",$professional);
                                                }
                                            })
                                            ->get();
        $pendingApproval = 0;
        $unread_general_chat = 0;
        $unread_case_chat = 0;
        $unread_doc_chat = 0;
        $grouped_messages = array();
        $messages = array();
        foreach($professionals as $professional){
            // $cases = $professional->Cases($professional->professional,$professional->user_id);
            $subdomain = $professional->professional;
            $data = array();
            $data['client_id'] = \Auth::user()->unique_id;
            if($request->get("case_id")){
                $data['case_id'] = $request->get("case_id");
            }            
            $apiResponse = professionalCurl('messages-center/case-chats',$subdomain,$data);
            // pre($apiResponse);
            // // exit;
            if(isset($apiResponse['status']) && $apiResponse['status'] == 'success'){
                $response['status'] = true;
                $unread_general_chat += $apiResponse['unread_general_chat'];
                $unread_doc_chat += $apiResponse['unread_doc_chat'];
                $unread_case_chat += $apiResponse['unread_case_chat'];
                $grouped_messages = array_merge($apiResponse['grouped_messages'],$grouped_messages);
                $messages = array_merge($apiResponse['messages'],$messages);
            }  
        }
        // pre($grouped_messages);
        // pre($messages);
        // exit;
        array_multisort( array_column($grouped_messages, "created_at"), SORT_DESC, $grouped_messages );
        
        
        $viewData['subdomain'] = $messages[0]['subdomain'];
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_doc_chat'] = $unread_doc_chat;
        $viewData['grouped_messages'] = $grouped_messages;
        
        $viewData['messages'] = $messages;
        $viewData['activeTab'] = "messages";
        return view(roleFolder().'.messages.messages',$viewData);
    }

    public function documentChats(Request $request)
    {
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "document_chats";
        $professional = '';
        if($request->get("professional")){
            $professional = $request->get("professional");
        }
        $document_id = '';
        if($request->get("document_id")){
            $document_id = $request->get("document_id");
        }
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)
                                            ->where(function($query) use($professional){
                                                if($professional != ''){
                                                    $query->where("professional",$professional);
                                                }
                                            })
                                            ->get();
        $pendingApproval = 0;
        $unread_general_chat = 0;
        $unread_case_chat = 0;
        $unread_doc_chat = 0;
        $grouped_messages = array();
        $messages = array();
        foreach($professionals as $professional){
            // $cases = $professional->Cases($professional->professional,$professional->user_id);
            $subdomain = $professional->professional;
            $data = array();
            $data['client_id'] = \Auth::user()->unique_id;
            if($request->get("document_id")){
                $data['document_id'] = $request->get("document_id");
            }            
            $apiResponse = professionalCurl('messages-center/document-chats',$subdomain,$data);
            // pre($apiResponse);
            // exit;
            if(isset($apiResponse['status']) && $apiResponse['status'] == 'success'){
                $response['status'] = true;
                $unread_general_chat += $apiResponse['unread_general_chat'];
                $unread_doc_chat += $apiResponse['unread_doc_chat'];
                $unread_case_chat += $apiResponse['unread_case_chat'];
                $grouped_messages = array_merge($apiResponse['grouped_messages'],$grouped_messages);
                $messages = array_merge($apiResponse['messages'],$messages);
            }  
        }
        // pre($grouped_messages);
        // pre($messages);
        // exit;
        array_multisort( array_column($grouped_messages, "created_at"), SORT_DESC, $grouped_messages );
        
        
        $viewData['subdomain'] = $messages[0]['subdomain'];
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_doc_chat'] = $unread_doc_chat;
        // $grouped_messages = array();
        $viewData['grouped_messages'] = $grouped_messages;
        // $messages = array();
        $viewData['messages'] = $messages;
        $viewData['activeTab'] = "messages";
        return view(roleFolder().'.messages.messages',$viewData);
    }

    public function getAjaxList($client_id,Request $request)
    {
        $search = $request->input("search");
        $records = DB::table(MAIN_DATABASE.".user_dependants")
                        ->orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("given_name","LIKE","%$search%");
                                $query->where("other_name","LIKE","%$search%");
                            }
                        })
                        ->where("user_id",$client_id)
                        ->paginate();
        $viewData['records'] = $records;
        $viewData['client_id'] = $client_id;
        $view = View::make(roleFolder().'.dependants.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function saveChat(Request $request){
        // $data['case_id'] = $request->input("case_id");
        // $data['document_id'] = $request->input("document_id");
        // $data['message'] = $request->input("message");
        
        // $data['created_by'] = \Auth::user()->unique_id;
        $subdomain = $request->input("subdomain");
        if($request->input("message_type") == 'case_chats' || $request->input("message_type") == 'general_chats'){
          
            $chatIns = array();
            if($request->input("message_type") == 'case_chats'){
                $chatIns['case_id'] = $request->input("case_id");
                $chatIns['chat_type'] = 'case_chat';
            }
            
            if($file = $request->file('attachment')){
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $newName        = mt_rand(1,99999)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir($subdomain)."/documents";
                
                if($file->move($destinationPath, $newName)){
                    $chatIns['type'] = 'file';
                    $file_id = randomNumber();
                    $insData = array();
                    $insData['file_name'] = $newName;
                    $insData['unique_id'] = $file_id;
                    $insData['created_by'] = \Auth::user()->unique_id;
                    $insData['created_at'] = date("Y-m-d H:i:s");
                    $insData['updated_at'] = date("Y-m-d H:i:s");
                    \DB::table(PROFESSIONAL_DATABASE.$subdomain.".documents")->insert($insData);
                 
                    if($request->input("message")){
                        $chatIns['file_message'] = $request->input("message");
                    }   
                    $chatIns['message'] = $fileName;
                    $chatIns['file_id'] = $file_id;
                    
                    
                }
            }else{
                $chatIns['message'] = $request->input("message");
                $chatIns['type'] = 'text';
            }
            $chatIns['send_by'] = 'client';
            $chatIns['created_by'] =\Auth::user()->unique_id;
            $chatIns['chat_client_id'] = $request->input("client_id");
            $chatIns['created_at'] = date("Y-m-d H:i:s");
            $chatIns['updated_at'] = date("Y-m-d H:i:s");
            \DB::table(PROFESSIONAL_DATABASE.$subdomain.".chats")->insert($chatIns);
        }
        if($request->input("message_type") == 'document_chats'){
           
            if ($file = $request->file('attachment')){
                $data['case_id'] = $request->input("case_id");
                $data['document_id'] = $request->input("document_id");
            
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $newName        = mt_rand(1,99999)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir($subdomain)."/documents";
                
                
                if($file->move($destinationPath, $newName)){
                    
                    $file_id = randomNumber();
                    $insData = array();
                    $insData['file_name'] = $newName;
                    $insData['unique_id'] = $file_id;
                    $insData['created_by'] = \Auth::user()->unique_id;
                    $insData['created_at'] = date("Y-m-d H:i:s");
                    $insData['updated_at'] = date("Y-m-d H:i:s");
                    \DB::table(PROFESSIONAL_DATABASE.$subdomain.".documents")->insert($insData);
            
                    $docIns = array();
                    $docIns['case_id'] = $request->input("case_id");
                    $docIns['document_id'] = $request->input("document_id");
                    $docIns['message'] = $fileName;
                    $docIns['type'] = "file";
                    $docIns['created_at'] = date("Y-m-d H:i:s");
                    $docIns['updated_at'] = date("Y-m-d H:i:s");
                    if($request->input("message")){
                        $docIns['file_message'] = $request->input("message");
                    }
                    $docIns['message'] = $fileName;
                    $docIns['file_id'] = $file_id;
                    $docIns['send_by'] = 'client';
                    $docIns['created_by'] =\Auth::user()->unique_id;

                    \DB::table(PROFESSIONAL_DATABASE.$subdomain.".document_chats")->insert($docIns);
                    
                    
                    $response['status'] = true;
                    $response['message'] = "File send successfully";
                }else{
                    $response['status'] = true;
                    $response['message'] = "File send failed, try again!";
                }
            }else{
                $case_id = $request->input("case_id");
                
                $docIns = array();
                $docIns['case_id'] = $request->input("case_id");
                $docIns['document_id'] = $request->input("document_id");
                $docIns['message'] = $request->input("message");
                $docIns['type'] = "text";
               
                $docIns['send_by'] = 'client';
                $docIns['created_by'] =\Auth::user()->unique_id;
                $docIns['created_at'] = date("Y-m-d H:i:s");
                $docIns['updated_at'] = date("Y-m-d H:i:s");
                \DB::table(PROFESSIONAL_DATABASE.$subdomain.".document_chats")->insert($docIns);

                $response['status'] = true;
                $response['message'] = "Message send successfully";
            }
        }else{
            $response['status'] = true;
            $response['message'] = "Message send successfully";
        }

        return response()->json($response);
    }

}
