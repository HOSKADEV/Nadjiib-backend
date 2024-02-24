<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherSubject extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'teacher_id',
    'subject_id',
  ];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

}
