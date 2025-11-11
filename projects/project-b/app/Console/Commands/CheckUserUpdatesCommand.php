<?php

namespace App\Console\Commands;

use App\Jobs\SendUserNotificationJob;
use App\Models\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckUserUpdatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-user-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Checking for user profile updates...");

        $profiles = Profile::where(
            'updated_at',
            '<',
            now()->subDay()
        )->get();

        foreach ($profiles as $profile) {
            SendUserNotificationJob::dispatch(
                $profile,
                'Notifikasi Perubahan Data',
                "Halo {$profile->username},\nData Anda sudah lebih dari 1 hari tidak diperbarui."
            );
        }
    }
}
