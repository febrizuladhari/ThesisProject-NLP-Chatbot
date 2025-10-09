<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ChatController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated Routes
Route::middleware(['auth', 'log.activity'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile Completion Routes (tidak menggunakan middleware profile.completed)
    Route::get('/complete-profile', [ProfileController::class, 'showCompleteForm'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileController::class, 'complete']);

    // Admin Routes (Admin tidak perlu complete profile)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);

        // Edit Personal Data User
        Route::get('/users/{user}/personal/edit', [UserController::class, 'editPersonal'])->name('users.edit-personal');
        Route::put('/users/{user}/personal/update', [UserController::class, 'updatePersonal'])->name('users.update-personal');
    });

    // User Routes (Hanya untuk user dengan completed profile)
    Route::middleware(['profile.completed'])->group(function () {
        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/profile/password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('update-password');


        // Chat
        Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
        Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
        Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.message');
        Route::delete('/chat/{chat}', [ChatController::class, 'destroy'])->name('chat.destroy');
    });
});
