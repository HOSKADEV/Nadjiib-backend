<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Ad\AdController;
use App\Http\Controllers\API\Levels\LevelController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\Lesson\LessonController;
use App\Http\Controllers\API\Review\ReviewController;
use App\Http\Controllers\API\Coupons\CouponController;
use App\Http\Controllers\API\Section\SectionController;
use App\Http\Controllers\API\Student\StudentController;
use App\Http\Controllers\API\Subject\SubjectController;
use App\Http\Controllers\API\Teacher\TeacherController;
use App\Http\Controllers\API\Wishlist\WishlistController;
use App\Http\Controllers\API\Notification\NotificationController;

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
      'status' => true,
      'data' => new \App\Http\Resources\User\UserResource($request->user())
    ]);
  });
  Route::post('/user/get', [UserController::class, 'get']);
  Route::post('/auth/login',  [AuthController::class,'login']);

  Route::get('/home', [AuthController::class, 'home']);

  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/logout', [AuthController::class,'logout']);
    Route::get('/notification/get', [NotificationController::class, 'get']);
    Route::get('/course/purchase', [CourseController::class, 'purchase']);

  });

  Route::post('/section/get', [SectionController::class,'get']);
  Route::post('/level/get',   [LevelController::class,'get']);
  Route::post('/subject/get', [SubjectController::class,'get']);
  Route::post('/student/create', [StudentController::class,'create']);
  Route::post('/student/update', [StudentController::class,'update']);
  Route::post('/teacher/create', [TeacherController::class,'create']);
  Route::post('/teacher/update', [TeacherController::class,'update']);
  Route::post('/teacher/get', [TeacherController::class,'get']);
  // ** Router For courses
  Route::post('/course/all', [CourseController::class, 'all']);
  Route::post('/course/get', [CourseController::class, 'get']);
  Route::post('/course/create', [CourseController::class, 'create']);
  Route::post('/course/update', [CourseController::class, 'update']);
  Route::post('/course/delete', [CourseController::class, 'delete']);
  //  ** Router for Lessons
  Route::post('/lesson/get', [LessonController::class, 'get']);
  Route::post('/lesson/create', [LessonController::class, 'create']);
  Route::post('/lesson/update', [LessonController::class, 'update']);
  Route::post('/lesson/delete', [LessonController::class, 'delete']);
  //  ** Router for Reviews
  Route::post('/review/get', [ReviewController::class, 'get']);
  Route::post('/review/create', [ReviewController::class, 'create']);
  Route::post('/review/update', [ReviewController::class, 'update']);
  Route::post('/review/delete', [ReviewController::class, 'delete']);
  //  ** Route for wishlist
  Route::post('/wishlist/get', [WishlistController::class, 'get']);
  Route::post('/wishlist/create', [WishlistController::class, 'create']);
  Route::post('/wishlist/delete', [WishlistController::class, 'delete']);

  Route::post('/coupon/validate', [CouponController::class, 'validateCoupon']);

  Route::post('/ad/get', [AdController::class, 'get']);
});





