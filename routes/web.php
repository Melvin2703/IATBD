<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'block.blocked'], function () {
    Route::get('/', function () {
        return view('auth/login');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('posts', PostController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::delete('/requests/{user_id_request}/{post_id}', [RequestController::class, 'destroy'])->name('requests.destroy');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
        Route::get('/admin/{user}/block', [UserController::class, 'block'])->name('admin.block');
        Route::get('/admin/{user}/admin', [UserController::class, 'admin'])->name('admin.admin');
    });

    Route::get('/aanvragen/{id}/update-accepted', [RequestController::class, 'updateAccepted'])->name('update.accepted');

    Route::get('/user/{id}', [UserProfileController::class, 'show'])->name('user.profile');

    Route::get('/posts/filter', [PostController::class, 'filter'])->name('posts.filter');
});

Route::view('/blocked', 'blocked')->name('blocked_page');

require __DIR__.'/auth.php';