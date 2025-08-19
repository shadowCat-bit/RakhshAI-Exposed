<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {

    /**
     * users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/chat';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware(['api', 'cors'])
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('chat')
                ->group(base_path('routes/chat.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('image')
                ->group(base_path('routes/image.php'));

            Route::middleware(['web', 'auth', 'isAdmin'])
                ->prefix('first-greates-iran-ai-admin')
                ->group(base_path('routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
