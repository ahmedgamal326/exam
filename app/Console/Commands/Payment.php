<?php

namespace App\Console\Commands;

use App\Employee;
use App\Payment_Month;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Payment every month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $employees = Employee::all();

        if(Carbon::now()->endOfMonth()->dayName == 'Friday' || Carbon::now()->endOfMonth()->dayName == 'Saturday') {
            $month = Carbon::now()->endOfMonth()->monthName;
            $day = Carbon::now()->endOfMonth()->modify('-1 day')->format('d');
        }else if (Carbon::now()->endOfMonth()->modify('-1 day') == "Friday" || Carbon::now()->endOfMonth()->modify('-1 day') == "Saturday" ){
            $day = Carbon::now()->endOfMonth()->modify('-2 day')->format('d');
        } else {
            $month = Carbon::now()->endOfMonth()->monthName;
            $day = Carbon::now()->endOfMonth()->format('d');
        }

        $salary = 0;
        $bouns_total = 0;

        foreach($employees as $employee) {
            $salary += $employee->salary;
            $bouns_total += $salary * $employee->bonus_salary / 100;
        }

        $payment_month = Payment_Month::create([
            'month' => $month,
            'salaries_payment_day' => $day,
            'bonus_payment_day' => 0,
        ]);

    }
}
