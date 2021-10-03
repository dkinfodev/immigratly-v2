<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionalQuestions extends Model
{
    use HasFactory;

    public function GroupComponentIds()
    {
        return $this->belongsTo('App\Models\GroupComponentIds','component_id','component_id')->with("QuestionsGroups");
    }
}
