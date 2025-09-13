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
        Schema::create('sub_domain_details', function (Blueprint $table) {
            $table->id();
            $table->string('subdomain_name'); 
            $table->bigInteger('host_id');
            $table->string('type');     
            $table->string('backend_user'); 
            $table->string('backend_password');
            $table->bigInteger('domain_status')->default(0);
            $table->bigInteger('domain_isdeleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_domain_details');
    }
};
