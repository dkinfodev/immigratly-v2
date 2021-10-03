<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiConstants extends Model
{
    use HasFactory;
    protected $table = "api_constants";

    static function deleteRecord($id){
        ApiContants::where("id",$id)->delete();
    }

}
