<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenceBodies extends Model
{
    use HasFactory;
    protected $table = "licence_bodies";

    public function CountryName()
    {
        return $this->belongsTo('App\Models\Countries','country_id');
    }

    static function deleteRecord($id){
        LicenceBodies::where("id",$id)->delete();
    }
}
