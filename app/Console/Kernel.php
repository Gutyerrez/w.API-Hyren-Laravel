<?php

namespace App\Console;

use App\Models\AccessToken;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [ ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $currentTime = new DateTime();

            AccessToken::where('due_at', '<', $currentTime)
                ->delete();
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
