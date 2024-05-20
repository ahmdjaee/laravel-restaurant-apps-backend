<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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
        DB::listen(function ($query) {
            Log::info("Query : $query->sql");
        });

        Gate::define('post-menu', function (User $user) {
            return $user->is_admin == true;
        });

        Gate::define('update-menu', function (User $user) {
            return $user->is_admin == true;
        });

        Gate::define('delete-menu', function (User $user) {
            return $user->is_admin == true;
        });
    }
}
