<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProfessionalDetails extends Model
{
    protected $table = "professional_details";

    public function User()
    {
        return $this->belongsTo('App\User','user_id');
    }

    static function Country($id)
    {
        $data = DB::table(MAIN_DATABASE.".countries")->where("id",$id)->first();
        return $data;
    }

    static function State($id)
    {
        $data = DB::table(MAIN_DATABASE.".states")->where("id",$id)->first();
        return $data;
    }

    static function City($id)
    {
        $data = DB::table(MAIN_DATABASE.".cities")->where("id",$id)->first();
        return $data;
    }
}
