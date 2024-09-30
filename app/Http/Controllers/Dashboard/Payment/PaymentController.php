<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index(Request $request){

      if($request->has('date'));
      $payments = Payment::all();
      dd($payments);
    }
}
