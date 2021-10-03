<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentForms extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        AssessmentForms::where("id",$id)->delete();
    }

    public function Assessment()
    {
        return $this->belongsTo('App\Models\Assessments','assessment_id','unique_id');
    }
}
