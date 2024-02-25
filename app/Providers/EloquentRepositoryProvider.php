<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Section\EloquentSection;
use App\Repositories\Section\SectionRepository;

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
