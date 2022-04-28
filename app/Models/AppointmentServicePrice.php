<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentServicePrice extends Model
{
    use HasFactory;
    protected  $fillable = ['appointment_type_id',"visa_service_id","price","created_at","updated_at"];
    protected $table = "appointment_service_price";

    
}
