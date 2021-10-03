<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguageProficiency extends Model
{
    use HasFactory;

    protected $table = "user_language_proficiency";

    static function deleteRecord($id){
        UserLanguageProficiency::where("id",$id)->delete();
    }
}
