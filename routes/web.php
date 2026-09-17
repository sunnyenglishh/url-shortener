<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Invitation routes
Route::get('/invitations/{token}', [InvitationController::class, 'show'])
    ->name('invitations.show');
Route::post('/invitations/{token}', [InvitationController::class, 'register'])
    ->name('invitations.register');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::middleware(['auth'])->group(function () {
    // Company routes

    Route::middleware('role:SuperAdmin,Admin')->group(function () {
        Route::resource('companies', CompanyController::class)
            ->except(['show']);
        Route::get('/companies/{company}/invite', [CompanyController::class, 'invite'])
            ->name('companies.invite');
        Route::post('/companies/{company}/invite', [CompanyController::class, 'sendInvite'])
            ->name('companies.sendInvite');
    });

    Route::post('/short-urls', [ShortUrlController::class, 'store'])
        ->name('short-urls.store');
});

// Short URL redirection route
Route::get('/{shortUrl}', [ShortUrlController::class, 'redirect'])
    ->name('short-urls.redirect');