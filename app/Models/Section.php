<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name_ar',
    'name_fr',
    'name_en',
    'image',
  ];

  public function levels()
  {
    return $this->hasMany(Level::class);
  }

  public function courses()
  {
    return $this->belongsToMany(Course::class, 'course_sections');
  }

  public function teachers()
  {
    return $this->belongsToMany(Teacher::class, 'teacher_sections');
  }

}
