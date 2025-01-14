<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('host_details', function (Blueprint $table) {
            $table->id();
            $table->string('host_name'); 
            $table->string('host_username'); 
            $table->string('host_password'); 
            $table->bigInteger('h_status')->default(0);
            $table->bigInteger('h_isdeleted')->default(0);
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
        Schema::dropIfExists('host_details');
    }
}
