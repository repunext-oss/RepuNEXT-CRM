<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\JiraTask;
use App\Models\User;

class TaskStatusChangedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $task;
    public $assignee;
    public $reporter;
    public $oldStatus;
    public $newStatus;
    public $changedBy;

    /**
     * Create a new message instance.
     */
    public function __construct(JiraTask $task, string $oldStatus, string $newStatus, User $assignee, User $reporter = null, User $changedBy = null)
    {
        $this->task = $task;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->assignee = $assignee;
        $this->reporter = $reporter;
        $this->changedBy = $changedBy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address($this->assignee->email, $this->assignee->name),
            ],
            subject: "Task Status Updated: {$this->task->task_key} moved to " . ucfirst(str_replace('_', ' ', $this->newStatus)),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.task-status-changed',
            with: [
                'task' => $this->task,
                'assignee' => $this->assignee,
                'reporter' => $this->reporter,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'changedBy' => $this->changedBy,
                'taskUrl' => route('jira-tasks.details', $this->task->id),
                'boardUrl' => route('jira-tasks.board'),
                'movedToTodoAt' => $this->task->moved_to_todo_at,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
