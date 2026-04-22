<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin-only', function ($user) {
            return $user->is_admin;
        });

        Gate::define('own-lineup', function ($user, $lineup) {
            return $user->id === $lineup->user_id;
        });
    }
}
