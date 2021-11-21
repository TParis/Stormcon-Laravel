<?php

namespace App\Console;

use App\Http\Controllers\InspectionController;
use App\Http\Controllers\InspectionScheduleController;
use App\Http\Controllers\ProjectController;
use App\Models\InspectionSchedule;
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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            InspectionController::updateWeeklySchedule();
        })->dailyAt("2:00")->name("weekly-schedule")->withoutOverlapping();

        $schedule->call(function() {
            ProjectController::LandDevelopmentNOISignerReport();
        })->dailyAt("2:00")->name("noi-signer-report")->withoutOverlapping();
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
