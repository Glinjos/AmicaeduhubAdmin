<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        \App\Console\Commands\ExecuteExamQuery::class,
        \App\Console\Commands\ExecuteExamExpiredQuery::class,
        \App\Console\Commands\AppPlanExpired::class,
        \App\Console\Commands\AppDailyExamNotify::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('exam:active-daily')->everyMinute();

        $schedule->command('exam:expired-daily')->everyMinute();
        
        $schedule->command('AppPlan:Expired-daily')->everyMinute();
         
        $schedule->command('dailyExam:app-notify')->everyMinute(); 
        
        
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
