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
}
