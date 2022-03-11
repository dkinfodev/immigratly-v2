<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProfessionalLocations extends Model
{
    use HasFactory;
    protected $table = "professional_locations";

    static function deleteRecord($id){
        ProfessionalLocations::where("id",$id)->delete();
    }
}
