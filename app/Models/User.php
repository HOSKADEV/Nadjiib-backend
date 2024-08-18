<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'phone',
    'gender',
    'password',
    'fcm_token',
    'image',
    'role',
    'status',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function changeStatus()
  {
    $this->status = $this->status == 'ACTIVE' ? 'INACTIVE' : 'ACTIVE';
    $this->save();
  }

  public function getAccountAttribute()
  {
    if ($this->student && $this->teacher) {
      return trans('app.teacher');
    } else if ($this->student) {
      return trans('app.student');
    } else if ($this->teacher) {
      return trans('app.teacher');
    } else {
      return trans('app.user');
    }
  }

  public function student()
  {
    return $this->hasOne(Student::class);
  }
  public function teacher()
  {
    return $this->hasOne(Teacher::class);
  }
  public function notifications()
  {
    return $this->hasMany(Notification::class);
  }

  public function notify($type)
  {
    switch ($type) {
      case 1:
        $notice = Notice::create([
          'title_en' => 'Your upgrade request has been accepted',
          'title_ar' => 'تم قبول طلب تحويلك لأستاذ',
          'content_en' => 'You can now post courses and interact within Cloud and Community',
          'content_ar' => 'يمكنك الآن نشر الدورات و التفاعل داخل غيمة و تفوق',

          'type' => $type,
        ]);
        break;

      case 2:
        $notice = Notice::create([
          'title_en' => 'Your course has been purchased',
          'title_ar' => 'تم شراء دورتك',
          'content_en' => 'A student has purchased one of your courses',
          'content_ar' => 'قام أحد الطلاب بشراء واحدة من دوراتك',

          'type' => $type,
        ]);
        break;

      case 3:
        $notice = Notice::create([
          'title_en' => 'Congratulations! Your course is available',
          'title_ar' => 'مبروك! دورتك أصبحت متاحة',
          'content_en' => 'You will find it in My Courses section, we hope you enjoy it',
          'content_ar' => 'تجدها في قسم دروسي, نتمنى أن تسمتع بها',

          'type' => $type,
        ]);
        break;

      case 4:
        $notice = Notice::create([
          'title_en' => 'Published in Cloud',
          'title_ar' => 'تم النشر في تفوق',
          'content_en' => 'The video has been posted in the Community and it\'s ready',
          'content_ar' => 'لقد تم نشر الفيديو في مجتمع تفوق و أصبح جاهز',

          'type' => $type,
        ]);
        break;

      case 5:
        $notice = Notice::create([
          'title_en' => 'You have a new message',
          'title_ar' => 'لديك رسالة جديدة',
          'content_en' => 'You have been messaged within Cloud, check your messages',
          'content_ar' => 'تمت مراسلتك داخل مجتمع غيمة, تفقد الرسائل',

          'type' => $type,
        ]);
        break;

      case 6:
        $notice = Notice::create([
          'title_en' => 'Adminstration Notices',
          'title_ar' => 'إشعارات الإدارة',
          'content_en' => 'This is a sample message from the administration',
          'content_ar' => 'هذا نموذج لرسالة من الإدارة',

          'type' => $type,
        ]);
        break;

      case 7:
        $notice = Notice::create([
          'title_en' => 'You have unfinished tasks',
          'title_ar' => 'لديك مهام لم تكملها',
          'content_en' => 'Complete the remaining tasks to get a bonus of your earnings for the month',
          'content_ar' => 'أكمل المهام المتبقية للحصول على نسبة اضافية من ارباحك لهذا الشهر',

          'type' => $type,
        ]);
        break;

      case 8:
        $notice = Notice::create([
          'title_en' => 'Your payment has been sent',
          'title_ar' => 'تم إرسال مستحقاتك',
          'content_en' => 'Check your transactions and confirm your payments',
          'content_ar' => 'تفقد معاملاتك و قم بتأكيد وصول مستحقاتك',

          'type' => $type,
        ]);
        break;

      default:
        $notice = null;
    }

    if ($notice) {
      $notification = Notification::create([
        'user_id' => $this->id,
        'notice_id' => $notice->id
      ]);

      return $notification;
    }

    return null;
  }
}
