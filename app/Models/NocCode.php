<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class NocCode extends Model
{
    use HasFactory;
    protected $table = "noc_code";
 	
 	public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        NocCode::where("id",$id)->delete();
    }
}
