<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Levels\LevelController;
use App\Http\Controllers\Dashboard\Coupon\CouponController;
use App\Http\Controllers\Dashboard\Section\SectionController;
use App\Http\Controllers\Dashboard\Subject\SubjectController;
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
  Route::get('/theme/{theme}', function($theme){
    Session::put('theme',$theme);
    return redirect()->back();
  });

  Route::get('/lang/{lang}', function($lang){
    Session::put('locale', $lang);
    App::setLocale($lang);
    return redirect()->back();
  });
});

// Main Page Route
Route::get('/', 'App\Http\Controllers\dashboard\Analytics@index')->name('dashboard')->middleware('auth');


// authentication
Route::get('/auth/login-basic', 'App\Http\Controllers\authentications\LoginBasic@index')->name('login');
Route::get('/auth/register-basic', 'App\Http\Controllers\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::post('/auth/register-action', 'App\Http\Controllers\authentications\RegisterBasic@register');
Route::post('/auth/login-action', 'App\Http\Controllers\authentications\LoginBasic@login');
Route::get('/auth/forgot-password-basic', 'App\Http\Controllers\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/logout', 'App\Http\Controllers\authentications\LogoutBasic@logout')->name('auth-logout');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.','middleware' => ['auth']], function () {
    Route::resource('sections', SectionController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('level-subjects', LevelSubjectController::class);
    Route::resource('coupons', CouponController::class);
    // CouponController
    // LevelSubjectController
});


