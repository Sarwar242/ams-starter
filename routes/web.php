<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BusinessPartnerController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
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
});