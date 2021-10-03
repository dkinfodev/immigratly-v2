<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalAssessments extends Model
{
    use HasFactory;

    public function Assessment()
    {
        return $this->belongsTo('App\Models\Assessments','assessment_id',"unique_id")
               ->with("VisaService")
               ->whereHas("VisaService");
    }

    public function AssessmentForm()
    {
        return $this->belongsTo('App\Models\AssessmentForms','form_id',"unique_id");
    }
}
