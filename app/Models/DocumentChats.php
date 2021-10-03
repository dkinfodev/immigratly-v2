<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CaseDocuments;
use App\Models\User;

class DocumentChats extends Model
{
    use HasFactory;

    protected $table = "document_chats";

    static function deleteRecord($id){
        DocumentChats::where("id",$id)->delete();
    }

    static function DocAddedBy($user_id,$send_by,$subdomain=''){
    	$user = array();
        if($send_by == 'client'){
        	$user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$user_id)->first();
        }else{
        	$user = DB::table(PROFESSIONAL_DATABASE.$subdomain.".users")->where("unique_id",$user_id)->first();
        }
        return $user;
    }

    public function FileDetail()
    {
        return $this->belongsTo('App\Models\Documents','file_id','unique_id');
    }

    

}
