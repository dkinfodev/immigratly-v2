<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTags extends Model
{
    use HasFactory;
    protected $table = "article_tags";

    static function deleteRecord($id){
        ArticleTags::where("id",$id)->delete();
    }

    public function Tag()
    {
        return $this->belongsTo('App\Models\Tags','tag_id');
    }  
}
