<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptureCategory extends Model
{
    use HasFactory;

    protected $table = "capture_category";

    static function deleteRecord($id){
        CaptureCategory::where("id",$id)->delete();    
    }
}
