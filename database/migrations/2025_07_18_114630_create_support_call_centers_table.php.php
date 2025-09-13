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
        Schema::create('support_call_centers', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('Name');
            $table->bigInteger('Mobile');
            $table->date('Enquiry_Date');
            $table->string('Email')->nullable();
            $table->string('Company_Name')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('Describe')->nullable();
            $table->string('location')->nullable();
            $table->string('Area')->nullable();
            $table->string('Source');
            $table->string('Service');
            $table->string('Status');
            $table->bigInteger('s_isdeleted')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_call_centers');
    }
};
