<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageProficiency extends Model
{
    use HasFactory;
    protected $table = "language_proficiency";

    static function deleteRecord($id){
        LanguageProficiency::where("id",$id)->delete();
    }

    public function ClbLevels()
    {
        return $this->hasMany('App\Models\LanguageScoreChart','language_proficiency_id','unique_id')->orderBy("clb_level","asc");
    }
    public function ScoreCharts()
    {
        return $this->hasMany('App\Models\LanguageScoreChart','language_proficiency_id','unique_id')->orderBy("clb_level","desc");
    }
   
    public function OffLang()
    {
        return $this->belongsTo('App\Models\OfficialLanguages','official_language','unique_id');
    }
    
}
