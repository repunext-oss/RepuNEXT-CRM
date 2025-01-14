<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->longText('role');
            $table->string('isdeleted');
            $table->timestamps();
        });


        DB::table('roles')->insert(
            [
            'role_name' => 'Admin',
            'role' => 'kt_roles_select_all',
            'isdeleted' => '0',
            'created_at' => '2022-09-26 05:55:05',
            'updated_at' =>'2022-09-26 05:55:05'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
