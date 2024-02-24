<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'teacher_id',
    'title',
    'description',
    'video_url',
    'filename',
    'thumbnail',
  ];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function commenters()
  {
    return $this->belongsToMany(Student::class, 'comments');
  }
  public function likes()
  {
    return $this->hasMany(PostLike::class);
  }

  public function likers()
  {
    return $this->belongsToMany(Student::class, 'post_likes');
  }

}
