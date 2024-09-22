<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
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
    'payment_method'
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
            'type' => 2
          ],
          [
            'percentage' => $percentage,
            'amount' => $amount,
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
}
