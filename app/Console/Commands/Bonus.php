<?php

namespace App\Console\Commands;

use App\Employee;
use App\Payment_Month;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Bonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $salary = 0;
        $bouns_total = 0;

        foreach($employees as $employee) {
            $salary += $employee->salary;
            $bouns_total += $salary * $employee->bonus_salary / 100;
        }

        /*
            if(Carbon::endOfMonth()->format('d') == 31 ) {
                $date = Carbon::endOfMonth()->modify('-16 day')->dayName;   
                if($date == "Friday" || $date == "Saturday") {
                $date =  Carbon::endOfMonth()->modify('-16 day')->modify("thursday")->format('d');
                }

            } else if(Carbon::endOfMonth()->format('d') == 30) {
                $date = Carbon::endOfMonth()->modify('-15 day')->dayName; 
                if($date == "Friday" || $date == "Saturday") {
                $date =  Carbon::today()->endOfMonth()->modify('-16 day')->modify("thursday")->format('d');
                }
            } else if(Carbon::endOfMonth()->format('d') == 28) {
                $date = Carbon::endOfMonth()->modify('-13 day')->dayName; 
                if($date == "Friday" || $date == "Saturday") {
                $date =  Carbon::endOfMonth()->modify('-16 day')->modify("thursday")->format('d');
                }
            }
*/
        $payment_month = Payment_Month::where('bonus_payment_day', 0)->update([
            'bonus_payment_day' => 15,
            'salaries_total' => $salary,
            'bonus_total' => $bouns_total,
            'payments_total' => $salary + $bouns_total,
        ]);
    }
}
