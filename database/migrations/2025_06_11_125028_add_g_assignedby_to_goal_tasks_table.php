<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('goal_tasks', function (Blueprint $table) {
             $table->string('g_assignedby', 255)->nullable()->after('g_assigned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goal_tasks', function (Blueprint $table) {
             $table->dropColumn('g_assignedby');
        });
    }
};
