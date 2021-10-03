<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageScoreChart extends Model
{
    use HasFactory;
    protected $table = "language_score_chart";

    static function deleteRecord($id){
        LanguageScoreChart::where("id",$id)->delete();
    }

}
