<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CaseDocuments;
use App\Models\User;

class UserDocumentNotes extends Model
{
    use HasFactory;

    protected $table = "user_document_notes";

    static function deleteRecord($id){
        UserDocumentNotes::where("id",$id)->delete();
    }

    
    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }

    public function FileDetail()
    {
        return $this->belongsTo('App\Models\FilesManager','file_id','unique_id');
    }
}
