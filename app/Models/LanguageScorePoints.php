<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageScorePoints extends Model
{
    use HasFactory;

    public function LanguageProficiency()
    {
        return $this->belongsTo('App\Models\LanguageProficiency','language_proficiency_id','unique_id');
    }
}
