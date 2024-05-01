<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CmsPageController as AdminCmsPageController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('login'); // Match is used when using same route for different methods
    Route::get('register', [AdminController::class, 'register']);
    Route::post('register', [AdminController::class, 'registerStore']);
    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login', [AdminController::class, 'loginStore']);
    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('change_password', [AdminController::class, 'password']);
        Route::post('change_password', [AdminController::class, 'passwordStore']);
        Route::get('update_profile', [AdminController::class, 'profile']);
        Route::post('update_profile', [AdminController::class, 'updateProfile']);

        /*
        |--------------------------------------------------------------------------
        | CMS PAGES RESOURCE ROUTES
        |--------------------------------------------------------------------------
        |
        */
        Route::resource('cms_page', AdminCmsPageController::class);
        Route::post('cms_page/update_cms_status', [AdminCmsPageController::class, 'updateCmsStatus']);

    });
});
