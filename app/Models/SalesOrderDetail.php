<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'sale_order_details';
    protected $fillable = ['salereferenceid','product_name','quantity','rate','discount','total_amount','status','isdeleted','gst_status','month'];


    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salereferenceid');
    }
}
