<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('leave_management', function (Blueprint $table) {
        // Add Casual Leave (CL), Sick Leave (SL), and Permission fields
        $table->integer('casual_leave')->default(0);  // Casual leave with default value 0
        $table->integer('sick_leave')->default(0);    // Sick leave with default value 0
        $table->integer('permission')->default(0);    // Permission granted (1 = granted, 0 = not granted)
    });
}

public function down()
{
    Schema::table('leave_management', function (Blueprint $table) {
        // Drop the added fields in case of rollback
        $table->dropColumn('casual_leave');
        $table->dropColumn('sick_leave');
        $table->dropColumn('permission');
    });
}
};
