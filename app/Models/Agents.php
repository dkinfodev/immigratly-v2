<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Agents extends Authenticatable
{
    use HasFactory;

    protected $table = 'agents';

    static function deleteRecord($id){
        Agents::where("id",$id)->delete();   
    }
}
