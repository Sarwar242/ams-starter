<?php

namespace App\Listeners;

use App\Models\LoginOtp;
use App\Notifications\LoginOtpNotification;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckTwoFactorAuth
{
    /**
     * Handle the event.
     */
    public function handle(Attempting $event): void
    {
        // Get the user trying to login
        $user = \App\Models\User::where('email', $event->credentials['email'])->first();

        // If user has 2FA enabled and hasn't verified OTP yet
        if ($user && $user->two_factor_enabled) {
            // Store user ID in session for later verification
            Session::put('2fa_user_id', $user->id);
            Session::put('2fa_remember', $event->remember ?? false);
        }
    }
}
