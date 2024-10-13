<?php

namespace App\Models;

use App\Models\CourseLevel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
  use HasFactory, SoftDeletes, SoftCascadeTrait;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'teacher_id',
    'subject_id',
    'name',
    'description',
    'price',
    'image',
    'video',
    'thumbnail',
    'status',
    'reject_reason'
  ];

  /* protected $softCascade = ['courseLevel', 'courseSection']; */
  protected $softCascade = ['ads', 'wishlists'];
  protected $casts = [
    'teacher_id' => 'integer',
    'subject_id' => 'integer',
    'price' => 'double',
  ];

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class)->withTrashed();
  }

  public function ads()
  {
    return $this->hasManyThrough(Ad::class, CourseAd::class);
  }

  public function levels()
  {
    return $this->belongsToMany(Level::class, 'course_levels');
  }

  public function courseLevel()
  {
    return $this->hasMany(courseLevel::class);
  }

  public function sections()
  {
    return $this->belongsToMany(Section::class, 'course_sections');
  }

  public function courseSection()
  {
    return $this->hasMany(CourseSection::class);
  }

  public function purchases()
  {
    return $this->hasMany(Purchase::class);
  }

  public function purchasers()
  {
    return $this->belongsToMany(Student::class, 'purchases');
  }

  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }

  public function reviewers()
  {
    return $this->belongsToMany(Student::class, 'reviews');
  }

  public function lessons()
  {
    return $this->hasMany(Lesson::class);
  }

  public function videos()
  {
    return $this->through('lessons')->has('videos');
  }

  public function files()
  {
    return $this->through('lessons')->has('files');
  }

  public function bonuses()
  {
    return $this->hasManyThrough(PurchaseBonus::class, Purchase::class);
  }

  public function price($invitation_code = null, $coupon_code = null)
  {
    $total_discount = 0;
    if ($coupon_code) {
      $total_discount += Coupon::where('code', $coupon_code)->first()->discount;
    }

    if ($invitation_code) {
      $total_discount += Controller::invitation_discount_amount();
    }



    return [
      'old_price' => $this->price,
      'new_price' => $this->price * (1 - $total_discount / 100),
      'discount' => $total_discount
    ];
  }

  public static function best_sellers($number)
  {
    return Course::leftjoin('purchases', 'courses.id', 'purchases.course_id')
      ->groupBy('courses.id')
      ->select(
        'courses.*',
        DB::raw('COUNT(courses.id)')
      )
      ->where('courses.status', 'ACCEPTED')
      ->orderBy(DB::raw('COUNT(courses.id)'), 'DESC')
      ->limit($number);
  }

  public static function suggestions($number, $user)
  {
    if ($user) {
      $last_purchased_courses = $user->student?->purchased_courses()->latest('purchases.created_at')->take(3);

      return Course::leftjoin('course_levels', function ($join) use ($user) {
        $join->on('course_levels.course_id', '=', 'courses.id');
        $join->where('course_levels.level_id', '=', $user->student?->level_id);
      })
        ->select('courses.*', 'course_levels.level_id')
        ->where('courses.status', 'ACCEPTED')
        ->where(function ($query) use ($last_purchased_courses) {
          $query->whereIn('courses.subject_id', $last_purchased_courses->pluck('subject_id')->toArray());
          $query->orWhereIn('courses.teacher_id', $last_purchased_courses->pluck('teacher_id')->toArray());
          //$query->orWhereIn('course_levels.level_id', $last_purchased_courses->levels()->pluck('levels.id')->toArray());
        })
        //->distinct('courses.id')
        ->inRandomOrder()
        ->limit($number);

    } else {
      return collect([]);
    }

  }
  public static function recommended($number, $user)
  {

    if ($user) {
      return Course::leftjoin('course_levels', function ($join) use ($user) {
        $join->on('course_levels.course_id', '=', 'courses.id');
        $join->where('course_levels.level_id', '=', $user->student?->level_id);
      })
        ->select('courses.*', 'course_levels.level_id')
        ->where('courses.status', 'ACCEPTED')
        //->distinct('courses.id')
        ->inRandomOrder()
        ->limit($number);
    } else {
      return collect([]);
    }

  }

  public function notify(){
    $user = $this->teacher->user;
    if($user) {
      if($this->status == 'ACCEPTED') {
        $user->notify(
          type: 11,
          fcm: true
        );
      }elseif($this->status == 'REFUSED') {
        $user->notify(
          type: 12,
          content: $this->reject_reason,
          fcm: true
        );
      }
    }
  }
}
