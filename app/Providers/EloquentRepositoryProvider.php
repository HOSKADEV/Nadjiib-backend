<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Level\EloquentLevel;
use App\Repositories\Level\LevelRepository;
use App\Repositories\Section\EloquentSection;
use App\Repositories\Subject\EloquentSubject;
use App\Repositories\Section\SectionRepository;
use App\Repositories\Subject\SubjectRepository;

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
