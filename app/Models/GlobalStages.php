<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalStages extends Model
{
    use HasFactory;

    public function SubStages()
    {
        return $this->hasMany('App\Models\GlobalSubStages','stage_id','unique_id');
    }
}
