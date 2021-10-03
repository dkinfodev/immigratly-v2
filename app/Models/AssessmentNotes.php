<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentNotes extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        AssessmentNotes::where("id",$id)->delete();
    }
}
