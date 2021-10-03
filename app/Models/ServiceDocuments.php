<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDocuments extends Model
{
    use HasFactory;
    protected $table = "service_documents";

    static function deleteRecord($id){
        ServiceDocuments::where("id",$id)->delete();
    }
}
