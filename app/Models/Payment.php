<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'purchase_id',
    'amount',
    'type',
    'is_paid',
    'paid_at',
    'is_confirmed',
    'confirmed_at',
    'payment_method',
  ];
  public function purchase()
  {
    return $this->belongsTo(Purchase::class);
  }
}
