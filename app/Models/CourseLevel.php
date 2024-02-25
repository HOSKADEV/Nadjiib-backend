<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLevel extends Model
{
    use HasFactory,SoftDeletes,SoftCascadeTrait;
  /**
 * The attributes that are mass assignable.
 *
 * @var array<int, string>
 */
protected $fillable = [
  'course_id',
  'level_id',
];

public function course(){
  return $this->belongsTo(Course::class);
}

public function level(){
  return $this->belongsTo(Level::class);
}
}
