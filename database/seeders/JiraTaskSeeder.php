<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JiraTask;
use App\Models\User;

class JiraTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user as reporter
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }

        // Create test tasks
        $tasks = [
            [
                'task_key' => 'TEST-1',
                'title' => 'Test Task 1 - Backlog',
                'description' => 'This is a test task in backlog for drag and drop testing.',
                'type' => 'task',
                'priority' => 'medium',
                'status' => 'backlog',
                'reporter_id' => $user->id,
                'is_active' => true,
            ],
            [
                'task_key' => 'TEST-2',
                'title' => 'Test Task 2 - Backlog',
                'description' => 'Another test task in backlog for testing drag and drop functionality.',
                'type' => 'bug',
                'priority' => 'high',
                'status' => 'backlog',
                'reporter_id' => $user->id,
                'is_active' => true,
            ],
            [
                'task_key' => 'TEST-3',
                'title' => 'Test Task 3 - Todo',
                'description' => 'A test task in todo status.',
                'type' => 'story',
                'priority' => 'low',
                'status' => 'todo',
                'reporter_id' => $user->id,
                'is_active' => true,
            ],
            [
                'task_key' => 'TEST-4',
                'title' => 'Test Task with Attachments',
                'description' => 'This task includes sample attachments to demonstrate the attachment display functionality in the modal view.',
                'type' => 'task',
                'priority' => 'medium',
                'status' => 'in_progress',
                'reporter_id' => $user->id,
                'attachments' => json_encode([
                    [
                        'name' => 'project-requirements.pdf',
                        'url' => '/upload/jira_tasks/project-requirements.pdf',
                        'size' => 1024000
                    ],
                    [
                        'name' => 'design-mockup.png',
                        'url' => '/upload/jira_tasks/design-mockup.png',
                        'size' => 512000
                    ],
                    [
                        'name' => 'technical-specs.docx',
                        'url' => '/upload/jira_tasks/technical-specs.docx',
                        'size' => 256000
                    ]
                ]),
                'comments' => 'This task includes multiple attachments for testing the modal view functionality.',
                'is_active' => true,
            ]
        ];

        foreach ($tasks as $taskData) {
            JiraTask::create($taskData);
        }

        $this->command->info('Test Jira tasks created successfully!');
    }
}
