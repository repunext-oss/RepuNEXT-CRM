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
        Schema::create('jira_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_key')->unique(); 
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['task', 'bug', 'story', 'epic'])->default('task');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['backlog', 'todo', 'in_progress', 'review', 'done'])->default('backlog');
            $table->foreignId('assignee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('project_details')->onDelete('cascade');
            $table->integer('story_points')->nullable();
            $table->date('due_date')->nullable();
            $table->json('labels')->nullable();
            $table->json('attachments')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jira_tasks');
    }
};
