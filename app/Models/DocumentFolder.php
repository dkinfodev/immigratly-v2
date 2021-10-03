<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFolder extends Model
{
    //use HasFactory;
    protected $table = "documents_folder";

    static function deleteRecord($id){
        DocumentFolder::where("id",$id)->delete();
    }
}
