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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth')->group(function() {
    route::get('/', [App\Http\Controllers\AdminController::class, 'DashboardView'])->name('admin');
});

Route::prefix('user')->middleware('auth')->group(function() {
    route::get('/', [App\Http\Controllers\UserController::class, 'DashboardView'])->name('user');
    route::get('/profile', [App\Http\Controllers\UserController::class, 'ProfileView'])->name('user_profile');
});

