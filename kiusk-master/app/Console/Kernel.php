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
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('telescope:prune --hours 1')->hourly();
        $schedule->command('sitemap:generate')->daily();
        // $schedule->command('report:daily')->everyMinute();
        $schedule->command('report:daily')->dailyAt('22:00');
        $schedule->command('send:subscription-warnings')->daily();

        // Schedule the command to run weekly on Mondays at 9:00 AM
        $schedule->command('reports:send')->weekly();
        // $schedule->command('reports:send')->everyTwoMinutes();

        // Schedule the command to run monthly on the 1st day of the month at 10:00 AM
        // $schedule->command('reports:send')->everyMinute();
        $schedule->command('reports:send')->monthly();

        $schedule->command('email:send-unread-messages')->everyTenMinutes();

        $schedule->command('report:admin daily')->dailyAt('23:59');
        $schedule->command('report:admin weekly')->weekly()->at('23:59');
        $schedule->command('report:admin monthly')->monthly()->at('23:59');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'America/Toronto';
    }
}
