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
        Commands\Inspire::class,
    ];

    protected function bootstrappers()
    {
        $bootstrappers = parent::bootstrappers();

        // Swap out the default Laravel ConfigureLogging class with our own.
        foreach ($bootstrappers as $key => $value) {
            if ($value == 'Illuminate\Foundation\Bootstrap\ConfigureLogging') {
                $bootstrappers[$key] = 'Delatbabel\Applog\Bootstrap\ConfigureLogging';
            }
        }

        return $bootstrappers;
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
