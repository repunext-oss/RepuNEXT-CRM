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
        Schema::create('goal_sheet_categories', function (Blueprint $table) {
            $table->id();
            $table->string('gc_name')->nullable();
            $table->bigInteger('gc_status')->default(0);
            $table->bigInteger('gc_isdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_sheet_categories');
    }
};
