<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientEducations extends Model
{
    use HasFactory;
    protected $table = "client_educations";

    static function deleteRecord($id){
        ClientEducations::where("id",$id)->delete();
    }

    public function Degree()
    {
        return $this->belongsTo('App\Models\PrimaryDegree','degree_id');
    }
}
