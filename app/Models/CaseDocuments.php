<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CaseDocuments extends Model
{
    use HasFactory;
    protected $table = "case_documents";

    static function deleteRecord($id){
        CaseDocuments::where("id",$id)->delete();
    }
    
    public function Document($id)
    {
        $service = DB::table(MAIN_DATABASE.".document_folder")->where("id",$id)->first();
        return $service;
    }

    public function FileDetail()
    {
        return $this->belongsTo('App\Models\Documents','file_id','unique_id');
    }

    public function Chats()
    {
        return $this->hasMany('App\Models\DocumentChats','document_id','unique_id');
    }
    public function ChatUsers()
    {
        return $this->hasMany('App\Models\DocumentChats','document_id','unique_id')->groupBy("created_by");
    }

    static function documentUnreadChat($document_id,$user_type='',$subdomain=''){
        if($user_type == 'admin'){
            if($subdomain == ''){
                $subdomain = \Session::get("subdomain");
            }
            if($user_type == 'user'){
                $unread_chat = DB::table(PROFESSIONAL_DATABASE.$subdomain.".document_chats")
                            
                            ->where("document_id",$document_id)
                            ->where("user_read",0)
                            ->count();
            }else{
                $unread_chat = DB::table(PROFESSIONAL_DATABASE.$subdomain.".document_chats")
                           
                            ->where("document_id",$document_id)
                            ->where("admin_read",0)
                            ->count();
            }
            return $unread_chat;
        }
    }
}
