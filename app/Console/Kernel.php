<?php

namespace App\Console;

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
        \App\Console\Commands\TestConsole::class,
        \App\Console\Commands\Qxc::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('test:name user1 --queue=default')
                 ->everyFiveMinutes()
                 ->sendOutputTo('/home/www/gitos/crontest');

        $schedule->command('Qxc')->everyMinute();
    }
}