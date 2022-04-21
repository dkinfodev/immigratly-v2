<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserInvoices;
use App\Models\AssessmentDocuments;
class Assessments extends Model
{
    use HasFactory;
    protected $table = "assessments";

    static function deleteRecord($id){
        $assessment = Assessments::where("id",$id)->first();
        Assessments::where("id",$id)->delete();
        AssessmentForms::where("assessment_id",$assessment->unique_id)->delete();
        AssessmentDocuments::where("assessment_id",$assessment->unique_id)->delete();
        AssessmentNotes::where("assessment_id",$assessment->unique_id)->delete();
        AssessmentReports::where("assessment_id",$assessment->unique_id)->delete();
        UserInvoices::deleteRecord($assessment->Invoice->id);
        
    }

    public function VisaService()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id','unique_id')->with(['CVTypeDetail']);
    }
    public function Client()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }
    
    public function AssessmentDocuments()
    {
        return $this->hasMany('App\Models\AssessmentDocuments','assessment_id','unique_id')->with("FileDetail");
    }
    public function Invoice()
    {
        return $this->hasOne('App\Models\UserInvoices','link_id','unique_id')->where("link_to","assessment");
    }
    public function Report()
    {
        return $this->hasOne('App\Models\AssessmentReports','assessment_id','unique_id');
    }
    public function Forms()
    {
        return $this->hasMany('App\Models\AssessmentForms','assessment_id','unique_id');
    }
    
}
