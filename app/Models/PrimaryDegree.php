<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class PrimaryDegree extends Model
{
    use HasFactory;
    protected $table = "primary_degree";
 	
 	public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        PrimaryDegree::where("id",$id)->delete();
    }
}
