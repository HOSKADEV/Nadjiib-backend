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
        'teacher_id',
        'amount',
        'date',
        'is_paid',
        'paid_at',
        'is_confirmed',
        'confirmed_at',
        'payment_method',
        'receipt',
    ];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function refresh_amount(){
      $purchases = $this->teacher->purchases()->where('purchases.status','success')->pluck('purchases.id')->toArray();
      $this->amount = PurchaseBonus::whereIn('purchase_id',$purchases)->sum('amount');
      $this->save();
    }
}
