<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\JiraTask;
use App\Models\User;

class TaskAssignedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $task;
    public $assignee;
    public $reporter;

    /**
     * Create a new message instance.
     */
    public function __construct(JiraTask $task, User $assignee, User $reporter = null)
    {
        $this->task = $task;
        $this->assignee = $assignee;
        $this->reporter = $reporter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Task Assigned: {$this->task->task_key} - {$this->task->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.task-assigned',
            with: [
                'task' => $this->task,
                'assignee' => $this->assignee,
                'reporter' => $this->reporter,
                'taskUrl' => route('jira-tasks.details', $this->task->id),
                'boardUrl' => route('jira-tasks.board'),
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