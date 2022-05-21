<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCases extends Model
{
    use HasFactory;
	
    static function deleteRecord($id){
        UserDependants::where("id",$id)->delete();
    }

    public function VisaService()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id','unique_id');
    }
}
