<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInvoiceItems extends Model
{
    use HasFactory;
    protected $table = "case_invoice_items";

    static function deleteRecord($id){
        CaseInvoiceItems::where("id",$id)->delete();
    }

	public function CaseInvoice()
    {
        return $this->belongsTo('App\Models\CaseInvoices','case_invoice_id','unique_id');
    }

    public function Case()
    {
        return $this->belongsTo('App\Models\Cases','case_id','unique_id');
    }

    public function Client($id)
    {
        $data = DB::table(MAIN_DATABASE.".users")->where("unique_id",$id)->first();
        return $data;
    }

}
