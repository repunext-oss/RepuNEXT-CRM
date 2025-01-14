<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('employee_id')->nullable();
            $table->string('job_title')->nullable(); 
            $table->string('phone');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_image');
            $table->string('role'); 
            $table->string('level')->nullable();
            $table->string('grade')->nullable();
            $table->timestamp('doj')->nullable();
            $table->timestamp('dob')->nullable();
            $table->bigInteger('verify')->nullable();
            $table->string('honorific')->nullable();
            $table->string('status');
            $table->integer('isdeleted');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
            'name' => 'admin',
            'username' => 'admin',
            'phone' => '9876543210',
            'email' => 'admin@xyz.com',
            'email_verified_at' =>NULL,
            'password' => '$2y$10$h5XeUlsW4NmlggaaxOUFKevg47aJHsI90dv7xWYlSLxj4W/eB0zGy',
            'profile_image' => '202302200604user.jpg',
            'role' => 'Admin',
            'status' => 0,
            'isdeleted' => 0,
            'verify' => NULL,
            'remember_token' => NULL,
            'created_at' => '2022-09-26 00:28:05',
            'updated_at' => '2022-10-27 00:49:23',
            'honorific' => 'Mr.'
            ],[
                'name' => 'superadmin',
                'username' => 'superadmin',
                'phone' => '9976543210',
                'email' => 'superadmin@xyz.com',
                'email_verified_at' =>NULL,
                'password' => '$2y$10$h5XeUlsW4NmlggaaxOUFKevg47aJHsI90dv7xWYlSLxj4W/eB0zGy',
                'profile_image' => '202302200604user.jpg',
                'role' => 'Superadmin',
                'status' => 0,
                'isdeleted' => 0,
                'verify' => NULL,
                'remember_token' => NULL,
                'created_at' => '2022-09-26 00:28:05',
                'updated_at' => '2022-10-27 00:49:23',
                'honorific' => 'Mr.'
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
        Schema::dropIfExists('users');
    }
}
