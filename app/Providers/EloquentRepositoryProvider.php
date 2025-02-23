<?php

namespace App\Providers;

use App\Repositories\User\EloquentUser;
use App\Repositories\Wallet\EloquentWallet;
use App\Repositories\Wallet\WalletRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Level\EloquentLevel;
use App\Repositories\User\UserRepository;
use App\Repositories\Coupon\EloquentCoupon;
use App\Repositories\Course\EloquentCourse;
use App\Repositories\Lesson\EloquentLesson;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Review\EloquentReview;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Lesson\LessonRepository;
use App\Repositories\Review\ReviewRepository;

use App\Repositories\Section\EloquentSection;
use App\Repositories\Student\EloquentStudent;
use App\Repositories\Subject\EloquentSubject;
use App\Repositories\Teacher\EloquentTeacher;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\Wishlist\EloquentWishlist;
use App\Repositories\Wishlist\WishlistRepository;
use App\Repositories\LessonFile\EloquentLessonFile;
use App\Repositories\CourseLevel\EloquentCourseLevel;
use App\Repositories\LessonFile\LessonFileRepository;
use App\Repositories\LessonVideo\EloquentLessonVideo;
use App\Repositories\CourseLevel\CourseLevelRepository;
use App\Repositories\LessonVideo\LessonVideoRepository;
use App\Repositories\LevelSubject\EloquentLevelSubject;
use App\Repositories\CourseSection\EloquentCourseSection;
use App\Repositories\LevelSubject\LevelSubjectRepository;
use App\Repositories\CourseSection\CourseSectionRepository;

class EloquentRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SectionRepository::class, EloquentSection::class);
        $this->app->bind(SubjectRepository::class, EloquentSubject::class);
        $this->app->bind(LevelRepository::class, EloquentLevel::class);
        $this->app->bind(LevelSubjectRepository::class, EloquentLevelSubject::class);

        $this->app->bind(CouponRepository::class, EloquentCoupon::class);
        $this->app->bind(UserRepository::class, EloquentUser::class);

        $this->app->bind(CourseRepository::class, EloquentCourse::class);
        $this->app->bind(CourseLevelRepository::class, EloquentCourseLevel::class);
        $this->app->bind(CourseSectionRepository::class, EloquentCourseSection::class);
        $this->app->bind(StudentRepository::class, EloquentStudent::class);
        $this->app->bind(TeacherRepository::class, EloquentTeacher::class);

        $this->app->bind(LessonRepository::class, EloquentLesson::class);
        $this->app->bind(LessonFileRepository::class, EloquentLessonFile::class);
        $this->app->bind(LessonVideoRepository::class, EloquentLessonVideo::class);

        $this->app->bind(ReviewRepository::class, EloquentReview::class);
        $this->app->bind(WishlistRepository::class, EloquentWishlist::class);
        $this->app->bind(WalletRepository::class, EloquentWallet::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
