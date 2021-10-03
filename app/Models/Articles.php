<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Articles extends Model
{
    use HasFactory;
    protected $table = "articles";

    static function deleteRecord($id){
        $article = Articles::where("id",$id)->first();
        Articles::where("id",$id)->delete();
        $images = $article->images;
        if($images != ''){
            $images = explode(",",$images);
            for($i=0;$i < count($images);$i++){
                if(file_exists(public_path('uploads/articles/'.$images[$i]))){
                    unlink(public_path('uploads/articles/'.$images[$i]));
                }
            }
        }
        ArticleTags::where("article_id",$id)->delete();
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\VisaServices','category_id');
    }

    public function ProfessionalDetail($subdomain)
    {       
        $company = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_details")->first();
        return $company;
    }

    public function ArticleTags()
    {
        return $this->hasMany('App\Models\ArticleTags','article_id')->with("Tag");
    }
}
