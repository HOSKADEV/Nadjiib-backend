<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'section_id',
    'year',
    'name_ar',
    'name_fr',
    'name_en',
    'specialty_ar',
    'specialty_fr',
    'specialty_en',
  ];

  public function section()
  {
    return $this->belongsTo(Section::class);
  }

  public function students()
  {
    return $this->hasMany(Student::class);
  }

  public function courses()
  {
    return $this->belongsToMany(Course::class, 'course_levels');
  }

  public function subjects()
  {
    return $this->belongsToMany(Subject::class, 'level_subjects');
  }
}
