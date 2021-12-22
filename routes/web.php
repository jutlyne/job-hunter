<?php

use App\Http\Controllers\User\RecruitmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ApplyController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SocialController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\ResumeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    // Choose Login
    Route::get('/login_choose', [AuthController::class, 'showLoginOption'])->name('choose_login');

    // User Login
    //Login  facebook
    Route::get('/login-facebook', [SocialController::class, 'login_facebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [SocialController::class, 'callback_facebook']);
    //login google
    Route::get('/login-google', [SocialController::class, 'login_google'])->name('login.google');
    Route::get('/login/google/callback', [SocialController::class, 'callback']);
    Route::get('/login/password/create', [SocialController::class, 'showPasswordForm'])->name('password.create');
    Route::post('/login/password/create', [SocialController::class, 'create_password'])->name('social.password.create');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show_login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/password/forgot', [AuthController::class, 'sendForgotPasswordCode']);
    Route::get('/password/reset', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.show');
    Route::get('/password/recover/{code}', [AuthController::class, 'showRecoverPasswordForm'])->name('password.recover.show');
    Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

    // User Register
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show_register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

Route::middleware('auth:user')->group(function () {
    Route::get('/verify', [RegisterController::class, 'showVerifyForm'])->name('verify');
    Route::post('/verify', [RegisterController::class, 'verify'])->name('verify');
    Route::post('/verify/re-sent', [RegisterController::class, 'resend'])->name('verify.resent');
    Route::middleware('checkstatus')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        // User profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update']);

        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::post('/password', [ProfileController::class, 'passwordChange'])->name('password.change');
        //apply job 
        Route::get('/apply/job', [ApplyController::class, 'apply'])->name('apply.job');
        Route::get('/apply/user-job', [ApplyController::class, 'index'])->name('apply');
        Route::get('/apply/user-destroy', [ApplyController::class, 'destroy'])->name('apply.destroy');
        //resume
        Route::get('/resume', [ResumeController::class, 'index'])->name('resume');
    });
});

// Blog
Route::get('/blogs', [BlogController::class, 'index'])->name('blog');
Route::get('/blogs/{blog:slug}', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/blogs/category/{category}', [BlogController::class, 'index'])->name('blog.category');
Route::get('/blogs/load/{id}', [BlogController::class, 'loadMore'])->name('blog.load');
//job
Route::get('/recruitment', [RecruitmentController::class, 'index'])->name('recruitment');
Route::get('/recruitment/{recruitment:slug}', [RecruitmentController::class, 'detail'])->name('recruitment.detail');
