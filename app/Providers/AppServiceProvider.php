<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Models\User;
use App\Observers\UserObserver;
use App\Observers\TransactionObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Schema::defaultStringLength(191);
        User::observe(UserObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
