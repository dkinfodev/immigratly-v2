<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPrivileges extends Model
{
    use HasFactory;
    protected $table = "staff_privileges";

    static function deleteRecord($id){
        StaffPrivileges::where("id",$id)->delete();
    }

    public function Actions()
    {
        return $this->hasMany('App\Models\EmployeePrivilegesActions','module_id');
    }
}
