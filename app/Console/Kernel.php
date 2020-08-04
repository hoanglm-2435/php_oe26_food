<?php

namespace App\Console;

use App\Console\Commands\PromotionsCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        PromotionsCron::class
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('cron:promotions')
             ->weeklyOn(
                 config('scheduling_job.day_of_week'),
                 config('scheduling_job.hours_of_day')
             );
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
