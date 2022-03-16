<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AppointmentSchedule extends Model
{
    use HasFactory;
    protected $table = "appointment_schedule";

    public function Location()
    {
        return $this->belongsTo('App\Models\ProfessionalLocations','location_id','unique_id');
    }
}
