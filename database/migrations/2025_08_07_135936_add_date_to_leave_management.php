<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    // Check if the column already exists, if not then add it
    if (!Schema::hasColumn('leave_management', 'date')) {
        Schema::table('leave_management', function (Blueprint $table) {
            $table->date('date')->default(\Carbon\Carbon::now()->toDateString());
        });
    }
}

public function down()
{
    Schema::table('leave_management', function (Blueprint $table) {
        // Drop the 'date' column if rolling back
        $table->dropColumn('date');
    });
}



};
