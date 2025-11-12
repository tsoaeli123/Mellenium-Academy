<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any broadcast services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Broadcast Channels
        |--------------------------------------------------------------------------
        | Here you can register all of your event broadcasting channels.
        | Channels require authentication to authorize users.
        */

        // 👇 Use Sanctum for SPA / API authentication
        Broadcast::routes(['middleware' => ['auth:sanctum']]);

        // Load your channel definitions
        require base_path('routes/channels.php');
    }
}

