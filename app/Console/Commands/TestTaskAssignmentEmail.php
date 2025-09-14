<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JiraTask;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;

class TestTaskAssignmentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:task-email {email} {task_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test task assignment email functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $taskId = $this->argument('task_id');

        // Get a test task or create a dummy one
        if ($taskId) {
            $task = JiraTask::with(['assignee', 'reporter', 'project'])->find($taskId);
            if (!$task) {
                $this->error("Task with ID {$taskId} not found.");
                return 1;
            }
        } else {
            // Create a dummy task for testing
            $task = new JiraTask([
                'task_key' => 'TEST-001',
                'title' => 'Test Task Assignment',
                'description' => 'This is a test task to verify email functionality.',
                'type' => 'task',
                'priority' => 'high',
                'status' => 'todo',
                'story_points' => 5,
                'due_date' => now()->addDays(7),
            ]);
        }

        // Create a dummy assignee
        $assignee = new User([
            'name' => 'Test User',
            'email' => $email,
        ]);

        // Create a dummy reporter
        $reporter = new User([
            'name' => 'Task Reporter',
            'email' => 'reporter@example.com',
        ]);

        try {
            $this->info("Sending test email to: {$email}");
            Mail::to($email)->send(new TaskAssignedMail($task, $assignee, $reporter));
            $this->info("✅ Email sent successfully!");
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}