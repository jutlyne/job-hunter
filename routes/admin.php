<?php

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

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RecruitmentCatController;
use App\Http\Controllers\Admin\RecruitmentController;
use App\Http\Controllers\Admin\UserController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show_login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth.admin:admin')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('employers/request', [EmployerController::class, 'requestForm'])->name('employers.request');
    Route::post('employers/request/{employers}', [EmployerController::class, 'updateStatus'])->name('employers.request.active');
    Route::post('employers/prioritize/{employers}', [EmployerController::class, 'updatePrioritize'])->name('employers.prioritize');
    Route::post('employers/status/{employers}', [EmployerController::class, 'updateStatus'])->name('employers.status');
    Route::resource('employers', EmployerController::class);
    Route::get('users/status/{id}', [UserController::class, 'status'])->name('users.status');
    Route::resource('users', UserController::class);
    Route::resource('blogs', BlogController::class);
    Route::get('blogs/category/check', [BlogController::class, 'checkCategory'])->name('blog.category.check');
    Route::post('blogs/category/store', [BlogController::class, 'createCategory'])->name('blogs.category.store');
    Route::post('/uploadImage', [BlogController::class, 'imageUpload'])->name('imageUpload');
    Route::post('/removeImage', [BlogController::class, 'removeImage'])->name('removeImage');
    Route::resource('categories', CategoryController::class);
    Route::delete('category/{category}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::resource('recruitment', RecruitmentController::class);
    Route::get('recruitment/category/check', [RecruitmentController::class, 'checkCat'])->name('recruitment.category.check');
    Route::post('recruitment/category/store', [RecruitmentController::class, 'createCat'])->name('recruitment.category.store');
    Route::get('recruitment/info/{id}', [RecruitmentController::class, 'getInfo'])->name('recruitment.info');
    Route::resource('recruitmentcat', RecruitmentCatController::class);
    Route::delete('recruitmentcat/{category}/delete', [RecruitmentCatController::class, 'destroy'])->name('recruitmentcat.destroy');
    Route::resource('profile', ProfileController::class);
});
