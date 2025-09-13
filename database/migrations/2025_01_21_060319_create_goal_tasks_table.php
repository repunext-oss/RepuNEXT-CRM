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
        Schema::create('goal_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('g_taskname'); 
            $table->bigInteger('g_category');
            $table->string('g_description');
            $table->string('g_deadline');
            $table->string('g_realenddate')->nullable();
            $table->string('g_priority');
            $table->string('g_assigned', 255)->nullable();
            $table->string('timer');
            $table->string('g_status')->default(0);
            $table->string('running_time')->default('0');
            $table->bigInteger('g_isdeleted')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_tasks');
    }
};
