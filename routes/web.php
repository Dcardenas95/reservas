<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Routing\RouteGroup;
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

Route::get('/', function () {
    return view('welcome');
});

Route::view('about', 'about');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::delete('/schedule/{scheduler}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    Route::get('/schedule/{scheduler}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{scheduler}/update', [ScheduleController::class, 'update'])->name('schedule.update');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
