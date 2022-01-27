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

    static function nocCodes($noc_code_id){
        $ids = explode(",",$noc_code_id);
        $noc_codes = NocCode::whereIn("id",$ids)->get();
        return $noc_codes;
    }

    static function Country($id)
    {
        $data = \DB::table(MAIN_DATABASE.".countries")->where("id",$id)->first();
        return $data;
    }

    static function State($id)
    {
        $data = \DB::table(MAIN_DATABASE.".states")->where("id",$id)->first();
        return $data;
    }
}
