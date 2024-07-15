<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'coupon_id',
        'channel_name',
        'bio',
        'cloud_chat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'teacher_sections');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasManyThrough(PostLike::class, Post::class);
    }

    public function followings()
    {
        return $this->hasMany(Following::class);
    }

    public function followers()
    {
        return $this->belongsToMany(Student::class, 'followings');
    }

    public function ads()
    {
        return $this->hasManyThrough(Ad::class, TeacherAd::class);
    }

    public function purchases(){
      return $this->hasManyThrough(Purchase::class,Course::class);
    }

    public function cloud_tasks_completed(){
      return false;
    }

    public function community_tasks_completed(){
      return false;
    }
}
