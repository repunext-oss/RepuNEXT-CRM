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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); 
            $table->bigInteger('invoice_number');
            $table->date('date');
            $table->string('gst_number'); 
            $table->string('customer_emailid')->nullable();
            $table->string('customer_phone_number')->nullable();
            $table->string('payment_mode')->nullable();
            $table->text('address')->nullable(); 
            $table->string('customer_status')->nullable();
            $table->decimal('grandtotal_amount', 10, 2)->nullable();
            $table->string('terms_of_payment_and_delivery')->nullable();
            $table->string('month')->nullable();
            $table->integer('status')->default(0);
            $table->integer('isdeleted')->default(0);
            $table->timestamps();
        });

        Schema::create('sale_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salereferenceid');
            $table->string('product_name');
            $table->integer('quantity')->nullable();
            $table->decimal('rate', 10, 2);
            $table->integer('discount')->nullable();
            $table->decimal('cgst_amount', 10, 2)->default(0);
            $table->decimal('sgst_amount', 10, 2)->default(0);
            $table->decimal('igst_amount', 10, 2)->default(0);
            $table->integer('gst_status');
            $table->decimal('total_amount', 10, 2); 
            $table->string('month')->nullable();
            $table->integer('status')->default(0);
            $table->integer('isdeleted')->default(0);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('salereferenceid')->references('id')->on('sale_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_details');
        Schema::dropIfExists('sale_orders');
    }
};
