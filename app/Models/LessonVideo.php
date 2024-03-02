<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonVideo extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lesson_id',
        'video_url',
        'filename',
        'extension',
        'duration',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
