<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePrivileges extends Model
{
    use HasFactory;
    protected $table = "employee_privileges";

    static function deleteRecord($id){
        EmployeePrivileges::where("id",$id)->delete();
        EmployeePrivilegesAction::where("module_id",$id)->delete();
    }

    public function Actions()
    {
        return $this->hasMany('App\Models\EmployeePrivilegesActions','module_id');
    }
}
