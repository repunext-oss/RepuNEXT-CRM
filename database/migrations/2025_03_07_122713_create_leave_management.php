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
        Schema::create('leave_management', function (Blueprint $table) {
            $table->id();
            $table->string('user_ref_id'); 
            $table->string('date');
            $table->decimal('taken_leave')->default(0); 
            $table->string('credit_leave')->default(0);
            $table->bigInteger('l_status')->default(0);
            $table->bigInteger('l_isdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_management');
    }
};
