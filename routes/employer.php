<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employer\AuthController;
use App\Http\Controllers\Employer\CandidateController;
use App\Http\Controllers\Employer\RegisterController;
use App\Http\Controllers\Employer\DashBoardController;
use App\Http\Controllers\Employer\PrioritizeController;
use App\Http\Controllers\Employer\ProfileController;
use App\Http\Controllers\Employer\RecruitmentController;
use App\Http\Controllers\Employer\AgreeController;


/*
|--------------------------------------------------------------------------
| Employer Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show_login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show_register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('/password/forgot', [AuthController::class, 'sendForgotPasswordCode'])->name('password.send');
Route::get('/password/reset', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.show');
Route::get('/password/recover/{code}', [AuthController::class, 'showRecoverPasswordForm'])->name('password.recover.show');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth:store')->group(function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-avatar', [AuthController::class, 'avatarUpdate'])->name('avatar.update');
    Route::post('/change-password', [AuthController::class, 'passwordUpdate'])->name('password.update');
    Route::post('/profile/banners', [ProfileController::class, 'uploadBanner'])->name('profile.banners.store');
    Route::delete('/profile/banners/{id}', [ProfileController::class, 'deleteBanner'])->name('profile.banners.delete');
    Route::resource('/recruitment', RecruitmentController::class);
    Route::resource('/prioritize', PrioritizeController::class);
    Route::resource('/candidate', CandidateController::class);
    Route::get('/candidate-accept', [CandidateController::class, 'acceptCustomer'])->name('candidate.accept');
    Route::post('/messages/{user}', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/refuse/{id}', [AgreeController::class, 'refuse'])->name('message.refuse');
    Route::get('/change/prioritize', [PrioritizeController::class, 'active'])->name('change.prioritize');
});