<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\View\Composers\CategoryComposer;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
            Paginator::useBootstrap();
            View::composer(
            ['layouts.app'],
            CategoryComposer::class
    );

    }
}
