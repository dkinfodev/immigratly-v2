<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientExperience extends Model
{
    use HasFactory;
    protected $table = "client_experience";

    static function deleteRecord($id){
        ClientExperience::where("id",$id)->delete();
    }

    public function CountryName()
    {
        return $this->belongsTo('App\Models\Countries','country_id');
    }

    public function StateName()
    {
        return $this->belongsTo('App\Models\States','state_id');
    }
}
