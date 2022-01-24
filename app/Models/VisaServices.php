<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\DocumentFolder;

class VisaServices extends Model
{
    use HasFactory;
    protected $table = "visa_services";

    public function SubServices()
    {
        return $this->hasMany('App\Models\VisaServices','parent_id');
    }

    public function Articles()
    {
        return $this->hasMany('App\Models\Articles','category_id');
    }

    public function Webinars()
    {
        return $this->hasMany('App\Models\Webinar','category_id');
    }

    public function DocumentFolders($id)
    {
        $visa_service = VisaServices::where("id",$id)->first();
        
        if($visa_service->document_folders != ''){
            $document_folder = explode(",",$visa_service->document_folders);
            
            $document_folders = DocumentFolder::whereIn("id",$document_folder)->get();    
        }else{
            $document_folders = array();
        }
        
        return $document_folders;
    }
    
    public function CvTypeDetail()
    {
        return $this->belongsTo('App\Models\CvTypes','cv_type');
    }

    public function CutoffPoints()
    {
        return $this->hasMany('App\Models\VisaServiceCutoff','visa_service_id','unique_id')
                ->orderBy("cutoff_date", "desc");
    }

    public function ArrangeQuestions()
    {
        return $this->hasMany('App\Models\ArrangeQuestions','visa_service_id','unique_id');
    }

    public function EligibilityQuestions()
    {
        return $this->hasMany('App\Models\EligibilityQuestions','visa_service_id','unique_id');
    }
    public function visaGroup()
    {
        return $this->hasOne('App\Models\GroupVisaIds','visa_service_id','unique_id')->with("VisaGroup");
    }
    static function deleteRecord($id){
        $visa_service = VisaServices::where("id",$id)->first();
        if(!empty($visa_service)){
            ArrangeQuestions::where("visa_service_id",$visa_service->unqiue_id)->delete();
            EligibilityQuestions::where("visa_service_id",$visa_service->unqiue_id)->delete();
            VisaServices::where("id",$id)->delete();
            VisaServices::where("parent_id",$id)->delete();
        }
    }
}
