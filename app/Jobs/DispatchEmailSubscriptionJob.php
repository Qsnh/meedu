<?php

namespace App\Jobs;

use App\Models\EmailSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DispatchEmailSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title;

    public $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $title, string $content)
    {
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
        $emails = EmailSubscription::all();
        foreach ($emails as $email) {
            dispatch(new EmailSubscriptionHandlerJob($email, $this->title, $this->content));
        }
    }
}
