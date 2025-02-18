<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function course_subjects()
    {
        return $this->belongsToMany(Subject::class, 'courses')->distinct();
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
        return $this->hasManyThrough(Student::class, Following::class, 'teacher_id', 'id', 'id', 'student_id');
    }

    public function ads()
    {
        return $this->hasManyThrough(Ad::class, TeacherAd::class);
    }

    public function purchases(){
      return $this->hasManyThrough(Purchase::class,Course::class);
    }

    public function cloud_tasks_completed(){

      $calls_duration = Setting::where('name','calls_duration')->value('value');

      $calls_duration = empty($calls_duration) ? 0 : intval($calls_duration);

      $teacher_calls = $this->calls()->where(DB::raw('DATE(created_at)'), '>=', Carbon::now()->startOfMonth())
      ->where(DB::raw('DATE(created_at)'), '<=', Carbon::now()->endOfMonth())->sum('duration');


      return $teacher_calls >= $calls_duration ? true : false;
    }

    public function community_tasks_completed(){

      $posts_number = Setting::where('name','posts_number')->value('value');

      $teacher_posts = $this->posts()->where(DB::raw('DATE(created_at)'), '>=', Carbon::now()->startOfMonth())
      ->where(DB::raw('DATE(created_at)'), '<=', Carbon::now()->endOfMonth())->count();

      return $teacher_posts >= $posts_number ? true : false;
    }

    public function notify(){
      $teacher = $this->refresh();
      $user = $teacher->user;
      if($teacher->status){
        $user->notices()->where('notices.type',1)->count() == 0
        ? $user->notify(type:1, fcm:true)
        : $user->notify(type:9, fcm:true);
      }else{
        $user->notify(type:10, fcm:true);
      }


    }
}
