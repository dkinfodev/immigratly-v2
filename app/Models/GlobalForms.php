<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class GlobalForms extends Model
{
    use HasFactory;
    protected $table = "global_forms";


	static function deleteRecord($id){
	        GlobalForms::where("id",$id)->delete();
    }
}
