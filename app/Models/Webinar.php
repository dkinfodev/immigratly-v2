<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Webinar extends Model
{
    use HasFactory;
    protected $table = "webinar";

    static function deleteRecord($id){
        $article = Webinar::where("id",$id)->first();
        Webinar::where("id",$id)->delete();
        $images = $article->images;
        if($images != ''){
            $images = explode(",",$images);
            for($i=0;$i < count($images);$i++){
                if(file_exists(public_path('uploads/webinars/'.$images[$i]))){
                    unlink(public_path('uploads/webinars/'.$images[$i]));
                }
            }
        }
        WebinarTags::where("webinar_id",$id)->delete();
        WebinarTopics::where("webinar_id",$id)->delete();
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\VisaServices','category_id');
    }
    
     public function ProfessionalInfo()
    {
        return $this->belongsTo('App\Models\Professionals','professional','subdomain');
    }


    public function ProfessionalDetail($subdomain)
    {       
        $company = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_details")->first();
        return $company;
    }

    public function WebinarTags()
    {
        return $this->hasMany('App\Models\WebinarTags','webinar_id');
    }

    public function WebinarTopics()
    {
        return $this->hasMany('App\Models\WebinarTopics','webinar_id');
    }
}
