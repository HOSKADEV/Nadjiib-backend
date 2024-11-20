<?php

namespace App\Http\Controllers\API\Purchase;

use Exception;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Purchase;
use App\Rules\ValidCoupon;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Traits\uploadFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{

  use uploadFile;
  public function create(Request $request)
  {

    $validation = Validator::make($request->all(), [
      'course_id' => 'required|exists:courses,id',
      'coupon_code' => ['sometimes', 'exists:coupons,code', new ValidCoupon($request)],
      'invitation_code' => ['sometimes', 'exists:coupons,code', new ValidCoupon($request)],
      'payment_method' => 'required|in:baridimob,poste,chargily',
      'account' => 'required_if:payment_method,baridimob',
      'receipt' => 'required_if:payment_method,baridimob|required_if:payment_method,poste',
      'checkout_id' => 'required_if:payment_method,chargily|string|unique:transactions'
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

      $student = $user?->student;

      $course = Course::findOrFail($request->course_id);

      if (empty($student)) {
        throw new Exception('no student found');
      }

      if ($student->purchased($course)) {
        throw new Exception('already purchased');
      }

      $coupon_code = Coupon::where('code', $request->coupon_code)->first();

      $invitation_code = Coupon::where('code', $request->invitation_code)->first();

      $teacher = $course->teacher;

      DB::beginTransaction();

      $purchase = Purchase::create([
        'student_id' => $student->id,
        'course_id' => $course->id,
        'price' => $course->price,
        'total' => $course->price,
        'status' => 'pending',
        'payment_method' => $request->payment_method
      ]);

      $purchase->apply_coupons($coupon_code, $invitation_code);

      $purchase->apply_bonuses($teacher, $invitation_code);

      $transaction = Transaction::create($request->only('account', 'checkout_id') + ['purchase_id' => $purchase->id]);

      if ($request->hasFile('receipt')) {
        $path = $this->SaveDocument($request->receipt, 'documents/purchase/receipt/');
        $transaction->receipt = $path->getPathName();
        $transaction->save();
      }

      DB::commit();

      return response()->json([
        'status' => true,
        'message' => 'success'
      ]);

    } catch (Exception $e) {
      DB::rollback();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }


  public function update(Request $request)
  {

    $validation = Validator::make($request->all(), [
      'purchase_id' => 'required|exists:purchases,id',
      'status' => 'required|in:failed,success'
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

      DB::beginTransaction();

      $purchase = Purchase::find($request->purchase_id);
      $purchase->status = $request->status;
      $purchase->save();

      if ($request->status == 'success') {

        $purchase->apply_subscription();

      }

      DB::commit();

      return response()->json([
        'status' => true,
        'message' => 'success'
      ]);
    } catch (Exception $e) {
      DB::rollback();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function chargily(Request $request)
  {
    try {
      //dd(empty($request->checkout_id));

      if (empty($request->checkout_id)) {
        throw new Exception('no checkout id');
      }


      $credentials = new \Chargily\ChargilyPay\Auth\Credentials(json_decode(file_get_contents(base_path('chargily-pay-env.json')), true));
      $chargily_pay = new \Chargily\ChargilyPay\ChargilyPay($credentials);
      $checkout = $chargily_pay->checkouts()->get($request->checkout_id);

      if (empty($checkout)) {
        throw new Exception('invalid checkout id');
      }

      $transaction = Transaction::where('checkout_id', $checkout->getId())->first();

      if (empty($transaction)) {
        throw new Exception('no transaction found');
      }

      $purchase = $transaction->purchase;

      if($purchase->status != 'pending'){
        throw new Exception('purchase already settled');
      }

      $diff_customer = $purchase->student->user->customer_id != $checkout->getCustomerId();

      $diff_course = $purchase->course_id != $checkout->getMetadata()[0]['course_id'];

      //dd($checkout);

      if ($diff_customer || $diff_course) {
        throw new Exception('conflicted informations');
      }


      /*     if($checkout->getStatus() != 'success'){
            throw new Exception('checkout is not success');
          } */

      if ($request->routeIs('chargily-failed')) {

        $purchase->status = 'failed';
        $purchase->save();

        return redirect()->route('purchase-failed');

      } else {

        DB::beginTransaction();

        $purchase->status = 'success';
        $purchase->save();
        $purchase->apply_subscription();

        DB::commit();

        return redirect()->route('purchase-success');

      }


    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
      return redirect()->route('error');
    }
  }

  public function success(){
    return view('content.purchase.success');
  }

  public function failed(){
    $number = Setting::where('name', 'whatsapp')->value('value');
    return view('content.purchase.failed')->with('number', $number);
  }

}
