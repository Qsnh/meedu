<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;

    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('emails.email_subscription', [
                'content' => $this->content,
            ]);
    }
}
