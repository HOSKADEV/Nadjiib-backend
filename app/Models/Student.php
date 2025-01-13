<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Post\PostResource;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Comment\CommentResource;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'user_id',
    'level_id',
    'status',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function level()
  {
    return $this->belongsTo(Level::class)->withTrashed();
  }

  public function purchases()
  {
    return $this->hasMany(Purchase::class);
  }

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }

  public function purchased_courses()
  {
    return $this->belongsToMany(Course::class, 'purchases')->withTrashed();
  }

  public function completed_lessons()
  {
    return $this->hasMany(CompletedLesson::class);
  }

  public function owned_courses()
  {
    return $this->purchased_courses()->where('purchases.status', 'success');
  }

  public function reviewed_courses()
  {
    return $this->belongsToMany(Course::class, 'reviews');
  }

  public function calls()
  {
    return $this->hasMany(Call::class);
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  public function liked_comments()
  {
    return $this->hasManyThrough(Comment::class, CommentLike::class, 'student_id', 'id', 'id', 'comment_id');
  }

  public function followings()
  {
    return $this->hasMany(Following::class);
  }

  public function followed_teachers()
  {
    return $this->hasManyThrough(Teacher::class, Following::class, 'student_id', 'id', 'id', 'teacher_id');
  }

  public function liked_posts()
  {
    return $this->hasManyThrough(Post::class, PostLike::class, 'student_id', 'id', 'id', 'post_id');
  }

  public function subscriptions()
  {
    return $this->hasManyThrough(Subscription::class, Purchase::class);
  }

  public function active_subs()
  {
    return $this->subscriptions()->where('subscriptions.start_date', '<=', Carbon::now())
      ->where('subscriptions.end_date', '>=', Carbon::now());
  }

  public function purchased($course)
  {
    return boolval($this->purchases()->where('course_id', $course->id)
      ->where(function ($query) {
        $query->where(function ($query) {
          $query->where('payment_method', 'chargily')->where('status', 'success');
        })
          ->orWhere(function ($query) {
            $query->whereNot('payment_method', 'chargily')->whereNot('status', 'failed');
          });

      })
      ->count());
  }

  public function owns($course)
  {
    return boolval($this->purchases()->where('course_id', $course->id)->where('status', 'success')->count());
  }

  public function wished($course)
  {
    return boolval($this->wishlists()->where('course_id', $course->id)->count());
  }

  public function completed($course)
  {
    return $this->completed_lessons()->whereIn('lesson_id', $course->lessons()->get('id')->pluck('id')->toArray())->count();
  }

  public function liked($object)
  {
    $likes = 0;
    if (get_class($object) == PostResource::class) {
      $likes = $this->liked_posts()->where('posts.id', $object->id)->count();
    }

    if (get_class($object) == CommentResource::class) {
      $likes = $this->liked_comments()->where('comments.id', $object->id)->count();
    }

    return boolval($likes);
  }

  public function followed($teacher)
  {

    $followings = $this->followings()->where('teacher_id', $teacher->id)->count();
    return boolval($followings);

  }
}
