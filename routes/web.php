<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{ContentController, UserController, RolesController, PermissionsController};
Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->get('dashboard', action: [ContentController::class, 'dashboard'])->name('dashboard');
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    Route::resource('user', UserController::class);

    Route::prefix('/rap')->name('rap.')->group(function () {
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
        Route::get('/', [RolesController::class, 'rap'])->name('rap.list');
    });
});
