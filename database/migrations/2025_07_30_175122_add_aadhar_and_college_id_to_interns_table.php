<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('interns', function (Blueprint $table) {
        $table->string('aadhar_card')->nullable(); // To store the Aadhar card file
        $table->string('college_id_card')->nullable(); // To store the College ID card file
    });
}

public function down()
{
    Schema::table('interns', function (Blueprint $table) {
        $table->dropColumn('aadhar_card');
        $table->dropColumn('college_id_card');
    });
}
};
