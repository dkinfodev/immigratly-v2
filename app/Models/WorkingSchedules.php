<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingSchedules extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        WorkingSchedules::where("id",$id)->delete();
    }
}
