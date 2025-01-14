<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitecredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websitecredentials', function (Blueprint $table) {
            $table->id();
            $table->string('Website');
            $table->string('URL');
            $table->string('User_Name');
            $table->string('Password');
            $table->string('CMS');
            $table->date('Completion_Date');
            $table->date('Next_Renewal_Date');
            $table->string('Client_Contact1',100);
            $table->string('Client_Contact2',100);
            $table->string('Month');
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
        Schema::dropIfExists('websitecredentials');
    }
}
