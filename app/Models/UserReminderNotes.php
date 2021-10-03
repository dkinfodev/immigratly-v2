<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReminderNotes extends Model
{
    use HasFactory;

    protected $table = "user_reminder_notes";

    static function deleteRecord($id){
        UserReminderNotes::where("id",$id)->delete();
    }
    
}
