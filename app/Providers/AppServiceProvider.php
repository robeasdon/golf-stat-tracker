<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );

        $this->app->bind(
            'App\Repositories\Contracts\UserRepositoryInterface',
            'App\Repositories\Eloquent\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\CourseRepositoryInterface',
            'App\Repositories\Eloquent\CourseRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\HoleRepositoryInterface',
            'App\Repositories\Eloquent\HoleRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\TeeTypeRepositoryInterface',
            'App\Repositories\Eloquent\TeeTypeRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\TeeSetRepositoryInterface',
            'App\Repositories\Eloquent\TeeSetRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\RoundRepositoryInterface',
            'App\Repositories\Eloquent\RoundRepository'
        );
    }
}
