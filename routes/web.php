<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
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
    Route::get('login', [AdminController::class, 'login'])->name('login');
    Route::post('login', [AdminController::class, 'loginStore']);
    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('change_password', [AdminController::class, 'password']);
        Route::post('change_password', [AdminController::class, 'passwordStore']);
        Route::get('update_profile', [AdminController::class, 'profile']);
        Route::post('update_profile', [AdminController::class, 'updateProfile']);

        Route::get('subadmins', [AdminController::class, 'subadmins']);
        Route::get('subadmin/register', [AdminController::class, 'register']);
        Route::post('subadmin/register', [AdminController::class, 'registerStore']);
        Route::get('subadmin/{admin}/edit', [AdminController::class, 'edit']);
        Route::put('subadmin/{admin}', [AdminController::class, 'update']);
        Route::post('subadmin/update_admin_status', [AdminController::class, 'updateAdminStatus']);
        // Update admin access
        Route::get('subadmin/{admin}/roles', [AdminController::class, 'editAdminRoles']);
        Route::put('subadmin/{admin}/roles', [AdminController::class, 'updateAdminRoles']);
        // Delete admin
        Route::delete('subadmin/{admin}', [AdminController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | CMS PAGES RESOURCE ROUTES
        |--------------------------------------------------------------------------
        |
        */
        Route::resource('cms_page', AdminCmsPageController::class);
        Route::post('cms_page/update_cms_status', [AdminCmsPageController::class, 'updateCmsStatus']);

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES RESOURCE ROUTES
        |--------------------------------------------------------------------------
        |
        */
        Route::resource('categories', CategoryController::class);
        Route::post('categories/update_category_status', [CategoryController::class, 'updateCategoryStatus']);

    });
});
