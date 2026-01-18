<?php

namespace App\Actions\Fortify;

use App\Models\LoginOtp;
use App\Notifications\LoginOtpNotification;
use Laravel\Fortify\LoginRateLimiter;

class RedirectIfTwoFactorEnabled
{
    protected $limiter;

    public function __construct(LoginRateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, $next)
    {
        $user = \App\Models\User::where(
            \Laravel\Fortify\Fortify::username(), 
            $request->{(\Laravel\Fortify\Fortify::username())}
        )->first();

        // If user has EMAIL OTP 2FA enabled and this is not the OTP verification request
        if ($user && $user->usesEmailOtp() && !$request->has('otp')) {
            // Validate password first
            if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                $this->limiter->increment($request);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    \Laravel\Fortify\Fortify::username() => [trans('auth.failed')],
                ]);
            }

            // Clear rate limiter
            $this->limiter->clear($request);

            // Generate and send OTP
            $otp = LoginOtp::generateOtp();
            
            LoginOtp::where('user_id', $user->id)
                ->where('used', false)
                ->delete();

            LoginOtp::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'used' => false,
            ]);

            $user->notify(new LoginOtpNotification($otp));

            // Store user info in session
            session([
                '2fa_user_id' => $user->id,
                '2fa_remember' => $request->filled('remember'),
            ]);

            // Redirect to OTP verification page
            return redirect()->route('two-factor.login');
        }

        // If user has Authenticator 2FA enabled, let Fortify's RedirectIfTwoFactorAuthenticatable handle it
        // This action only handles email OTP - authenticator is handled by Fortify's built-in pipeline

        return $next($request);
    }
}
