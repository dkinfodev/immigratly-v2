<?php

namespace App\Http\Controllers\Telecaller;

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

class MessagesCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('telecaller');
    }

    public function allMessages(Request $request)
    {
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "all_messages";
        $unread_general_chat = Chats::where("case_id",0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_case_chat = Chats::where("case_id",'!=',0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_doc_chat = DocumentChats::where("send_by","!=","admin")
                                    ->where('admin_read',0)
                                    ->count();


        $general_messages = Chats::with('Case')
                                    ->where("case_id",0)
                                    ->groupBy("chat_client_id")
                                    ->orderBy("created_at","desc")
                                    ->get();
        $case_messages = Chats::with(['Case'])->where("case_id","!=",0)
                                    ->groupBy("chat_client_id")
                                    ->orderBy("created_at","desc")
                                    ->get();
        $document_chats = DocumentChats::with(['Case'])
                                    ->where("send_by","!=","admin")
                                    ->groupBy("document_id")
                                    ->get();
        
        $grouped_messages = array();
        foreach($general_messages as $msg){
            $temp = $msg;
            $temp->href = baseUrl("messages-center/general-chats?client_id=".$msg->client_id);
            $temp->message_type = "general";
            $grouped_messages[] = $temp;
        }    
        foreach($case_messages as $msg){
            $temp = $msg;
            $temp->href = baseUrl("messages-center/case-chats?case_id=".$msg->case_id);
            $temp->message_type = "case";
            $grouped_messages[] = $temp;
        }
        foreach($document_chats as $msg){
            $temp = $msg;
            $temp->href = baseUrl("messages-center/document-chats?document_id=".$msg->document_id);
            $temp->message_type = "document";
            $grouped_messages[] = $temp;
        }
        
        $messages = array();
        array_multisort( array_column($grouped_messages, "created_at"), SORT_DESC, $grouped_messages );

        
        $subdomain = \Session::get("subdomain");
        $viewData['subdomain'] = $subdomain;
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
        $unread_general_chat = Chats::where("case_id",0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_case_chat = Chats::where("case_id",'!=',0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_doc_chat = DocumentChats::where("send_by","!=","admin")
                                    ->where('admin_read',0)
                                    ->count();
        $grouped_messages = Chats::where("case_id",0)
                                    // ->doesntHave("AdminChatGenRead")
                                    ->groupBy("chat_client_id")
                                    ->orderBy("id","desc")
                                    ->get();
        $messages = array();
        if($request->get("client_id")){
            $messages = Chats::where("case_id",0)
                                    // ->doesntHave("AdminChatGenRead")
                                ->where("chat_client_id",$request->get("client_id"))
                                ->groupBy("chat_client_id")
                                ->orderBy("created_at","asc")
                                ->get();
        }else{
            if(isset($grouped_messages[0])){
                $messages = Chats::where("case_id",0)
                                // ->doesntHave("AdminChatGenRead")
                            ->where("chat_client_id",$grouped_messages[0]->chat_client_id)
                           
                            ->orderBy("created_at","asc")
                            ->get();
            }
        }
        $subdomain = \Session::get("subdomain");
        $viewData['subdomain'] = $subdomain;
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_doc_chat'] = $unread_doc_chat;
        $viewData['grouped_messages'] = $grouped_messages;
        $viewData['messages'] = $messages;
        $viewData['activeTab'] = "messages";
        return view(roleFolder().'.messages.messages',$viewData);
    } 

    public function caseChats(Request $request)
    {
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "case_chats";
        $unread_general_chat = Chats::where("case_id",0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_case_chat = Chats::where("case_id",'!=',0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_doc_chat = DocumentChats::where("send_by","!=","admin")
                                    ->where('admin_read',0)
                                    ->count();
        $grouped_messages = Chats::where("case_id","!=",0)
                                    // ->doesntHave("AdminChatGenRead")
                                    ->groupBy("case_id")
                                    ->orderBy("id","desc")
                                    ->get();
        $messages = array();
        if($request->get("case_id")){
            $messages = Chats::where("case_id","!=",0)
                                    // ->doesntHave("AdminChatGenRead")
                                ->where("case_id",$request->get("case_id"))
                                ->orderBy("created_at","asc")
                                ->get();
        }else{
            if(isset($grouped_messages[0])){
                
                $messages = Chats::where("case_id","!=",0)
                                // ->doesntHave("AdminChatGenRead")
                            ->where("case_id",$grouped_messages[0]->case_id)
                            ->orderBy("created_at","asc")
                            ->get();
            }
        }
        $subdomain = \Session::get("subdomain");
        $viewData['subdomain'] = $subdomain;
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
        $unread_general_chat = Chats::where("case_id",0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();
        $unread_case_chat = Chats::where("case_id",'!=',0)
                                    ->doesntHave("AdminChatGenRead")
                                    ->count();

        $unread_doc_chat = DocumentChats::where("send_by","!=","admin")
                                    ->where('admin_read',0)
                                    ->count();
        $grouped_messages = DocumentChats::where("send_by","!=","admin")
                                    ->groupBy("document_id")
                                    ->orderBy("created_at","desc")
                                    ->get();
        $messages = array();
        if($request->get("document_id")){
            $messages = DocumentChats::where('document_id',$request->get("document_id"))
                                    ->orderBy("created_at","asc")
                                    ->get();
        }else{
            if(!empty($grouped_messages)){
                $messages = DocumentChats::where('document_id',$grouped_messages[0]->document_id)
                                        ->groupBy("document_id")
                                        ->orderBy("created_at","asc")
                                        ->get();
            }
        }
        $subdomain = \Session::get("subdomain");
        $viewData['subdomain'] = $subdomain;
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['unread_doc_chat'] = $unread_doc_chat;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['grouped_messages'] = $grouped_messages;
        $viewData['messages'] = $messages;
        $viewData['pageTitle'] = "Messages Center";
        $viewData['message_type'] = "document_chats";
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
        // $subdomain = $request->input("subdomain");
        if($request->input("message_type") == 'case_chats' || $request->input("message_type") == 'general_chats'){
            $object = new Chats();
            if($request->input("message_type") == 'case_chats'){
                $object->case_id = $request->input("case_id");
                $object->chat_type = 'case_chat';
            }
            
            if($file = $request->file('attachment')){
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $newName        = mt_rand(1,99999)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir()."/documents";
                
                if($file->move($destinationPath, $newName)){
                    $object->type = 'file';
                    $file_id = randomNumber();
                    $object2 = new Documents();
                    $object2->file_name = $newName;
                    $object2->original_name = $fileName;
                    $object2->unique_id = $file_id;
                    $object2->created_by = 0;
                    $object2->save();
                
                    if($request->input("message")){
                        $object->file_message = $request->input("message");
                    }                
                    $object->message = $fileName;
                    $object->type = 'file';
                    $object->file_id = $file_id;
                    $object->send_by = \Auth::user()->role;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->chat_client_id = $request->input("client_id");
                }
            }else{
                $object->message = $request->input("message");
                $object->type = 'text';
            }
            $object->send_by = \Auth::user()->role;
            $object->created_by = \Auth::user()->unique_id;
            $object->chat_client_id = $request->input("client_id");
            $object->save();
        }
        if($request->input("message_type") == 'document_chats'){
           
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
                    
                    $case_id = $request->input("case_id");
                    $document_id = $request->input("document_id");
                    $case = Cases::where("unique_id",$case_id)->first();
                    $case_document = CaseDocuments::where("unique_id",$document_id)
                                            ->where("case_id",$case_id)
                                            ->first();
                    $folder_id = $case_document->folder_id;
                    $response['status'] = true;
                    $response['message'] = "File send successfully";
                }else{
                    $response['status'] = true;
                    $response['message'] = "File send failed, try again!";
                }
            }else{
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
            }
        }else{
            $response['status'] = true;
            $response['message'] = "Message send successfully";
        }

        return response()->json($response);
    }

}
