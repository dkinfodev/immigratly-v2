<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseTeams extends Model
{
    use HasFactory;
    protected $table = "case_teams";

    public function Member()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }

    static function deleteRecord($id){
        CaseTeams::where("id",$id)->delete();
    }

    public function Staff()
    {
        return $this->belongsTo('App\Models\User','user_id','unique_id');
    }
}
