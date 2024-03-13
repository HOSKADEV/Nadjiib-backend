<?php

namespace App\Providers;

use App\Repositories\User\EloquentUser;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Level\EloquentLevel;
use App\Repositories\User\UserRepository;
use App\Repositories\Coupon\EloquentCoupon;
use App\Repositories\Course\EloquentCourse;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Section\EloquentSection;
use App\Repositories\Subject\EloquentSubject;
use App\Repositories\Teacher\EloquentTeacher;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\LevelSubject\EloquentLevelSubject;
use App\Repositories\LevelSubject\LevelSubjectRepository;

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
        $this->app->bind(TeacherRepository::class, EloquentTeacher::class);
        $this->app->bind(CourseRepository::class, EloquentCourse::class);
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
