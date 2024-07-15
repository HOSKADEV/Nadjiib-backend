<?php

namespace App\Http\Controllers\API\Purchase;

use Exception;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Payment;
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
      'data' => 'json|required_if:payment_method,chargily'
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
        throw new Exception('no student selected');
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
        'status' => 'pending'
      ]);

      $purchase->apply_coupons($coupon_code, $invitation_code);

      $purchase->apply_bonuses($teacher, $invitation_code);

      $transaction = Transaction::create($request->only('account', 'data') + ['purchase_id' => $purchase->id]);

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


        $student = $purchase->student;
        $course = $purchase->course;
        $subject = $course->subject;
        $teacher = $course->teacher;

        $month = Carbon::createFromDate($purchase->created_at)->firstOfMonth()->format('Y-m-d');

        $payment_data = [
          'teacher_id' => $teacher->id,
          'date' => $month,
          'is_paid' => 'no'
        ];

        $this_month_payment = Payment::firstOrCreate($payment_data, $payment_data);

        $this_month_payment->refresh_amount();

        if ($subject->type == 'academic') {
          Subscription::create([
            'purchase_id' => $purchase->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonth()
          ]);
        }

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
}
