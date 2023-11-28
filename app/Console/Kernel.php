<?php

namespace App\Console;

use App\Console\Commands\StatisticsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $outputFilePath = storage_path('logs/myLog.log');

         $schedule->command(StatisticsCommand::class)
             ->dailyAt('04:00')->withoutOverlapping()->appendOutputTo($outputFilePath);
//        $schedule->command(StatisticsCommand::class)
//            ->cron('0 */12 * * *')->withoutOverlapping()->appendOutputTo($outputFilePath);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
