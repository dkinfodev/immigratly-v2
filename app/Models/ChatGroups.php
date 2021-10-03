<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChatGroupComments;

class ChatGroups extends Model
{
    use HasFactory;
    protected $table = "chat_groups";

    static function deleteRecord($id){
    	$chat = ChatGroups::where("id",$id)->delete();
        ChatGroups::where("id",$id)->delete();
        ChatGroupComments::where("chat_id",$chat->unique_id)->delete();
    }

    public function Comments(){
        return $this->hasMany('App\Models\ChatGroupComments','chat_id','unique_id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User','created_by','unique_id');
    }
}
