<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        return $this->belongsTo(Level::class);
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
        return $this->belongsToMany(Course::class, 'purchases');
    }

    public function completed_lessons()
    {
        return $this->hasMany(CompletedLesson::class);
    }

    public function owned_courses(){
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
        return $this->belongsToMany(Comment::class, 'comment_likes');
    }

    public function followings()
    {
        return $this->hasMany(Following::class);
    }

    public function followed_teachers()
    {
        return $this->belongsToMany(Teacher::class, 'followings');
    }

    public function liked_posts()
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }

    public function subscriptions()
    {
        return $this->hasManyThrough(Subscription::class, Purchase::class);
    }

    public function purchased($course){
      return boolval($this->purchases()->where('course_id',$course->id)->count());
    }

    public function owns($course){
      return boolval($this->purchases()->where('course_id',$course->id)->where('status','success')->count());
    }

    public function wished($course){
      return boolval($this->wishlists()->where('course_id',$course->id)->count());
    }

    public function completed($course){
      return $this->completed_lessons()->whereIn('lesson_id',$course->lessons()->get('id')->pluck('id')->toArray())->count();
    }
}
