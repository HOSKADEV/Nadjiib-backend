<?php


use App\Http\Controllers\Dashboard\Wallet\WalletController;
use App\Models\Course;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Dashboard\Ad\AdController;
use App\Http\Controllers\Dashboard\Post\PostController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Levels\LevelController;
use App\Http\Controllers\Dashboard\Coupon\CouponController;
use App\Http\Controllers\Dashboard\Course\CourseController;
use App\Http\Controllers\Dashboard\Lesson\LessonController;
use App\Http\Controllers\Dashboard\Payment\PaymentController;
use App\Http\Controllers\Dashboard\Section\SectionController;
use App\Http\Controllers\Dashboard\Setting\SettingController;
use App\Http\Controllers\Dashboard\Subject\SubjectController;
use App\Http\Controllers\Dashboard\Teacher\TeacherController;
use App\Http\Controllers\Dashboard\Purchase\PurchaseController;
use App\Http\Controllers\Dashboard\Analytics\AnalyticsController;
use App\Http\Controllers\Dashboard\AppSetting\AppSettingController;
use App\Http\Controllers\Dashboard\LevelSubject\LevelSubjectController;
use App\Http\Controllers\Dashboard\Notification\NotificationController;

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

Route::get('/',[AnalyticsController::class, 'landing'])->name('landing');
Route::get('/dashboard',[AnalyticsController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/stats',[AnalyticsController::class, 'stats'])->name('stats')->middleware(['auth','role']);



// authentication
Route::get('/auth/login-basic', 'App\Http\Controllers\authentications\LoginBasic@index')->name('login');
Route::get('/auth/register-basic', 'App\Http\Controllers\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::post('/auth/register-action', 'App\Http\Controllers\authentications\RegisterBasic@register');
Route::post('/auth/login-action', 'App\Http\Controllers\authentications\LoginBasic@login');
Route::get('/auth/forgot-password-basic', 'App\Http\Controllers\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/logout', 'App\Http\Controllers\authentications\LogoutBasic@logout')->name('auth-logout');
Route::get('/privacy_policy', 'App\Http\Controllers\DocumentationController@privacy_policy')->name('privacy-policy');
Route::get('/terms_of_use', 'App\Http\Controllers\DocumentationController@about')->name('terms-of-use');


Route::get('/error', 'App\Http\Controllers\pages\MiscError@index')->name('error');
Route::get('/under-maintenance', 'App\Http\Controllers\pages\MiscUnderMaintenance@index')->name('under-maintenance');

Route::get('/chargily/success', 'App\Http\Controllers\API\Purchase\PurchaseController@chargily')->name('chargily-success');
Route::get('/chargily/failed', 'App\Http\Controllers\API\Purchase\PurchaseController@chargily')->name('chargily-failed');

Route::get('/purchase/success', 'App\Http\Controllers\API\Purchase\PurchaseController@success')->name('purchase-success');
Route::get('/purchase/failed', 'App\Http\Controllers\API\Purchase\PurchaseController@failed')->name('purchase-failed');

Route::get('/auth/redirect', 'App\Http\Controllers\authentications\LoginBasic@redirect')->name('google.redirect');
Route::get('/auth/callback', 'App\Http\Controllers\authentications\LoginBasic@callback')->name('google.callback');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth','role']], function () {
    Route::resource('sections', SectionController::class);
    Route::resource('levels', LevelController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('level-subjects', LevelSubjectController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('ads', AdController::class);
    Route::resource('users', UserController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('notices', NotificationController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('app-setting', AppSettingController::class);
    Route::resource('wallet', WalletController::class);
    Route::get('users/wallet/{user}',[UserController::class,'wallet'])->name('users.wallet');
    Route::put('wallet/transaction/status', [UserController::class, 'updateTransaction'])->name('wallet.update');

    Route::post('notices/broadcast', [NotificationController::class, 'broadcast'])->name('notices.broadcast');

    Route::get('/course/{id}/lessons', [LessonController::class,'index'])->name('course.lessons');
    Route::get('/course/{id}/lesson/create', [LessonController::class,'create'])->name('lessons.create');
    Route::post('/lesson/store', [LessonController::class,'store'])->name('lessons.store');
    Route::post('/lesson/delete', [LessonController::class,'delete'])->name('lessons.delete');
    Route::post('/lesson/video/upload', [LessonController::class, 'upload_video'])->name('lesson.video');
    Route::post('/lesson/files/upload', [LessonController::class, 'upload_files'])->name('lesson.files');

    Route::post('users/upgrade', [UserController::class, 'upgradeAccount'])->name('users.upgrade');
    Route::put('users/status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::put('teachers/status', [TeacherController::class, 'changeStatus'])->name('teachers.changeStatus');
    Route::get('/payment/{id}/purchases', [PaymentController::class,'purchases'])->name('payment-purchases');
    Route::get('/post/index', [PostController::class,'index'])->name('posts.index');
    Route::post('/post/delete', [PostController::class,'delete'])->name('posts.delete');

    Route::get('/settings', [SettingController::class,'index']);
    Route::post('/version/update', [SettingController::class,'version']);
    Route::post('/setting/update', [SettingController::class,'update']);
    Route::get('/documentation/policy',[SettingController::class,'doc_index'])->name('documentation.policy');
    Route::get('/documentation/about',[SettingController::class,'doc_index'])->name('documentation.about');
    Route::post('/documentation/update',[SettingController::class,'documentation']);
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth']], function () {
  Route::resource('courses', \App\Http\Controllers\User\Course\CourseController::class);
  Route::resource('posts', \App\Http\Controllers\User\Post\PostController::class);
  Route::get('/course/{id}/lessons', [\App\Http\Controllers\User\Lesson\LessonController::class,'index'])->name('course.lessons');
  Route::get('/course/{id}/lesson/create', [\App\Http\Controllers\User\Lesson\LessonController::class,'create'])->name('lessons.create');
  Route::post('/courses/video/upload', [\App\Http\Controllers\User\Course\CourseController::class, 'upload_video'])->name('course.video');
  Route::post('/courses/image/upload', [\App\Http\Controllers\User\Course\CourseController::class, 'upload_image'])->name('course.image');
  Route::post('/lesson/store', [\App\Http\Controllers\User\Lesson\LessonController::class,'store'])->name('lessons.store');
  Route::post('/lesson/delete', [\App\Http\Controllers\User\Lesson\LessonController::class,'delete'])->name('lessons.delete');
  Route::post('/lesson/video/upload', [\App\Http\Controllers\User\Lesson\LessonController::class, 'upload_video'])->name('lesson.video');
  Route::post('/lesson/files/upload', [\App\Http\Controllers\User\Lesson\LessonController::class, 'upload_files'])->name('lesson.files');

  Route::get('/post/index', [\App\Http\Controllers\User\Post\PostController::class,'index'])->name('posts.index');
  Route::post('/post/delete', [\App\Http\Controllers\User\Post\PostController::class,'delete'])->name('posts.delete');
  Route::post('/post/create', [\App\Http\Controllers\User\Post\PostController::class,'create'])->name('posts.create');
});


Route::get('/theme/{theme}', function ($theme) {
    Session::put('theme', $theme);
    return redirect()->back();
});

Route::get('/lang/{lang}', function ($lang) {
    Session::put('locale', $lang);
    App::setLocale($lang);
    return redirect()->back();
});

Route::get('/pusher/beams-auth', function (Request $request) {

  $userID = $request->user()->id;
  $userIDInQueryParam = $request->user_id;

  $beamsClient = new \Pusher\PushNotifications\PushNotifications(Setting::pusher_credentials());

  if ($userID != $userIDInQueryParam) {
      return response('Inconsistent request', 401);
  } else {
      $beamsToken = $beamsClient->generateToken($userID);
      return response()->json($beamsToken);
  }
});



