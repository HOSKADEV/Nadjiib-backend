<?php

namespace App\Models;

use App\Models\CourseLevel;
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
    ];

    protected $softCascade = ['courseLevel','courseSection'];

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
        return $this->belongsTo(Subject::class);
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

    public function bonuses(){
      return $this->hasManyThrough(PurchaseBonus::class,Purchase::class);
    }

    public function price($invitation_code = null, $coupon_code = null){
      $total_discount = 0;
      if($coupon_code){
        $total_discount += Coupon::where('code',$coupon_code)->first()->discount;
      }

      if($invitation_code){
        $total_discount += Controller::invitation_discount_amount();
      }

      return $this->price * (1 - $total_discount / 100);
    }
}
