<?php

namespace App\Models;

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

    public function apply_coupons($coupon_code,$invitation_code){

      $coupons = [];

      if($coupon_code){
        $percentage = $coupon_code->discount?? 0;
        $amount = $this->price * $percentage/ 100;
        array_push($coupons,[
          'purchase_id' => $this->id,
          'coupon_id' => $coupon_code->id,
          'percentage' => $percentage,
          'amount' => $amount,
        ]);

        $this->total -= $amount;
      }

      if($invitation_code){
        $percentage = Controller::invitation_discount_amount();
        $amount = $this->price * $percentage/ 100;
        array_push($coupons,[
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

    public function apply_bonuses($teacher,$invitation_code){
      $bonuses = [];

      $percentage = Controller::standard_bonus_amount();
      $amount = $this->price * $percentage/ 100;

      array_push($bonuses,[
        'purchase_id' => $this->id,
        'percentage' => $percentage,
        'amount' => $amount,
        'type' => 1
      ]);

      if($teacher->cloud_tasks_completed()){
        $percentage = Controller::cloud_bonus_amount();
        $amount = $this->price * $percentage/ 100;
        array_push($bonuses,[
          'purchase_id' => $this->id,
          'percentage' => $percentage,
          'amount' => $amount,
          'type' => 2
        ]);
      }

      if($teacher->community_tasks_completed()){
        $percentage = Controller::community_bonus_amount();
        $amount = $this->price * $percentage/ 100;
        array_push($bonuses,[
          'purchase_id' => $this->id,
          'percentage' => $percentage,
          'amount' => $amount,
          'type' => 3
        ]);
      }

      if($invitation_code){
        $percentage = Controller::invitation_bonus_amount();
        $amount = $this->price * $percentage/ 100;
        array_push($bonuses,[
          'purchase_id' => $this->id,
          'percentage' => $percentage,
          'amount' => $amount,
          'type' => 4
        ]);
      }

      PurchaseBonus::insert($bonuses);
    }
}
