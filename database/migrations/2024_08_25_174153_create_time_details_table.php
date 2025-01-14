<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_ref_id');
            $table->string('task_name');
            $table->string('task_date');
            $table->bigInteger('task_assigned');
            $table->string('task_start_time')->nullable();
            $table->string('task_end_time')->nullable();
            $table->string('task_description')->nullable();
            $table->bigInteger('task_status')->default(0);
            $table->bigInteger('task_isdeleted')->default(0);
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
        Schema::dropIfExists('time_details');
    }
}
