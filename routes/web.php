<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Dashboard\Ad\AdController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Levels\LevelController;
use App\Http\Controllers\Dashboard\Coupon\CouponController;
use App\Http\Controllers\Dashboard\Course\CourseController;
use App\Http\Controllers\Dashboard\Section\SectionController;
use App\Http\Controllers\Dashboard\Setting\SettingController;
use App\Http\Controllers\Dashboard\Subject\SubjectController;
use App\Http\Controllers\Dashboard\Analytics\AnalyticsController;
use App\Http\Controllers\Dashboard\LevelSubject\LevelSubjectController;

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

$controller_path = 'App\Http\Controllers';

Route::group(['middleware' => ['auth']], function () {
    Route::get('/theme/{theme}', function ($theme) {
        Session::put('theme', $theme);
        return redirect()->back();
    });

    Route::get('/lang/{lang}', function ($lang) {
        Session::put('locale', $lang);
        App::setLocale($lang);
        return redirect()->back();
    });
});

// Main Page Route
Route::get('/',[AnalyticsController::class, 'index'])->name('dashboard')->middleware('auth');
//

// authentication
Route::get('/auth/login-basic', 'App\Http\Controllers\authentications\LoginBasic@index')->name('login');
Route::get('/auth/register-basic', 'App\Http\Controllers\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::post('/auth/register-action', 'App\Http\Controllers\authentications\RegisterBasic@register');
Route::post('/auth/login-action', 'App\Http\Controllers\authentications\LoginBasic@login');
Route::get('/auth/forgot-password-basic', 'App\Http\Controllers\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/logout', 'App\Http\Controllers\authentications\LogoutBasic@logout')->name('auth-logout');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::resource('sections', SectionController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('level-subjects', LevelSubjectController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('ads', AdController::class);
    //Route::post('coupons/store', [CouponController::class, 'store'])->name('coupons.store');

    Route::post('users/upgrade', [UserController::class, 'upgradeAccount'])->name('users.upgrade');
    Route::put('users/status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::resource('users', UserController::class);

    Route::resource('courses', CourseController::class);

    Route::get('/settings', [SettingController::class,'index']);

    Route::post('/setting/version/update', [SettingController::class,'version']);
    Route::post('/setting/misc/update', [SettingController::class,'misc']);
    Route::post('/setting/contact/update', [SettingController::class,'contact']);
    Route::post('/setting/bank/update', [SettingController::class,'bank']);

    Route::get('/documentation/policy',[SettingController::class,'doc_index'])->name('documentation.policy');
    Route::get('/documentation/about',[SettingController::class,'doc_index'])->name('documentation.about');

    Route::post('/documentation/update',[SettingController::class,'documentation']);
});
