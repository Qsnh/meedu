<?php

namespace App\Jobs;

use App\Mail\EmailSubscriptionEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailSubscriptionHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    public $title;

    public $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email, string $title, string $content)
    {
        $this->email = $email;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new EmailSubscriptionEmail($this->title, $this->content));
    }
}
