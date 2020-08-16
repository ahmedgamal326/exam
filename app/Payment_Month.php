<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Month extends Model
{
    protected $table = 'payment_month';

    protected $fillable = [
        'month', 'salaries_payment_day', 'bonus_payment_day', 'salaries_total' , 'bonus_total' , 'payments_total'
    ];
}
