<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('tool_name'); 
            $table->bigInteger('tooltype_id');
            $table->string('link');
            $table->string('link_to_sm');
            $table->string('user');
            $table->string('password');
            $table->bigInteger('tc_status')->default(0);
            $table->bigInteger('tc_isdeleted')->default(0);
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
        Schema::dropIfExists('tools_credentials');
    }
}
