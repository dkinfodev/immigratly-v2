<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseInvoices;

class Invoices extends Model
{
    use HasFactory;
    protected $table = "invoices";

    static function deleteRecord($id){
    	$invoice = Invoices::with('CaseInvoice')->where("id",$id)->first();
    	if(!empty($invoice)){
	    	if($invoice->link_to == 'case'){
	    		CaseInvoices::deleteRecord($invoice->CaseInvoice->id);
	    	}
	        Invoices::where("id",$id)->delete();
    	}
    }

    public function CaseInvoice()
    {
        return $this->hasOne('App\Models\CaseInvoices','invoice_id','unique_id')->with("InvoiceItems");
    }

}
