<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseInvoiceItems;

class CaseInvoices extends Model
{
    use HasFactory;
    protected $table = "case_invoices";

    static function deleteRecord($id){
        $record = CaseInvoices::where("id",$id)->first();
        CaseInvoiceItems::where("case_invoice_id",$record->unique_id)->delete();
        CaseInvoices::where("id",$id)->delete();
    }

	public function Invoice()
    {
        return $this->belongsTo('App\Models\Invoices','invoice_id','unique_id');
    }
    public function InvoiceItems()
    {
        return $this->hasMany('App\Models\CaseInvoiceItems','case_invoice_id','unique_id');
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
