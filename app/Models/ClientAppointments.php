<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAppointments extends Model
{
    use HasFactory;

    static function bookingDetail($professional,$booking_id){
        $booking = \DB::table(PROFESSIONAL_DATABASE.$professional.".booked_appointments")->where("unique_id",$booking_id)->first();
        return $booking;
    }
}
