<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedAppointments extends Model
{
    use HasFactory;

    public function Client($client_id)
    {
        $user = \DB::table(MAIN_DATABASE.".users")->where("unique_id",$client_id)->first();
        return $user;
    }

    public function Lead($lead_id)
    {
        $user = Leads::where("unique_id",$lead_id)->first();
        return $user;
    }
}
