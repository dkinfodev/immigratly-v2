<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCaseComments extends Model
{
    use HasFactory;

    public function caseComments()
    {
        return $this->hasMany('App\Models\UserCaseComments','case_id','case_id')->orderBy("id","asc");
    }
}
