<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'purchase_id',
    'start_date',
    'end_date',
  ];

  public function purchase()
  {
    return $this->belongsTo(Purchase::class);
  }

  public function student()
  {
    return $this->hasOneThrough(Student::class, Purchase::class);
  }

}
