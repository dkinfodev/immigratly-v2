<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedAppointments extends Model
{
    use HasFactory;

    public function Client()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }
}
