<?php

namespace App\Console;

use App\Console\Commands\Payment;
use App\Console\Commands\Bonus;
use Carbon\Carbon;
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
        \App\Console\Commands\Payment::class,
        \App\Console\Commands\Bonus::class,
        \App\Console\Commands\Notify::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        if(Carbon::now()->endOfMonth()->dayName == 'Friday' || Carbon::now()->endOfMonth()->dayName == 'Saturday') {
        
            $date = Carbon::now()->endOfMonth()->modify('-1 day')->format('y-m-d');

            $paysend = Carbon::now()->endOfMonth()->modify('-3 day')->format('y-m-d');

        if(Carbon::now()->endOfMonth()->modify('-1 day')->dayName == 'Friday' || Carbon::now()->endOfMonth()->modify('-1 day')->dayName == 'Saturday') {
             $date = Carbon::now()->endOfMonth()->modify('-2 day')->format('d');
             $paysend = Carbon::now()->endOfMonth()->modify('-3 day')->format('y-m-d');
        } 

        } else {
            $date = Carbon::now()->endOfMonth()->format('y-m-d');
            $paysend = Carbon::now()->endOfMonth()->modify('-2 day')->format('y-m-d');
        }
/*
        $schedule->command('admin:payment')->everyMinute();
*/
        $schedule->command('admin:payment')->when(function () use ($date) {
            return (
                $date
            );
        });

        $schedule->command('notify:email')->when(function () use ($paysend) {
            return (
                $paysend
            );
        });

        if(Carbon::today()->endOfMonth()->format('d') == 31 ) {
            $date = Carbon::today()->endOfMonth()->modify('-16 day')->dayName;   
    
            if($date == "Friday" || $date == "Saturday") {
               $date =  Carbon::today()->endOfMonth()->modify('-16 day')->modify("thursday")->format('d-m-y');
            }
    
       } else if(Carbon::today()->endOfMonth()->format('d') == 30) {
            $date = Carbon::today()->endOfMonth()->modify('-15 day')->dayName; 
            if($date == "Friday" || $date == "Saturday") {
               $date =  Carbon::today()->endOfMonth()->modify('-16 day')->modify("thursday")->format('d-m-y');
            }
       } else if(Carbon::today()->endOfMonth()->format('d') == 28) {
            $date = Carbon::today()->endOfMonth()->modify('-13 day')->dayName; 
            if($date == "Friday" || $date == "Saturday") {
               $date =  Carbon::today()->endOfMonth()->modify('-16 day')->modify("thursday")->format('d-m-y');
            }
       }

       
       $schedule->command('bonus:payment')->when(function () use ($date) {
        return (
            $date
        );
    });
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
