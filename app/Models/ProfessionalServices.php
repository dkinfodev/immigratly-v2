<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ServiceDocuments;
class ProfessionalServices extends Model
{
    use HasFactory;
    protected $table = "professional_services";

    public function Service($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("unique_id",$id)->first();
        return $service;
    }
    public function DefaultDocuments($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("unique_id",$id)->first();
        $document_ids = explode(",",$service->document_folders);
        $document_folders = DB::table(MAIN_DATABASE.".documents_folder")->whereIn("id",$document_ids)->get();
        return $document_folders;
    }
    
    public function checkIfExists($service_id){
    	$is_exists = ProfessionalServices::where("service_id",$service_id)->count();
    	return $is_exists;
    }
    
    static function deleteRecord($id){
        ServiceDocuments::where("service_id",$id);
        ProfessionalServices::where("id",$id)->delete();
    }
}
