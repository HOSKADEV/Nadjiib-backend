<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'App\Http\Controllers\dashboard\Analytics@index')->name('dashboard-analytics')->middleware('auth');

// layout
Route::group(['middleware' => ['auth']], function () {
  Route::get('/layouts/without-menu', 'App\Http\Controllers\layouts\WithoutMenu@index')->name('layouts-without-menu');
  Route::get('/layouts/without-navbar', 'App\Http\Controllers\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
  Route::get('/layouts/fluid', 'App\Http\Controllers\layouts\Fluid@index')->name('layouts-fluid');
  Route::get('/layouts/container', 'App\Http\Controllers\layouts\Container@index')->name('layouts-container');
  Route::get('/layouts/blank', 'App\Http\Controllers\layouts\Blank@index')->name('layouts-blank');
});
// pages
Route::group(['middleware' => ['auth']], function () {
  Route::get('/pages/account-settings-account', 'App\Http\Controllers\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
  Route::get('/pages/account-settings-notifications', 'App\Http\Controllers\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
  Route::get('/pages/account-settings-connections', 'App\Http\Controllers\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
  Route::get('/pages/misc-error', 'App\Http\Controllers\pages\MiscError@index')->name('pages-misc-error');
  Route::get('/pages/misc-under-maintenance', 'App\Http\Controllers\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');
});
// authentication
Route::get('/auth/login-basic', 'App\Http\Controllers\authentications\LoginBasic@index')->name('login');
Route::get('/auth/register-basic', 'App\Http\Controllers\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::post('/auth/register-action', 'App\Http\Controllers\authentications\RegisterBasic@register');
Route::post('/auth/login-action', 'App\Http\Controllers\authentications\LoginBasic@login');
Route::get('/auth/forgot-password-basic', 'App\Http\Controllers\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
Route::get('/auth/logout', 'App\Http\Controllers\authentications\LogoutBasic@logout')->name('auth-logout');

// cards
Route::group(['middleware' => ['auth']], function () {
  Route::get('/cards/basic', 'App\Http\Controllers\cards\CardBasic@index')->name('cards-basic');
});
// User Interface
Route::group(['middleware' => ['auth']], function () {
  Route::get('/ui/accordion', 'App\Http\Controllers\user_interface\Accordion@index')->name('ui-accordion');
  Route::get('/ui/alerts', 'App\Http\Controllers\user_interface\Alerts@index')->name('ui-alerts');
  Route::get('/ui/badges', 'App\Http\Controllers\user_interface\Badges@index')->name('ui-badges');
  Route::get('/ui/buttons', 'App\Http\Controllers\user_interface\Buttons@index')->name('ui-buttons');
  Route::get('/ui/carousel', 'App\Http\Controllers\user_interface\Carousel@index')->name('ui-carousel');
  Route::get('/ui/collapse', 'App\Http\Controllers\user_interface\Collapse@index')->name('ui-collapse');
  Route::get('/ui/dropdowns', 'App\Http\Controllers\user_interface\Dropdowns@index')->name('ui-dropdowns');
  Route::get('/ui/footer', 'App\Http\Controllers\user_interface\Footer@index')->name('ui-footer');
  Route::get('/ui/list-groups', 'App\Http\Controllers\user_interface\ListGroups@index')->name('ui-list-groups');
  Route::get('/ui/modals', 'App\Http\Controllers\user_interface\Modals@index')->name('ui-modals');
  Route::get('/ui/navbar', 'App\Http\Controllers\user_interface\Navbar@index')->name('ui-navbar');
  Route::get('/ui/offcanvas', 'App\Http\Controllers\user_interface\Offcanvas@index')->name('ui-offcanvas');
  Route::get('/ui/pagination-breadcrumbs', 'App\Http\Controllers\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
  Route::get('/ui/progress', 'App\Http\Controllers\user_interface\Progress@index')->name('ui-progress');
  Route::get('/ui/spinners', 'App\Http\Controllers\user_interface\Spinners@index')->name('ui-spinners');
  Route::get('/ui/tabs-pills', 'App\Http\Controllers\user_interface\TabsPills@index')->name('ui-tabs-pills');
  Route::get('/ui/toasts', 'App\Http\Controllers\user_interface\Toasts@index')->name('ui-toasts');
  Route::get('/ui/tooltips-popovers', 'App\Http\Controllers\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
  Route::get('/ui/typography', 'App\Http\Controllers\user_interface\Typography@index')->name('ui-typography');
});
// extended ui
Route::group(['middleware' => ['auth']], function () {
  Route::get('/extended/ui-perfect-scrollbar', 'App\Http\Controllers\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
  Route::get('/extended/ui-text-divider', 'App\Http\Controllers\extended_ui\TextDivider@index')->name('extended-ui-text-divider');
});
// icons
Route::group(['middleware' => ['auth']], function () {
  Route::get('/icons/boxicons', 'App\Http\Controllers\icons\Boxicons@index')->name('icons-boxicons');
});
// form elements
Route::group(['middleware' => ['auth']], function () {
  Route::get('/forms/basic-inputs', 'App\Http\Controllers\form_elements\BasicInput@index')->name('forms-basic-inputs');
  Route::get('/forms/input-groups', 'App\Http\Controllers\form_elements\InputGroups@index')->name('forms-input-groups');
});
// form layouts
Route::group(['middleware' => ['auth']], function () {
  Route::get('/form/layouts-vertical', 'App\Http\Controllers\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
  Route::get('/form/layouts-horizontal', 'App\Http\Controllers\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');
});
// tables
Route::group(['middleware' => ['auth']], function () {
  Route::get('/tables/basic', 'App\Http\Controllers\tables\Basic@index')->name('tables-basic');
});

