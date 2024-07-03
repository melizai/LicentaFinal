<?php

namespace App\Mail;

use App\Models\Template;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplateDeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Template $template;
    public User $user;

    public function __construct(Template $template, User $user)
    {
        $this->template = $template;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Template Deadline Reminder',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deadline_reminder',
            with: [
                'template' => $this->template,
                'user' => $this->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
