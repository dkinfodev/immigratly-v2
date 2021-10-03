<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;
    protected $table = "invoice_items";

    static function deleteRecord($id){
        InvoiceItems::where("id",$id)->delete();
    }

	public function Invoice()
    {
        return $this->belongsTo('App\Models\Invoices','invoice_id','unique_id');
    }
    public function Client($id)
    {
        return $this->belongsTo('App\Models\User','client_id','unique_id');
    }

}
