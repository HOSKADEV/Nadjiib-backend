<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Models\Payment;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index(Request $request){

      $date = $request->has('date') ? Carbon::createFromDate('01-'.$request->date) : Carbon::now();

      $payments = Payment::with('teacher')
              ->whereMonth('date', $date->month)
              ->whereYear('date', $date->year)

    ->get();
    //dd($payments);

    return view('dashboard.payment.index', compact('payments', 'date'));

    }
}
