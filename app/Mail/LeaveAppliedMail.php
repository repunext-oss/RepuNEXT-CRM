<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveAppliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

     public function build()
    {
        $fromAddress = config('mail.from.address');
        $fromName    = config('mail.from.name');

        return $this->subject($this->details['subject'])
                    ->from($fromAddress, $fromName)
                    ->replyTo($this->details['user_email'] ?? $fromAddress, $this->details['username'] ?? $fromName)
                    ->to('aravindkumar@repunext.com')
                    ->view('emails.leave_applied')
                    ->with('details', $this->details);
    }
}
