<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'discount',
        'start_date',
        'end_date',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function usages()
    {
        return $this->hasMany(PurchaseCoupon::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_coupons');
    }

    public function start_date(){
      $start_date = Carbon::createFromDate($this->srart_date);
      return $start_date->format('Y-m-d');
    }

    public function end_date(){
      $end_date = Carbon::createFromDate($this->end_date);
      return $end_date->format('Y-m-d');
    }
}
