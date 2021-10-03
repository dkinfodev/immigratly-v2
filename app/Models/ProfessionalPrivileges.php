<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalPrivileges extends Model
{
    use HasFactory;
    protected $table = "professional_privileges";

    static function deleteRecord($id){
        ProfessionalPrivileges::where("id",$id)->delete();
    }

    public function Actions()
    {
        return $this->hasMany('App\Models\PrivilegesActions','module_id');
    }
}
