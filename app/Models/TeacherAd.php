<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherAd extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'ad_id',
    'teacher_id',
  ];

  public function ad()
  {
    return $this->belongsTo(Ad::class);
  }

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

}
