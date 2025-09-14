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
        Schema::table('jira_tasks', function (Blueprint $table) {
            $table->timestamp('moved_to_todo_at')->nullable();
            $table->timestamp('moved_to_done_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jira_tasks', function (Blueprint $table) {
            $table->dropColumn(['moved_to_todo_at', 'moved_to_done_at']);
        });
    }
};
