<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'post_id',
    'student_id',
    'content',
  ];

  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  public function student()
  {
    return $this->belongsTo(Student::class);
  }

  public function likes()
  {
    return $this->hasMany(CommentLike::class);
  }

  public function likers()
  {
    return $this->belongsToMany(Student::class, 'comment_likes');
  }

}
