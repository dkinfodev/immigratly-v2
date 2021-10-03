<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseInvoices;

class ReminderNotes extends Model
{
    use HasFactory;
    protected $table = "reminder_notes";

    static function deleteRecord($id){
    	ReminderNotes::where("id",$id)->delete();
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }

}
