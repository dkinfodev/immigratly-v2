<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class ProfessionalEvent extends Model
{
    use HasFactory;
    protected $table = "professional_event";

    static function deleteRecord($id){
        
        ProfessionalEvent::where("id",$id)->delete();
    }

    public function location()
    {
        return $this->belongsTo('App\Models\ProfessionalLocations','location_id','unique_id');
    }
}
