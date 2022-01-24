<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupVisaIds extends Model
{
    use HasFactory;

    public function VisaService()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id','unique_id');
    }

    public function VisaGroup()
    {
        return $this->belongsTo('App\Models\VisaServiceGroups','visa_group_id','unique_id')->with(["ProgramType","VisaServices"]);
    }
}
