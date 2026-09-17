<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth'])->group(function () {
    // Company routes
    Route::resource('companies', CompanyController::class)
        ->except(['show']);
    Route::get('/companies/{company}/invite', [CompanyController::class, 'invite'])
        ->name('companies.invite');
    Route::post('/companies/{company}/invite', [CompanyController::class, 'sendInvite'])
        ->name('companies.sendInvite');

    // Invitation routes
    Route::get('/invitations/{token}', [InvitationController::class, 'show'])
        ->name('invitations.show');
    Route::post('/invitations/{token}', [InvitationController::class, 'register'])
        ->name('invitations.register');
});