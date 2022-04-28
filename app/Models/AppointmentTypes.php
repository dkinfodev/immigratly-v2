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

    public function timeDuration()
    {
        return $this->belongsTo('App\Models\TimeDuration','duration','unique_id');
    }

    static function getServicePrices($appointment_type_id,$service_id=''){
        if($service_id != ''){
            $prices = AppointmentServicePrice::where("appointment_type_id",$appointment_type_id)
            ->where(function($query) use($service_id){
                if($service_id != ''){
                    $query->where("visa_service_id",$service_id);
                }
            })->first();
        }else{
            $prices = AppointmentServicePrice::where("appointment_type_id",$appointment_type_id)->get();
        }
        
        return $prices;
    }
}
