<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\API\Levels\LevelController;
use App\Http\Controllers\API\Coupons\CouponController;
use App\Http\Controllers\API\Section\SectionController;
use App\Http\Controllers\API\Student\StudentController;
use App\Http\Controllers\API\Subject\SubjectController;


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



Route::prefix('v1')->group(function () {
  Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
      'status' => 1,
      'data' => new \App\Http\Resources\User\UserResource($request->user())
    ]);
});
  Route::post('/auth/login', [AuthController::class,'login']);
  Route::get('/auth/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
  Route::post('/section/get', [SectionController::class,'get']);
  Route::post('/level/get', [LevelController::class,'get']);
  Route::post('/subject/get', [SubjectController::class,'get']);
  Route::post('/student/create', [StudentController::class,'create']);
  Route::post('/student/update', [StudentController::class,'update']);
  Route::post('/teacher/create', [TeacherController::class,'create']);
  Route::post('/teacher/update', [TeacherController::class,'update']);
});




