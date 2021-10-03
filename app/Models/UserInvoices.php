<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserInvoices extends Model
{
    use HasFactory;
    protected $table = "user_invoices";

    static function deleteRecord($id){
    	$invoice = UserInvoices::where("id",$id)->first();
    	if(!empty($invoice)){
	       InvoiceItems::where("invoice_id",$invoice->unique_id)->delete();
    	}
        UserInvoices::where("id",$id)->delete();
    }

    public function InvoiceItems()
    {
        return $this->hasMany('App\Models\InvoiceItems','invoice_id','unique_id');
    }

}
