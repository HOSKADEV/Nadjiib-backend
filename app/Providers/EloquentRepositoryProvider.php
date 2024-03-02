<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Level\EloquentLevel;
use App\Repositories\Coupon\EloquentCoupon;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Section\EloquentSection;
use App\Repositories\Subject\EloquentSubject;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Subject\SubjectRepository;
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
