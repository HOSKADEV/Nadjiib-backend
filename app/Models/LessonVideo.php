<?php

namespace App\Models;

use Aws\S3\S3Client;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

  public function url()
  {

    if($this->video_url){
      if(File::exists($this->video_url)){
        return url($this->video_url);
      }else if(Storage::disk('s3')->exists($this->video_url)){
        return Storage::disk('s3')->temporaryUrl($this->video_url, now()->addMinutes(30));
      }else{
        return $this->video_url;
      }
    }

    return null;
  }
}
