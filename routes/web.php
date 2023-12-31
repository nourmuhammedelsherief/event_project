<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

/**
 * start admin controllers
 */

use \App\Http\Controllers\AdminController\HomeController;
use \App\Http\Controllers\AdminController\Admin\LoginController;
use \App\Http\Controllers\AdminController\Admin\ForgotPasswordController;
use \App\Http\Controllers\AdminController\AdminController;
use \App\Http\Controllers\AdminController\DateController;
use \App\Http\Controllers\AdminController\SettingController;
use \App\Http\Controllers\AdminController\PeriodController;
use \App\Http\Controllers\AdminController\UserController;



use \App\Http\Controllers\Site\RegisterController;

/**
 * end admin controllers
 */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('locale/{locale}', function ($locale) {
    session(['locale' => $locale]);
    App::setLocale($locale);
    return redirect()->back();
})->name('language');

// user registration routes
Route::get('/get/periods/{id}' , [RegisterController::class , 'get_periods']);
Route::get('/registration' , [RegisterController::class , 'show_register']);
Route::post('/registration' , [RegisterController::class , 'register'])->name('registerNewUser');

Route::get('/show_barcode/{id}' , [RegisterController::class , 'show_barcode']);
Route::get('/barcode/details/{id}' , [RegisterController::class , 'barcode_details']);
Route::post('/confirm_attendance/{id}' , [RegisterController::class , 'confirm_attendance'])->name('confirm_attendance');

/**
 * Start @admin Routes
 */
Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
Route::prefix('admin')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('admin.login');
        Route::post('login', 'login')->name('admin.login.submit');
        Route::post('logout', 'logout')->name('admin.logout');
    });
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('admin.password.request');
        Route::post('password/email', 'sendResetLinkEmail')->name('admin.password.email');
        Route::get('password/reset/{token}', 'showResetForm')->name('admin.password.reset');
        Route::post('password/reset', 'reset')->name('admin.password.update');
    });

    Route::group(['middleware' => ['web', 'auth:admin']], function () {
        // Admins Route
        Route::resource('admins', AdminController::class, []);
        Route::controller(AdminController::class)->group(function () {
            Route::get('/profile', 'my_profile');
            Route::post('/profileEdit', 'my_profile_edit');
            Route::get('/profileChangePass', 'change_pass');
            Route::post('/profileChangePass', 'change_pass_update');
            Route::get('/admin_delete/{id}', 'admin_delete');
        });
        // dates routes
        Route::resource('dates' , DateController::class);
        Route::get('dates/delete/{id}' , [DateController::class , 'destroy']);

        // period routes
        Route::resource('periods' , PeriodController::class);
        Route::get('periods/delete/{id}' , [PeriodController::class , 'destroy']);


        Route::controller(UserController::class)->group(function () {
            Route::get('/users/{status}', 'index')->name('users.index');
            Route::get('/users/activate/{user}/{active}', 'active_user')->name('users.activate');
            Route::get('/users/delete/{id}', 'destroy')->name('users.destroy');
        });
        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings', 'setting')->name('settings.index');
            Route::post('/settings', 'store_setting')->name('store_setting');
        });
    });
});
/**
 * End @admin Routes
 */
