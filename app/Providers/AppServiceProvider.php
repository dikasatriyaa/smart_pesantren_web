<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('user', function(User $user) {
            return $user->role === "0";
        });
        Gate::define('guru', function(User $user) {
            return $user->role === "1";
        });
        Gate::define('admin', function(User $user) {
            return $user->role === "2";
        });
        Gate::define('wali', function(User $user) {
            return $user->role === "3";
        });
        Gate::define('admin-or-guru', function(User $user) {
            return $user->role === "2" || $user->role === "1";
        });
        Gate::define('admin-or-wali-asrama', function(User $user) {
            return $user->role === "2" || $user->role === "3";
        });
        Gate::define('all', function(User $user) {
            return $user->role === "2" || $user->role === "3" || $user->role === "1";
        });
    }
}
