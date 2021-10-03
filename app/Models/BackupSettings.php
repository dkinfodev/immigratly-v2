<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupSettings extends Model
{
    use HasFactory;
    protected $table = "backup_settings";

    static function deleteRecord($id){
        BackupSettings::where("id",$id)->delete();
    }

}
