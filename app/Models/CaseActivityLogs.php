<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActivityLogs extends Model
{
    use HasFactory;

    static function dateWiseLogs($case_id,$date){
        $records = CaseActivityLogs::whereDate("created_at",$date)
                        ->where("case_id",$case_id)
                        ->orderBy("created_at","desc")
                        ->get();
        return $records;
    }
}
