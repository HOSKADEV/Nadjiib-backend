<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseCoupon extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purchase_id',
        'coupon_id',
        'percentage',
        'amount',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
