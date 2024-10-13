<?php

namespace App\Models;

use App\Enums\UserStatus;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'customer_id',
    'name',
    'email',
    'phone',
    'gender',
    'password',
    'fcm_token',
    'image',
    'role',
    'status',
    'ccp',
    'baridi_mob',
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

  public function role()
  {
    if ($this->role == 2 && empty($this->teacher?->status)) {
      return 3;
    }

    return intval($this->role);
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

  public function notices()
  {
    return $this->hasManyThrough(Notice::class, Notification::class, 'user_id', 'id', 'id', 'notice_id');
  }

  public function notify($type, $content = null, $fcm = null)
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
          'content_ar' => 'قام أحد التلاميذ بشراء واحدة من دوراتك',

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
          'title_en' => 'Published in Community',
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

      case 9:
        $notice = Notice::create([
          'title_en' => 'You have been re-verified as a teacher',
          'title_ar' => 'لقد تم توثيقك مجددا كأستاذ',
          'content_en' => 'Your teacher privileges have been restored',
          'content_ar' => 'تمت استعادة امتيازات الأستاذ الخاصة بك',

          'type' => 1,
        ]);
        break;

      case 10:
        $notice = Notice::create([
          'title_en' => 'Your verification has been canceled',
          'title_ar' => 'لقد تم الغاء توثيقك',
          'content_en' => 'Your teacher privileges have been revoked',
          'content_ar' => 'تم إلغاء امتيازات الأستاذ الخاصة بك',

          'type' => 1,
        ]);
        break;

      case 11:
        $notice = Notice::create([
          'title_en' => 'Your course has been approved',
          'title_ar' => 'تمت الموافقة على دورتك',
          'content_en' => 'Your course has been approved and is now available for purchase',
          'content_ar' => 'تمت الموافقة على دورتك وهي الآن متاحة للشراء',

          'type' => 3,
        ]);
        break;

      case 12:
        $notice = Notice::create([
          'title_en' => 'Your course was not approved',
          'title_ar' => 'لم تتم الموافقة على دورتك',
          'content_en' => $content ?? 'Unfortunately, your course was not approved for publication',
          'content_ar' => $content ?? 'للأسف، لم تتم الموافقة على نشر دورتك',

          'type' => 3,
        ]);
        break;

      case 13:
        $notice = Notice::create([
          'title_en' => 'Course purchase successful',
          'title_ar' => 'تم شراء الدورة بنجاح',
          'content_en' => 'You have successfully purchased the course and gained access to it and the cloud service',
          'content_ar' => 'لقد نجحت في شراء الدورة وحصلت على حق الوصول إليها وإلى خدمة السحابة',

          'type' => 2,
        ]);
        break;

      case 14:
        $notice = Notice::create([
          'title_en' => 'Course purchase unsuccessful',
          'title_ar' => 'لم تتم عملية شراء الدورة',
          'content_en' => $content ?? 'Your attempt to purchase the course was unsuccessful',
          'content_ar' => $content ?? 'لم تنجح محاولتك لشراء الدورة',

          'type' => 2,
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

      if ($fcm && $this->fcm_token) {
        $controller = new Controller();
        $controller->send_fcm_device(
          $notice->title(Session::get('locale')),
          $notice->content(Session::get('locale')),
          $this->fcm_token
        );
      }

      return $notification;
    }

    return null;
  }
}
