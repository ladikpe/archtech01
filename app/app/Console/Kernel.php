<?php

namespace App\Console;

use App\Console\Commands\AnniversaryNotification;
use App\Console\Commands\NotifyAdminProbation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AnniversaryNotification::class,
        NotifyAdminProbation::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('send:probationreminder')
                  ->everyMinute()->withoutOverlapping();
        $schedule->command('send:reminder')
                ->everyMinute()->withoutOverlapping();
        $schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
