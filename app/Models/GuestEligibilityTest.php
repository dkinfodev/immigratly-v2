<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestEligibilityTest extends Model
{
    use HasFactory;

    protected $table = "guest_eligibility_test";

    public function VisaService()
    {
        return $this->belongsTo('App\Models\VisaServices','visa_service_id','unique_id');
    }
}
