<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentReports extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        AssessmentReports::where("id",$id)->delete();
    }
}
