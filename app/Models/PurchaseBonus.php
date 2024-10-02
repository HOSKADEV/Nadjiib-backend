<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseBonus extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'purchase_id',
        'percentage',
        'amount',
        'type',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function created_at(){
      return $this->created_at
      ? Carbon::createFromDate($this->created_at)->format('Y-m-d H:i')
      : Carbon::createFromDate($this->purchase->created_at)->format('Y-m-d H:i');
    }

    public function type(){
      return match(intval($this->type)){
        1 => trans('purchase.bonus.standard'),
        2 => trans('purchase.bonus.cloud'),
        3 => trans('purchase.bonus.community'),
        4 => trans('purchase.bonus.invitation'),
      };
    }
}
