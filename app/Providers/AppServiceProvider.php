<?php

namespace App\Providers;

use App\Services\TagService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        (new TagService())->make();
        // mysql版本低于5.7.7
        \Schema::defaultStringLength(191);
    }
}
