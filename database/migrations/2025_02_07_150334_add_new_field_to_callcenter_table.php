<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('callcenter', function (Blueprint $table) {
            $table->string('mobile2')->nullable();
            $table->string('followup1')->nullable();
            $table->string('followup2')->nullable();
            $table->string('followup3')->nullable();
            $table->string('location')->nullable();
            $table->string('Area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('callcenter', function (Blueprint $table) {
            $table->dropColumn(['mobile2', 'followup1', 'followup2', 'followup3', 'location', 'Area']);

            $table->string('followup')->nullable();
            $table->date('followup_date')->nullable();
        });
    }
};
