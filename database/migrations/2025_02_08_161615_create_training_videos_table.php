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
        Schema::create('training_videos', function (Blueprint $table) {
            $table->id();
            $table->string('tv_name');
            $table->string('tv_url');
            $table->string('tv_department');
            $table->string('tv_description')->nullable();
            $table->string('l_material')->nullable();
            $table->bigInteger('status')->default(0);
            $table->bigInteger('isdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_videos');
    }
};
