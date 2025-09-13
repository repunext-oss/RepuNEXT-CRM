<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    protected $table = 'sale_orders';
    protected $fillable = ['company_name','invoice_number','date','customer_emailid','customer_phone_number','payment_mode','address','customer_status','grandtotal_amount','status','isdeleted','gst_number','terms_of_payment_and_delivery'];

    public function salesOrderDetails()
    {
        return $this->hasMany(SalesOrderDetail::class, 'salereferenceid');
    }
}
