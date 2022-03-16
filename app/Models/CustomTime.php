<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTime extends Model
{
    use HasFactory;
    protected $table = "custom_time";

    static function deleteRecord($id){
        CustomTime::where("id",$id)->delete();
    }

   
}
