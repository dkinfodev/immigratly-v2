<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentTypes extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        AppointmentTypes::where("id",$id)->delete();
    }
}