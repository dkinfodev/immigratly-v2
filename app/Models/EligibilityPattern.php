<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EligibilityPattern extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        EligibilityPattern::where("id",$id)->delete();
    }
    public function VisaService()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id','unique_id');
    }

    public function SubVisaService()
    {
        return $this->belongsTo('App\Models\VisaServices','sub_visa_service','unique_id');
    }
}
