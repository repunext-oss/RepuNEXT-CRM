<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_order_proforma_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salereferenceid');
            $table->string('no');
            $table->string('product_name');
            $table->integer('quantity')->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('rate', 10, 2);
            $table->decimal('cgst_amount', 10, 2)->default(0);
            $table->decimal('sgst_amount', 10, 2)->default(0);
            $table->decimal('igst_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);   
            $table->decimal('grandtotal_amount', 10, 2)->nullable();
            $table->string('terms_of_payment_and_delivery')->nullable();
            $table->string('month')->nullable();
            $table->integer('gst_status');
            $table->integer('status')->default(0);
            $table->integer('isdeleted')->default(0);
            $table->timestamps(); 
            // Foreign key constraint to reference sale_orders table
            $table->foreign('salereferenceid')->references('id')->on('sale_orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_proforma_invoices');
    }
};
