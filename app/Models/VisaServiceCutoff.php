<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaServiceCutoff extends Model
{
    use HasFactory;
    protected $table = "visa_service_cutoff";

    public function VisaServices()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id');
    }

    static function deleteRecord($id){
        VisaServiceCutoff::where("id",$id)->delete();
    }
}
