<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
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
    'type',
  ];


  public function levels()
  {
    return $this->belongsToMany(Level::class, 'level_subjects');
  }

  public function teachers()
  {
    return $this->belongsToMany(Teacher::class, 'teacher_subjects');
  }

  public function courses()
  {
    return $this->hasMany(Course::class);
  }

}
