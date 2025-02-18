<?php


use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonVideo;
use Illuminate\Http\Request;
use App\Models\PurchaseCoupon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\API\Ad\AdController;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Call\CallController;
use App\Http\Controllers\API\Chat\ChatController;
use App\Http\Controllers\API\Post\PostController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\CompletedLessonController;
use App\Http\Controllers\API\Levels\LevelController;
use App\Http\Controllers\API\Course\CourseController;
use App\Http\Controllers\API\Lesson\LessonController;
use App\Http\Controllers\API\Review\ReviewController;
use App\Http\Controllers\API\Coupons\CouponController;
use App\Http\Controllers\API\Comment\CommentController;
use App\Http\Controllers\API\Payment\PaymentController;
use App\Http\Controllers\API\Section\SectionController;
use App\Http\Controllers\API\Student\StudentController;
use App\Http\Controllers\API\Subject\SubjectController;
use App\Http\Controllers\API\Teacher\TeacherController;
use App\Http\Controllers\API\Version\VersionController;
use App\Http\Controllers\API\Purchase\PurchaseController;
use App\Http\Controllers\API\Wishlist\WishlistController;
use App\Http\Controllers\API\Following\FollowingController;
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
    Route::post('/purchase/create', [PurchaseController::class, 'create']);
    Route::post('/purchase/update', [PurchaseController::class, 'update']);
    Route::post('/payment/get', [PaymentController::class, 'get']);
    Route::post('/payment/confirm', [PaymentController::class, 'confirm']);
    Route::post('/payment/info', [PaymentController::class, 'info']);
    Route::post('/user/deactivate', [UserController::class, 'deactivate']);

    Route::post('/lesson/complete', [CompletedLessonController::class, 'create']);

    Route::post('/notifications', [NotificationController::class, 'get']);

    Route::post('/notification/create', [NotificationController::class, 'create']);
    Route::post('/notification/read', [NotificationController::class, 'read']);

    Route::get('/progress', [SettingsController::class, 'progress']);
    Route::get('/stats', [SettingsController::class, 'stats']);

    Route::post('/following/create', [FollowingController::class, 'create']);
    Route::post('/following/get', [FollowingController::class, 'get']);

    Route::post('/chat/create', [ChatController::class, 'create']);
    Route::post('/chat/get', [ChatController::class, 'get']);
  });

  Route::post('/course/info', [CourseController::class, 'info']);
  Route::post('/user/info', [UserController::class, 'info']);

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

  Route::post('/post/get', [PostController::class, 'get']);
  Route::post('/post/create', [PostController::class, 'create']);
  Route::post('/post/update', [PostController::class, 'update']);
  Route::post('/post/delete', [PostController::class, 'delete']);
  Route::post('/post/restore', [PostController::class, 'restore']);
  Route::post('/post/like', [PostController::class, 'like']);

  Route::post('/comment/get', [CommentController::class, 'get']);
  Route::post('/comment/create', [CommentController::class, 'create']);
  Route::post('/comment/update', [CommentController::class, 'update']);
  Route::post('/comment/delete', [CommentController::class, 'delete']);
  Route::post('/comment/restore', [CommentController::class, 'restore']);
  Route::post('/comment/like', [CommentController::class, 'like']);

  Route::post('/call/create', [CallController::class, 'create']);
  Route::post('/call/update', [CallController::class, 'update']);

  Route::post('/coupon/validate', [CouponController::class, 'validateCoupon']);

  Route::post('/ad/get', [AdController::class, 'get']);

  Route::get('/info', [SettingsController::class, 'info']);

  Route::get('/policy', [SettingsController::class, 'policy']);

  Route::get('/about', [SettingsController::class, 'about']);

  Route::get('/version', [VersionController::class, 'get']);

  Route::get('/user/{id}/image/', [UserController::class, 'image']);

});

Route::post('v1/test', function(Request $request){
  $admins = \App\Models\User::where('role', 0)->where('status','ACTIVE')->pluck('id')->toArray();

      $beamsClient = new \Pusher\PushNotifications\PushNotifications(\App\Models\Setting::pusher_credentials());

      $publishResponse = $beamsClient->publishToUsers(
        array_map('strval', $admins),
        [
          "web" => [
            "notification" => [
              "title" => 'test',
              "body" => 'notification test',
              'deep_link' => url('dashboard/purchases'),
            ]
          ]
      ]);

});



