<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonFile extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lesson_id',
        'file_url',
        'filename',
        'extension',
    ];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function url(){
      if($this->file_url){
        if(File::exists($this->file_url)){
          return url($this->file_url);
        }else if(Storage::disk('s3')->exists($this->file_url)){
          return Storage::disk('s3')->temporaryUrl($this->file_url, now()->addMinutes(30));
        }else{
          return $this->file_url;
        }
      }

      return null;

    }

    public function type(){
      if(in_array(strtolower($this->extension), ['doc','docx','dot','dotx'])){
        return 'doc';
      }elseif(in_array(strtolower($this->extension), ['xls','xlsx','xlsb','xlm','xlam'])){
        return 'xls';
      }elseif(in_array(strtolower($this->extension), ['ppt','pptx','pptm','pot','potx','potm','pps','ppsx','ppsm'])) {
        return 'ppt';
      }elseif(in_array(strtolower($this->extension), ['png','jpg','jpeg','svg','tiff','webp'])) {
        return 'img';
      }elseif(in_array(strtolower($this->extension), ['zip','7z','rar','rar5','gz','tgz'])) {
        return 'zip';
      }elseif(strtolower($this->extension) == 'pdf') {
        return 'pdf';
      }else{
        return 'secondary';
      }
    }
}
