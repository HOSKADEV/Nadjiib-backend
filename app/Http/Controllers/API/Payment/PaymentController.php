<?php

namespace App\Http\Controllers\API\Payment;

use Exception;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Payment\PaymentCollection;
use App\Http\Resources\Purchase\PurchaseCollection;
use App\Http\Resources\Payment\PaginatedPaymentCollection;

class PaymentController extends Controller
{
    public function get(Request $request){
      $validation = Validator::make($request->all(), [
        'year' => 'required|integer'
      ]);

      if ($validation->fails()) {
        return response()->json([
          'status' => false,
          'message' => $validation->errors()->first(),
          //'message' => 'Invalid coupon',
          //'errors' => $validation->errors()
        ], 422);
      }

      try {
        $user = $request->user();
        $teacher = $user?->teacher;

        if (empty($teacher)) {
          throw new Exception('no teacher selected');
        }

        $payments = $teacher->payments()->where(DB::raw('YEAR(date)'),$request->year)->orderBy('date','DESC')->paginate(10);

        return response()->json([
          'status' => true,
          'message' => 'success',
          'data' => new PaginatedPaymentCollection($payments),
        ]);

      } catch (Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => false,
          'message' => $e->getMessage()
        ]);
      }
    }

    public function info(Request $request){
      $validation = Validator::make($request->all(), [
        'payment_id' => 'required|exists:payments,id'
      ]);

      if ($validation->fails()) {
        return response()->json([
          'status' => false,
          'message' => $validation->errors()->first(),
          //'message' => 'Invalid coupon',
          //'errors' => $validation->errors()
        ], 422);
      }

      try {

        $payment = Payment::find($request->payment_id);
        $teacher = $payment->teacher;

        $start_date = Carbon::createFromDate($payment->date)->firstOfMonth();
        $end_date = Carbon::createFromDate($payment->date)->lastOfMonth();

        $purchases = $teacher->purchases()
                             ->whereBetween('purchases.created_at',[$start_date,$end_date])
                             ->where('purchases.status', 'success')
                             ->get();

        return response()->json([
          'status' => true,
          'message' => 'success',
          'data' => new PurchaseCollection($purchases)
        ]);

      } catch (Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => false,
          'message' => $e->getMessage()
        ]);
      }
    }
}
