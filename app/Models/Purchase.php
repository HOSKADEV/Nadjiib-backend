<?php

namespace App\Models;

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

  public function payments()
  {
    return $this->hasMany(Payment::class);
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

}
