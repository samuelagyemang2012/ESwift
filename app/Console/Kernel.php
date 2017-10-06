<?php

namespace App\Console;

use App\Sms;
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
        //
        'App\Console\Commands\BeforeHalfElapsed',
        'App\Console\Commands\HalfElapsed',
        'App\Console\Commands\BeforeFullElapsed',
        'App\Console\Commands\FullElapsed'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('beforehalfelapsed')
            ->dailyAt('9:00');

        $schedule->command('halfelapsed')
            ->dailyAt('9:00');

        $schedule->command('beforefullelapsed')
            ->dailyAt('9:00');

        $schedule->command('fullelapsed')
            ->dailyAt('9:00');

//        $schedule->call(function () {
//            $s = new Sms();
//            $s->send("233542688902", "scheduler test");
//        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
