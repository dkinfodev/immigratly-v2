<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinCaseFolder extends Model
{
    use HasFactory;

    static function myDoc($folder_id)
    {
		$folder = UserFolders::where("unique_id",$folder_id)->first();
		return $folder;
    }
    static function caseDoc($folder_id,$subdomain)
    {
		$folder = \DB::table(PROFESSIONAL_DATABASE.$subdomain.".case_folders")
                    ->where("unique_id",$folder_id)
                    ->first();
		return $folder;
    }
    static function defaultDoc($folder_id)
    {
		$folder = DocumentFolder::where("unique_id",$folder_id)->first();
		return $folder;
    }
}
