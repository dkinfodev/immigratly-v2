<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentDocuments extends Model
{
    use HasFactory;
    protected $table = "assessment_documents";

    static function deleteRecord($id){
        AssessmentDocuments::where("id",$id)->delete();
    }
    
    public function FileDetail()
    {
        return $this->belongsTo('App\Models\FilesManager','file_id','unique_id');
    }
    public function Assessment()
    {
        return $this->belongsTo('App\Models\Assessments','assessment_id','unique_id');
    }
    
    
}
