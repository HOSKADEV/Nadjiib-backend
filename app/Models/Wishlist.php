<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'course_id',
      'student_id',
  ];

  public function course()
  {
      return $this->belongsTo(Course::class);
  }

  public function student()
  {
      return $this->belongsTo(Student::class);
  }
}
