<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function fetchPaymentOptions(Request $request)
    {
        $pay = Payment::where('fund_id',$request['id'])->first();
        return $pay;
    }
}
