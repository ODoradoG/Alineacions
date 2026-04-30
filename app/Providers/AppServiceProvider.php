<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin-only', fn ($user) => (bool) $user->is_admin);

        Gate::define('manage-lineup', function ($user, $lineup) {
            return $user->is_admin || $user->id === $lineup->user_id;
        });
    }
}
