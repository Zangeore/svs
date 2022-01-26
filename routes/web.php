<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rooms',  [RoomController::class, 'list'])->name('rooms');
    Route::get('/room/{uuid}',  [RoomController::class, 'index']);

    Route::get('/profile',  [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile',  [ProfileController::class, 'update'])->name('profile');
});

require __DIR__.'/auth.php';
