<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\ProfileController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//    dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

//    events
    Route::get('/events', [EventController::class, 'index'])->name('events-management');


//    agencies
    Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies-management');


//    prizes
    Route::get('/prizes', [PrizeController::class, 'index'])->name('prizes-management');


//    index
    Route::get('/', function () {
        return view('index');
    })->name('index');
});

require __DIR__ . '/auth.php';
