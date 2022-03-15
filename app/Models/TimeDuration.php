<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeDuration extends Model
{
    use HasFactory;
    protected $table = "time_duration";

    static function deleteRecord($id){
	TimeDuration::where("id",$id)->delete();
    }
}
