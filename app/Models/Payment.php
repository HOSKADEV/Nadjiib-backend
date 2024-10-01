<?php

namespace App\Models;

use Illuminate\Support\Carbon;
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

    public function purchases(){
      return $this->teacher->purchases()
      ->where('purchases.status','success')
      ->whereMonth('purchases.created_at', Carbon::createFromDate($this->date)->month)
      ->whereYear('purchases.created_at', Carbon::createFromDate($this->date)->year);
    }

    public function status(){
      if($this->is_confirmed == 'yes'){
        return 2;
      }
      if($this->is_paid == 'yes'){
        return 1;
      }

      return 0;
    }

    public function bonuses(){
      return PurchaseBonus::whereIn('purchase_id',$this->purchases()->pluck('purchases.id')->toArray()) ;
    }

    public function refresh_amount(){
      //$purchases = $this->teacher->purchases()->where('purchases.status','success')->pluck('purchases.id')->toArray();
      $this->amount = $this->bonuses()->sum('amount');
      $this->save();
    }
}
