<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('empolyeecode');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('location');
            $table->string('dateofbirth');
            $table->string('position');
            $table->string('reportto');
            $table->string('status');
            $table->bigInteger('verify')->nullable();
            $table->integer('isdeleted');
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
        Schema::dropIfExists('users');
    }
}
