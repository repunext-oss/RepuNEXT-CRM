<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->id(); 
            $table->string('project_title');
            $table->text('project_description')->nullable();
            $table->string('project_start_date')->nullable();
            $table->string('project_end_date')->nullable();
            $table->string('project_service_category');
            $table->string('project_timeline')->nullable();
            $table->string('assigned_to_member');
            $table->string('project_priority'); 
            $table->bigInteger('project_status')->default(0);
            $table->bigInteger('project_isdeleted')->default(0);
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
        Schema::dropIfExists('project_details');
    }
}
