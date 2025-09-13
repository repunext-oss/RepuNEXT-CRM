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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('startdate')->default(0);
            $table->string('enddate')->default(0);
            $table->string('reason')->default(0);
            $table->string('totaldays')->default(0);
            $table->string('leave_type');
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
        Schema::dropIfExists('leaves');
    }
};
