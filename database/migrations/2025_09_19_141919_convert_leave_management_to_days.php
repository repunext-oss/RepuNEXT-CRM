<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert existing data from hours to days
        DB::statement('UPDATE leave_management SET 
            credit_leave = ROUND(CAST(credit_leave AS DECIMAL(10,2)) / 8, 2),
            casual_leave = ROUND(CAST(casual_leave AS DECIMAL(10,2)) / 8, 2),
            sick_leave = ROUND(CAST(sick_leave AS DECIMAL(10,2)) / 8, 2),
            taken_leave = ROUND(CAST(taken_leave AS DECIMAL(10,2)) / 8, 2)
            WHERE l_isdeleted = 0');

        // Change column types to decimal for better precision with days
        Schema::table('leave_management', function (Blueprint $table) {
            $table->decimal('credit_leave', 10, 2)->default(0)->change();
            $table->decimal('casual_leave', 10, 2)->default(0)->change();
            $table->decimal('sick_leave', 10, 2)->default(0)->change();
            $table->decimal('taken_leave', 10, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert data back from days to hours
        DB::statement('UPDATE leave_management SET 
            credit_leave = ROUND(CAST(credit_leave AS DECIMAL(10,2)) * 8, 2),
            casual_leave = ROUND(CAST(casual_leave AS DECIMAL(10,2)) * 8, 2),
            sick_leave = ROUND(CAST(sick_leave AS DECIMAL(10,2)) * 8, 2),
            taken_leave = ROUND(CAST(taken_leave AS DECIMAL(10,2)) * 8, 2)
            WHERE l_isdeleted = 0');

        // Revert column types back to original
        Schema::table('leave_management', function (Blueprint $table) {
            $table->string('credit_leave')->default(0)->change();
            $table->integer('casual_leave')->default(0)->change();
            $table->integer('sick_leave')->default(0)->change();
            $table->decimal('taken_leave')->default(0)->change();
        });
    }
};