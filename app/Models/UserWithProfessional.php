<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithProfessional extends Model
{
    use HasFactory;
    protected $table = 'user_with_professional';

    // public function Cases($subdomain,$client_id)
    // {
    //     $cases = DB::table(PROFESSIONAL_DATABASE.$subdomain.".cases")->where("client_id",$client_id)->get();
    //     return $cases;
    // }

    public function Cases($subdomain,$client_id){
    	$data['client_id'] = $client_id;
    	$cases = professionalCurl("cases",$subdomain,$data);
    	return $cases;
    }
    public function Professional($subdomain)
    {
        $personal = DB::table(PROFESSIONAL_DATABASE.$subdomain.".users")->where("role","admin")->first();
        $company = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_details")->first();
        $data['personal'] = $personal;
        $data['company'] = $company;
        return $data;
    }

    public function CompanyDetail($subdomain)
    {
        $data = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_details")->first();
        return $data;
    }
}
