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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('sm_name');
            $table->string('sm_company');
            $table->string('sm_link');
            $table->string('sm_user');
            $table->string('sm_password');
            $table->bigInteger('sm_status')->default(0);
            $table->bigInteger('sm_isdeleted')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
