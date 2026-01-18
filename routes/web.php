<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BusinessPartnerController;
use App\Http\Controllers\TwoFactorController;
use App\Models\LoginOtp;
use App\Notifications\LoginOtpNotification;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Two-Factor Login Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/two-factor-login', function () {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor-login');
    })->name('two-factor.login');

    Route::post('/two-factor-login/verify', function (Illuminate\Http\Request $request) {
        $request->validate(['otp' => 'required|string|size:6']);

        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired. Please login again.']);
        }

        $user = \App\Models\User::find($userId);
        if (!$user) {
            return redirect()->route('login')->withErrors(['otp' => 'User not found.']);
        }

        // Verify OTP
        $loginOtp = LoginOtp::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$loginOtp) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        // Mark OTP as used
        $loginOtp->markAsUsed();

        // Log the user in
        Auth::login($user, session('2fa_remember', false));

        // Clear 2FA session data
        session()->forget(['2fa_user_id', '2fa_remember']);

        return redirect()->intended(route('dashboard'));
    })->name('two-factor.login.verify');

    Route::post('/two-factor-login/resend', function () {
        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = \App\Models\User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        // Delete old OTPs
        LoginOtp::where('user_id', $user->id)->where('used', false)->delete();

        // Generate new OTP
        $otp = LoginOtp::generateOtp();
        LoginOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'used' => false,
        ]);

        $user->notify(new LoginOtpNotification($otp));

        return back()->with('status', 'A new verification code has been sent to your email.');
    })->name('two-factor.resend');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    // ── Two Factor Authentication ───────────────────────────────
    Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::delete('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
    Route::post('/two-factor/send-otp', [TwoFactorController::class, 'sendOtp'])->name('two-factor.send-otp');
    Route::post('/two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');

    // ── Business Partners (取引会社マスタ) ───────────────────────────────
    Route::get('/business-partners', [BusinessPartnerController::class, 'index'])
        ->name('business-partners.index');

    Route::get('/business-partners/create', [BusinessPartnerController::class, 'create'])
        ->name('business-partners.create');

    Route::post('/business-partners', [BusinessPartnerController::class, 'store'])
        ->name('business-partners.store');

    Route::get('/business-partners/{businessPartner}/edit', [BusinessPartnerController::class, 'edit'])
        ->name('business-partners.edit');

    Route::put('/business-partners/{businessPartner}', [BusinessPartnerController::class, 'update'])
        ->name('business-partners.update');

    Route::delete('/business-partners/{businessPartner}', [BusinessPartnerController::class, 'destroy'])
        ->name('business-partners.destroy');


    // ── Departments / 部門マスタ───────────────────────────────
    Route::get('/departments', [DepartmentController::class, 'index'])
        ->name('departments.index');

    Route::get('/departments/create', [DepartmentController::class, 'create'])
        ->name('departments.create');

    Route::post('/departments', [DepartmentController::class, 'store'])
        ->name('departments.store');

    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])
        ->name('departments.edit');

    Route::put('/departments/{department}', [DepartmentController::class, 'update'])
        ->name('departments.update');

    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
        ->name('departments.destroy');
});