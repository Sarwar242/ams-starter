<?php

namespace App\Providers;

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
        // Listen for Fortify 2FA events to set the type
        \Illuminate\Support\Facades\Event::listen(
            \Laravel\Fortify\Events\TwoFactorAuthenticationEnabled::class,
            function ($event) {
                $event->user->update(['two_factor_type' => 'authenticator']);
            }
        );

        \Illuminate\Support\Facades\Event::listen(
            \Laravel\Fortify\Events\TwoFactorAuthenticationDisabled::class,
            function ($event) {
                $event->user->update(['two_factor_type' => null]);
            }
        );
    }
}
