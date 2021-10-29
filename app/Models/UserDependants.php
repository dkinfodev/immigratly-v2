<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDependants extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        UserDependants::where("id",$id)->delete();
    }
}
