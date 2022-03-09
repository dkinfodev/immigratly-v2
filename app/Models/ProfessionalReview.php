<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\User;

class ProfessionalReview extends Model
{
    protected $table = "professional_review";

    public function UserDetail($uid)
    {
        $UserDetail = User::where('unique_id',$uid)->first();
        return $UserDetail->first_name." ".$UserDetail->last_name;
    }
}
