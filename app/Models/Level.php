<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'section_id',
        'year',
        'name_ar',
        'name_fr',
        'name_en',
        'specialty_ar',
        'specialty_fr',
        'specialty_en',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_levels');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'level_subjects');
    }

    public function name($lang = 'ar'){
      return match($lang){
        'ar' => $this->name_ar,
        'en' => $this->name_en,
        'fr' => $this->name_fr,
        'default' => $this->name_ar,
      };
    }

    public function specialty($lang = 'ar'){
      return match($lang){
        'ar' => $this->specialty_ar,
        'en' => $this->specialty_en,
        'fr' => $this->specialty_fr,
        'default' => $this->specialty_ar,
      };
    }
}
