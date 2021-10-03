<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalPanel extends Model
{
    protected $table = "professional_panel";

    public function Professional()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
