<?php

namespace App\Http\Controllers;

use App\Payment_Month;
use Illuminate\Http\Request;

class GetPaymentController extends Controller
{
    public function index() {
        $payments = Payment_Month::all();
        return response()->json($payments);
    }
}
