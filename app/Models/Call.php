<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Call extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'teacher_id',
    'student_id',
    'start_time',
    'end_time',
    'duration',
    'type',
    'rating',
  ];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function student()
  {
    return $this->belongsTo(Student::class);
  }

  public function duration()
  {

    if ($this->duration) {
      return $this->duration;
    }

    if ($this->start_time && $this->end_time) {

      $this->duration = Carbon::createFromDate($this->start_time)->diffInSeconds($this->end_time);
      $this->save();
      return $this->duration;
    }
    return null;
  }

  public function is_complement()
  {

    if ($this->duration()) {
      $calls_duration = Setting::where('name', 'calls_duration')->value('value');
      $previuos_calls = $this->teacher->calls()->where(DB::raw('DATE(created_at)'), '>=', Carbon::now()->startOfMonth())
        ->where(DB::raw('DATE(created_at)'), '<=', Carbon::now()->endOfMonth())->whereNot('id', $this->id)->sum('duration');

      $current_calls = $previuos_calls + $this->refresh()->duration;

      if ($previuos_calls < $calls_duration && $current_calls >= $calls_duration) {
        return true;
      }
    }

    return false;
  }
}
