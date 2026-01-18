<?php

namespace App\Http\Controllers;

use App\Models\LoginOtp;
use App\Notifications\LoginOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    /**
     * Enable two-factor authentication for the user.
     */
    public function enable(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => true,
        ]);

        return back()->with('status', 'two-factor-enabled');
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disable(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => false,
        ]);

        // Delete any pending OTPs
        LoginOtp::where('user_id', $user->id)->delete();

        return back()->with('status', 'two-factor-disabled');
    }

    /**
     * Send OTP to user's email.
     */
    public function sendOtp(Request $request)
    {
        $user = Auth::user();

        // Delete any existing unused OTPs for this user
        LoginOtp::where('user_id', $user->id)
            ->where('used', false)
            ->delete();

        // Generate new OTP
        $otp = LoginOtp::generateOtp();

        // Store OTP in database
        LoginOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'used' => false,
        ]);

        // Send OTP via email
        $user->notify(new LoginOtpNotification($otp));

        return back()->with('status', 'otp-sent');
    }

    /**
     * Verify OTP entered by user.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        // Find the most recent valid OTP
        $loginOtp = LoginOtp::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$loginOtp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        // Mark OTP as used
        $loginOtp->markAsUsed();

        return back()->with('status', 'otp-verified');
    }
}
