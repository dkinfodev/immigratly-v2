<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePrivilegesActions extends Model
{
    use HasFactory;
    protected $table = "employee_modules_action";

    static function deleteRecord($id){
        EmployeePrivilegesAction::where("id",$id)->delete();
    }
}
