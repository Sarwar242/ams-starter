<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\RedirectIfTwoFactorEnabled;
use Laravel\Fortify\Features;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\Laravel\Fortify\Contracts\LoginViewResponse::class, \App\Http\Responses\LoginViewResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\RegisterViewResponse::class, \App\Http\Responses\RegisterViewResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse::class, \App\Http\Responses\RequestPasswordResetLinkViewResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\ResetPasswordViewResponse::class, \App\Http\Responses\ResetPasswordViewResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\VerifyEmailViewResponse::class, \App\Http\Responses\VerifyEmailViewResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\ConfirmPasswordViewResponse::class, \App\Http\Responses\ConfirmPasswordViewResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\TwoFactorChallengeViewResponse::class, \App\Http\Responses\TwoFactorChallengeViewResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        
        // Custom 2FA pipeline - handles both authenticator and email OTP
        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : null,
                // Check for Fortify's built-in authenticator 2FA first
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                // Then check for custom email OTP 2FA
                RedirectIfTwoFactorEnabled::class,
                // Finally attempt authentication and prepare session
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
