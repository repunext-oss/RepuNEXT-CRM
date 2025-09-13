<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatecallcenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callcenter', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->bigInteger('Mobile');
            $table->date('Enquiry_Date');
            $table->string('Email');
            $table->string('Company_Name');
            $table->string('FollowUp',100);
            $table->date('followupdate');
            $table->string('Source');
            $table->string('Service');
            $table->string('Status');
            $table->bigInteger('c_isdeleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callcenter');
    }
}