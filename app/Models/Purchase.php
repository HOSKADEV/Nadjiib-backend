<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Carbon;
use App\Http\Traits\uploadFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Chargily\ChargilyPay\ChargilyPay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Chargily\ChargilyPay\Auth\Credentials;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait, uploadFile;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'student_id',
    'course_id',
    'price',
    'total',
    'status',
    'payment_method',
    'reject_reason',
  ];


  public function student()
  {
    return $this->belongsTo(Student::class);
  }

  public function Course()
  {
    return $this->belongsTo(Course::class);
  }

  public function transaction()
  {
    return $this->hasOne(Transaction::class);
  }

  public function subscription()
  {
    return $this->hasOne(Subscription::class);
  }

  public function used_coupons()
  {
    return $this->hasMany(PurchaseCoupon::class);
  }

  public function coupons()
  {
    return $this->belongsToMany(Coupon::class, 'purchase_coupons');
  }

  public function bonuses()
  {
    return $this->hasMany(PurchaseBonus::class);
  }

  public function apply_coupons($coupon_code, $invitation_code)
  {

    $coupons = [];

    if ($coupon_code) {
      $percentage = $coupon_code->discount ?? 0;
      $amount = $this->price * $percentage / 100;
      array_push($coupons, [
        'purchase_id' => $this->id,
        'coupon_id' => $coupon_code->id,
        'percentage' => $percentage,
        'amount' => $amount,
        'created_at' => Carbon::now()
      ]);

      $this->total -= $amount;
    }

    if ($invitation_code) {
      $percentage = Controller::invitation_discount_amount();
      $amount = $this->price * $percentage / 100;
      array_push($coupons, [
        'purchase_id' => $this->id,
        'coupon_id' => $invitation_code->id,
        'percentage' => $percentage,
        'amount' => $amount,
        'created_at' => Carbon::now()
      ]);

      $this->total -= $amount;
    }

    PurchaseCoupon::insert($coupons);
    $this->save();

  }

  public function apply_bonuses($teacher, $invitation_code)
  {
    //$bonuses = [];
    try {
      DB::beginTransaction();

      $percentage = Controller::standard_bonus_amount();
      $amount = $this->price * $percentage / 100;

      /* array_push($bonuses,[
        'purchase_id' => $this->id,
        'percentage' => $percentage,
        'amount' => $amount,
        'type' => 1
      ]); */

      PurchaseBonus::updateOrInsert(
        [
          'purchase_id' => $this->id,
          'type' => 1
        ],
        [
          'percentage' => $percentage,
          'amount' => $amount,
          'created_at' => Carbon::now()
        ]
      );

      if ($teacher->cloud_tasks_completed()) {
        $percentage = Controller::cloud_bonus_amount();
        $amount = $this->price * $percentage / 100;

        /* array_push($bonuses,[
          'purchase_id' => $this->id,
          'percentage' => $percentage,
          'amount' => $amount,
          'type' => 2
        ]); */

        PurchaseBonus::updateOrInsert(
          [
            'purchase_id' => $this->id,
            'type' => 2,
          ],
          [
            'percentage' => $percentage,
            'amount' => $amount,
            'created_at' => Carbon::now()
          ]
        );

      }

      if ($teacher->community_tasks_completed()) {
        $percentage = Controller::community_bonus_amount();
        $amount = $this->price * $percentage / 100;

        /* array_push($bonuses,[
          'purchase_id' => $this->id,
          'percentage' => $percentage,
          'amount' => $amount,
          'type' => 3
        ]); */

        PurchaseBonus::updateOrInsert(
          [
            'purchase_id' => $this->id,
            'type' => 3
          ],
          [
            'percentage' => $percentage,
            'amount' => $amount,
            'created_at' => Carbon::now()
          ]
        );
      }

      if ($invitation_code) {
        $percentage = Controller::invitation_bonus_amount();
        $amount = $this->price * $percentage / 100;
        /* array_push($bonuses,[
          'purchase_id' => $this->id,
          'percentage' => $percentage,
          'amount' => $amount,
          'type' => 4
        ]); */

        PurchaseBonus::updateOrInsert(
          [
            'purchase_id' => $this->id,
            'type' => 4
          ],
          [
            'percentage' => $percentage,
            'amount' => $amount,
            'created_at' => Carbon::now()
          ]
        );
      }

      //PurchaseBonus::insert($bonuses);

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function apply_subscription()
  {
    $student = $this->student;
    $course = $this->course;
    $subject = $course->subject;
    $teacher = $course->teacher;



    $month = Carbon::createFromDate($this->created_at)->firstOfMonth()->format('Y-m-d');

    $payment_data = [
      'teacher_id' => $teacher->id,
      'date' => $month,
      'is_paid' => 'no'
    ];

    $this_month_payment = Payment::firstOrCreate($payment_data, $payment_data);

    $this_month_payment->refresh_amount();

    if ($subject->type == 'academic') {
      Subscription::create([
        'purchase_id' => $this->id,
        'student_id' => $student->id,
        'subject_id' => $subject->id,
        'start_date' => Carbon::now(),
        'end_date' => Carbon::now()->addMonth()
      ]);
    }
  }

  public function created_at(){
    $created_at = Carbon::createFromDate($this->created_at);
    return $created_at->format('Y-m-d H:i');
  }

  public function attempts(){
    return Purchase::where($this->only(['student_id','course_id']))->get();
  }

  public function receipt(){
    $transaction = $this->transaction;
    if($this->payment_method=='chargily' && $transaction->checkout_id && empty($transaction?->receipt) ){
      $credentials = new Credentials(json_decode(file_get_contents(base_path('chargily-pay-env.json')),true));
      $chargily_pay = new ChargilyPay($credentials);
      $checkout = $chargily_pay->checkouts()->get($transaction->checkout_id);

      if($checkout){
        $pdf = Pdf::loadView('checkout.pdf', compact('checkout'));
        $pdf->render();
        $filePath = 'documents/purchase/checkout/' . md5($transaction->checkout_id) . '.pdf';
        Storage::put($filePath, $pdf->output());
        $transaction->receipt = $filePath;
        $transaction->save();
      }



    }

    return $transaction?->receipt;
  }

  public function receipt_is(){
    $filePath = $this->transaction?->receipt;

    if(empty($filePath)){
      return null;
    }

    $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'webp'];

    if (in_array($fileExtension, $imageExtensions)){
      return 'image';
    }else{
      return $fileExtension;
    }
  }

  public function notify(){
    $student = $this->student->user;
    $teacher = $this->course->teacher->user;

      if($this->status == 'success') {
        $student ? $student->notify(
          type: 13,
          fcm: true
        ):null;
        $teacher ? $teacher->notify(
          type: 2,
          fcm: true
        ):null;
      }elseif($this->status == 'failed') {
        $student ? $student->notify(
          type: 14,
          content: $this->reject_reason,
          fcm: true
        ):null;
      }

  }
}
