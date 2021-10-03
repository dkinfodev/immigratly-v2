<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCase extends Model
{
    use HasFactory;
    protected $table = "assessment_case";

    static function deleteRecord($id){
        AssessmentCase::where("id",$id)->delete();    
    }

    public function Case()
    {
        return $this->belongsTo('App\Models\Cases','case_id','unique_id');
    }    
}
