<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupConditionalQuestions extends Model
{
    use HasFactory;

    public function Group()
    {
        return $this->belongsTo('App\Models\QuestionsGroups','group_id','unique_id');
    }
}
