<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        Paginator::useTailwind(); // Tailwind CSS 美化分頁

        // 🚀 強制在 production 環境下使用 HTTPS
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
