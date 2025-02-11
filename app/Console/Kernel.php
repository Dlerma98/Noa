<?php

namespace App\Console;

use App\Console\Commands\ListRecentPosts;
use App\Console\Commands\ResendPostEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        ResendPostEmails::class,
        ListRecentPosts::class,
    ];
}
