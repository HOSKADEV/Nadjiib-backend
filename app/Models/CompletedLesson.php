<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompletedLesson extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
      'student_id',
      'lesson_id'
    ];

    public function student(){
      return $this->belongsTo(Student::class);
    }

    public function lesson(){
      return $this->belongsTo(Lesson::class);
    }
}
