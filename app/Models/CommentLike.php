<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentLike extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment_id',
        'student_id',
    ];


    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
