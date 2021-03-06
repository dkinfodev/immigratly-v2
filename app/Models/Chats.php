<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CaseDocuments;
use App\Models\User;

class Chats extends Model
{
    use HasFactory;

    protected $table = "chats";

    static function deleteRecord($id){
        Chats::where("id",$id)->delete();
    }
    static function ChatUsers($client_id,$chat_type){
        if($chat_type == 'general'){
            $users = Chats::where("chat_client_id",$client_id)
                        ->where("case_id",0)
                        ->groupBy("created_by")
                        ->get();
        }else{
            $users = Chats::where("chat_client_id",$client_id)
                        ->where("case_id","!=",0)
                        ->groupBy("created_by")
                        ->get();
        }
        return $users;
    }
    public function FileDetail()
    {
        return $this->belongsTo('App\Models\Documents','file_id','unique_id');
    }
    public function AdminChatGenRead()
    {
        return $this->hasOne('App\Models\ChatRead','chat_id')
                ->where("user_type","admin")
                ->where("chat_type","general");
    }
    public function UserChatGenRead()
    {
        return $this->hasOne('App\Models\ChatRead','chat_id')
                ->where("user_type","user")
                ->where("chat_type","general");
    }
    public function AdminChatRead()
    {
        return $this->hasOne('App\Models\ChatRead','chat_id')->where("user_type","admin");
    }

    public function UserChatRead()
    {
        return $this->hasOne('App\Models\ChatRead','chat_id')->where("user_type","user");
    }
    public function Case()
    {
        return $this->belongsTo('App\Models\Cases','case_id','unique_id');
    }
}
