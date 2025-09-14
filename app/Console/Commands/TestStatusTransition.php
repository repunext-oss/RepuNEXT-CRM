<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JiraTask;

class TestStatusTransition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:status-transition {taskId} {newStatus}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test status transition tracking for Jira tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $taskId = $this->argument('taskId');
        $newStatus = $this->argument('newStatus');

        try {
            $task = JiraTask::findOrFail($taskId);
            
            $this->info("Current Task Details:");
            $this->info("Task ID: {$task->id}");
            $this->info("Title: {$task->title}");
            $this->info("Current Status: {$task->status}");
            $this->info("Moved to Todo At: " . ($task->moved_to_todo_at ? $task->moved_to_todo_at->format('Y-m-d H:i:s') : 'Not set'));
            $this->info("Moved to Done At: " . ($task->moved_to_done_at ? $task->moved_to_done_at->format('Y-m-d H:i:s') : 'Not set'));
            
            $oldStatus = $task->status;
            
            // Track status transition dates
            if ($oldStatus !== $newStatus) {
                // Track when moved to todo
                if ($newStatus === 'todo' && $oldStatus !== 'todo') {
                    $task->moved_to_todo_at = now();
                    $this->info("Setting moved_to_todo_at to: " . now()->format('Y-m-d H:i:s'));
                }
                
                // Track when moved to done
                if ($newStatus === 'done' && $oldStatus !== 'done') {
                    $task->moved_to_done_at = now();
                    $this->info("Setting moved_to_done_at to: " . now()->format('Y-m-d H:i:s'));
                }
            }
            
            $task->status = $newStatus;
            $task->save();
            
            $this->info("\nStatus updated successfully!");
            $this->info("New Status: {$task->status}");
            $this->info("Moved to Todo At: " . ($task->moved_to_todo_at ? $task->moved_to_todo_at->format('Y-m-d H:i:s') : 'Not set'));
            $this->info("Moved to Done At: " . ($task->moved_to_done_at ? $task->moved_to_done_at->format('Y-m-d H:i:s') : 'Not set'));
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}