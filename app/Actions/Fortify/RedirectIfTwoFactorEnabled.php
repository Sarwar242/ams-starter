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
        // Skip if this is a 2FA challenge submission (code or recovery_code present)
        if ($request->has('code') || $request->has('recovery_code')) {
            return $next($request);
        }

        $user = \App\Models\User::where(
            \Laravel\Fortify\Fortify::username(), 
            $request->{(\Laravel\Fortify\Fortify::username())}
        )->first();

        // If user doesn't exist or doesn't have email OTP, let other middleware handle it
        if (!$user || !$user->usesEmailOtp()) {
            return $next($request);
        }

        // User has EMAIL OTP 2FA enabled - validate password and send OTP
        if (!$request->has('otp')) {
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

        return $next($request);
    }
}
