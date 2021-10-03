<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;
use App\Models\ChatGroups;
use App\Models\ChatGroupComments;

class ChatGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function index(Request $request){
        $viewData['pageTitle'] = "My Chat Groups";
        $other_groups = ChatGroups::where('created_by','!=',\Auth::user()->unique_id)
                        ->where('status','open')
                        ->count();
        $my_chats = ChatGroups::where('created_by',\Auth::user()->unique_id)->count();
        $total_chats = $other_groups + $my_chats;

        $viewData['other_groups'] = $other_groups;
        $viewData['my_chats'] = $my_chats;
        $viewData['total_chats'] = $total_chats;

        return view(roleFolder().'.chat-groups.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = ChatGroups::withCount("Comments")
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("group_title","LIKE","%$search%");
                                }
                            })
                            ->where("created_by",\Auth::user()->unique_id)
                            ->orderBy('id',"desc")
                            ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.chat-groups.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(Request $request){
        $viewData['pageTitle'] = "Add Chat Group";
        return view(roleFolder().'.chat-groups.add',$viewData);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'group_title' => 'required',
            'description' => 'required',
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
        $unique_id = randomNumber();
        $object =  new ChatGroups();
        $object->unique_id = $unique_id;
        $object->group_title = $request->input("group_title");
        $object->slug = str_slug($request->input("group_title"))."-".$unique_id;
        $object->description = $request->input("description");
        $object->status = "open";
        $object->created_by = \Auth::user()->unique_id;
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('chat-groups');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Chat Group";
        $record = ChatGroups::where("unique_id",$id)->first();
        
        $viewData['record'] = $record;
        return view(roleFolder().'.chat-groups.edit',$viewData);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'group_title' => 'required',
            'description' => 'required',
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
        $object = ChatGroups::where("unique_id",$id)->first();;
        $object->group_title = $request->input("group_title");
        $object->slug = str_slug($request->input("group_title"))."-".$object->unique_id;
        $object->description = $request->input("description");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('chat-groups');    
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $record = ChatGroups::where("unique_id",$id)->first();
        $id = $record->id;
        ChatGroups::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $record = ChatGroups::where("unique_id",$ids[$i])->first();
            $id = $record->id;
            ChatGroups::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function changeStatus(Request $request){
        $data['status'] = $request->input("status");
        ChatGroups::where("unique_id",$request->input("id"))->update($data);

        $response['status'] = true;
        $response['message'] = "Group ".$request->input("status")." successfully";

        return response()->json($response);
    }    

    public function chatGroupComments($id){
        $record = ChatGroups::where("unique_id",$id)->first();
        $viewData['pageTitle'] = "Chat Group Comments";
        $record = ChatGroups::where("unique_id",$id)->first();
        $viewData['record'] = $record;
        $viewData['chat_id'] = $id;
        return view(roleFolder().'.chat-groups.group-comments',$viewData);

    }
    public function fetchComments($chat_id,Request $request){

        $comments = ChatGroupComments::with('User')->where("chat_id",$chat_id)->get();
        $viewData['comments'] = $comments;
        $view = View::make(roleFolder().'.chat-groups.group-chats',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }
    public function sendComment(Request $request){

        $object = new ChatGroupComments();
        $unique_id = randomNumber();
        $object->unique_id = $unique_id;
        $object->chat_id = $request->input("chat_id");
        if($request->input("message")){
            $message = $request->input("message");
            $object->message = $message;
        }
        
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = public_path("/uploads/files");
                if($file->move($destinationPath, $newName)){
                    $object->file_name = $newName;
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
                return response()->json($response);
            } 
        }
        $object->send_by = \Auth::user()->unique_id;
        $object->user_type = "user";
        $object->save();

        $response['status'] = true;
        $response['message'] = "Comment added successfully";

        return response()->json($response);
    }
    
}
