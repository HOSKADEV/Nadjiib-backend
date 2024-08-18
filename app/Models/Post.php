<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function is_complement()
    {

      $posts_number = Setting::where('name','posts_number')->value('value');

      $previuos_posts = $this->teacher->posts()->where(DB::raw('DATE(created_at)'), '>=', Carbon::now()->startOfMonth())
      ->where(DB::raw('DATE(created_at)'), '<=', Carbon::now()->endOfMonth())->whereNot('id',$this->id)->count();

      $current_posts = $previuos_posts + 1;

      if ($previuos_posts < $posts_number && $current_posts >= $posts_number) {
        return true;
      }


      return false;
    }
}
