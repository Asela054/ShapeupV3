<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\PrivilegeComposer;

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
        // Register PrivilegeComposer for all views
        // This makes privilege checking available throughout the application
        if (!app()->environment('local')) {
            URL::forceRootUrl(config('app.url'));
            // URL::forceScheme('https');
        }

        View::composer('*', PrivilegeComposer::class);
    }

    
}
