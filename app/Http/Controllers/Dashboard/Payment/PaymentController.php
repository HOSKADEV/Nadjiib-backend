<?php

namespace App\Http\Controllers\Dashboard\Payment;

use Exception;
use App\Models\Payment;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
  public function index(Request $request)
  {

    $date = $request->has('date') ? Carbon::createFromDate('01-' . $request->date) : Carbon::now()->subMonth();

    $payments = Payment::with('teacher')
      ->whereMonth('date', $date->month)
      ->whereYear('date', $date->year);


    if ($request->search) {
      $payments = $payments->whereHas('teacher', function ($query) use ($request) {
        $query->whereHas('user', function ($subquery) use ($request) {
          $subquery->where('name', 'like', '%' . $request->search . '%');
        });
      });
    }
    $payments = $payments->paginate(10);
    //dd($payments);

    return view('dashboard.payment.index', compact('payments', 'date'));

  }

  public function update(Request $request)
  {
    try {
      $payment = Payment::find($request->id);

      $payment_date = Carbon::createFromDate($payment->date);
      $current_date = Carbon::now();

      if ($payment_date->month == $current_date->month && $payment_date->year == $current_date->year) {
        throw new Exception(trans('message.prohibited'));
      }

      if ($request->is_paid == 'yes') {

        $payment->is_paid = $request->is_paid;
        $payment->paid_at = Carbon::now();
        $payment->save();

      }

      toastr()->success(trans('message.success.update'));
      return redirect()->back();
    } catch (Exception $e) {
      toastr()->error($e->getMessage());
      return redirect()->back();
    }
  }

  public function purchases($id, Request $request)
  {
    try {
      $payment = Payment::findOrFail($id);
      $purchases = $payment->purchases()->with('bonuses');

      if($request->search){
        $purchases->where(function($query) use ($request){
          $query->whereHas('course', function($subquery) use ($request){
            $subquery->where('name', 'like', '%'.$request->search.'%');
          });
          $query->orWhereHas('student', function($subquery) use ($request){
            $subquery->whereHas('user', function($clause) use ($request){
              $clause->where('name', 'like', '%'.$request->search.'%');
            });
        });
      });
    }
      $purchases = $purchases->paginate(10);
      return view('dashboard.payment.purchases', compact('payment','purchases'));
    } catch (Exception $e) {
      return redirect()->route('error');
    }

  }
}
