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
        Schema::create('tasktimesheets', function (Blueprint $table) {
            $table->id();
            $table->string('tc_name')->nullable(); 
            $table->string('tt_date')->nullable();
            $table->string('tt_cat')->nullable();
            $table->string('tt_name')->nullable();
            $table->string('tt_desc');
            $table->string('tt_starttime');
            $table->string('tt_endtime');
            $table->bigInteger('tc_status')->default(0);
            $table->bigInteger('tc_isdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasktimesheets');
    }
};
