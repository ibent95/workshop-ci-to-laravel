<?php

namespace App\Jobs;

use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $profile;
    public $subject;
    public $body;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Profile $profile,
        string $subject,
        string $body,
    ) {
        $this->profile = $profile;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Sending notification to user: {$this->profile->email}");

        Mail::raw(
            $this->body,
            function ($message) {
                $message->to($this->profile->email)
                    ->subject($this->subject);
            }
        );
    }
}
