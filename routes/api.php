<?php

use App\Http\Controllers\API\Coupons\CouponController;
use App\Http\Controllers\API\Levels\LevelController;
use App\Http\Controllers\API\Section\SectionController;
use App\Http\Controllers\API\Subject\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Router For Section
Route::get('/sections-all', [SectionController::class,'getSection']);

Route::get('/levels-all',   [LevelController::class, 'getLevel']);
Route::post('/level/bysection', [LevelController::class,'levelBySection']);

Route::get('/subjects-all', [SubjectController::class, 'getSubject']);
Route::get('/coupons-all',  [CouponController::class, 'getCoupon']);


