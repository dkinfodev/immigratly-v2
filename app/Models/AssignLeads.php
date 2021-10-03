<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class AssignLeads extends Model
{
    use HasFactory;
    protected $table = "assign_leads";

    public function Member()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }

    static function deleteRecord($id){
        AssignLeads::where("id",$id)->delete();
    }
}
