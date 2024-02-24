<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'course_id',
    'title',
    'description',
  ];
  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function files()
  {
    return $this->hasMany(LessonFile::class);
  }

  public function videos()
  {
    return $this->hasMany(LessonVideo::class);
  }

  public function video()
  {
    return $this->hasOne(LessonVideo::class)->latestOfMany();
  }
}
