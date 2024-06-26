<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
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
    'name',
    'description',
    'price',
    'image',
    'video',
    'status',
  ];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

  public function ads()
  {
    return $this->hasManyThrough(Ad::class, CourseAd::class);
  }

  public function levels()
  {
    return $this->belongsToMany(Level::class, 'course_levels');
  }

  public function sections()
  {
    return $this->belongsToMany(Section::class, 'course_sections');
  }

  public function purchases()
  {
    return $this->hasMany(Purchase::class);
  }

  public function purchasers()
  {
    return $this->belongsToMany(Student::class, 'purchases');
  }

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  public function reviewers()
  {
    return $this->belongsToMany(Student::class, 'reviews');
  }

  public function lessons()
  {
    return $this->hasMany(Lesson::class);
  }

  public function videos()
  {
    return $this->through('lessons')->has('videos');
  }

  public function files()
  {
    return $this->through('lessons')->has('files');
  }

}
