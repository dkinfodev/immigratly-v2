<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroupComments extends Model
{
    use HasFactory;
    protected $table = "chat_group_comments";

    static function deleteRecord($id){
        ChatGroupComments::where("id",$id)->delete();
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User','send_by','unique_id');
    }
}
