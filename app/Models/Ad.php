<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'url',
        'type',
    ];

    public function teacher()
    {
        return $this->hasOneThrough(Teacher::class, TeacherAd::class,
      'ad_id', 'id', 'id', 'teacher_id');
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, CourseAd::class,
      'ad_id', 'id', 'id', 'course_id');
    }
}
