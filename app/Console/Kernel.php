<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

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
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
                    var_dump(\App\Http\Controllers\SoapController::soapGetFunctions());
                    echo 1;
                })
                ->everyMinute()
                ->sendOutputTo('./shedule.log');
        $schedule->call(function () {
                    var_dump(\App\Http\Controllers\SoapController::soapCreateBill());
                    echo 2;
                })
                ->everyMinute()
                ->sendOutputTo('./shedule.log');
        $schedule->call(function () {
                    var_dump(\App\Http\Controllers\SoapController::soapCreateBillResponse());
                    echo 3;
                })
                ->everyMinute()
                ->sendOutputTo('./shedule.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
