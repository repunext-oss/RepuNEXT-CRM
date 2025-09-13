<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderProformaInvoice extends Model
{
    use HasFactory;
    protected $table = 'sale_order_proforma_invoices';
    protected $fillable = ['salereferenceid','no','product_name','quantity','rate','discount','total_amount','status','isdeleted','gst_status','month','terms_of_payment_and_delivery','grandtotal_amount'];


    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salereferenceid');
    }
}
