<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaServiceContent extends Model
{
    use HasFactory;
    protected $table = "visa_service_content";

    public function VisaServices()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id');
    }

	public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        VisaServiceContent::where("id",$id)->delete();
    }
}
