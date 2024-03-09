<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\EventAgencyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SpinnerController;
use App\Models\Province;
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

Route::get('/form-dang-ky', function () {
    $provinces = Province::all();
    return view('forms.reg-form', compact('provinces'));
})->name('forms.dang-ky');

Route::get('/get-agencies', [AgencyController::class, 'getFromProvince'])->name('get-agencies');

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
    Route::get('/events/history', [EventController::class, 'eventHistory'])->name('events-history');
    Route::get('/events/download-template', [EventController::class, 'download'])->name('events.download-template');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/import-with-data', [EventController::class, 'importWithAllData'])->name('events.import-with-data');

    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');

    Route::get('/events/all', [EventController::class, 'showAll'])->name('events.all');
    Route::get('/events/ongoing', [EventController::class, 'showOngoing'])->name('events.ongoing');
    Route::get('/events/upcoming', [EventController::class, 'showUpcoming'])->name('events.upcoming');
    Route::get('/events/past', [EventController::class, 'showPast'])->name('events.past');
    Route::get('/events/filter', [EventController::class, 'filter'])->name('events.filter');
    Route::get('/events/detail', [EventController::class, 'getEventData'])->name('events.get-data');

    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

//    provinces
    Route::post('/provinces/import', [ProvinceController::class, 'import'])->name('provinces.import');

//    agencies
    Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies-management');
    Route::get('/agencies/create', [AgencyController::class, 'create'])->name('agencies.create');
    Route::post('/agencies', [AgencyController::class, 'store'])->name('agencies.store');
    Route::get('/agencies/{agency}', [AgencyController::class, 'show'])->name('agencies.show');
    Route::get('/agencies/{agency}/edit', [AgencyController::class, 'edit'])->name('agencies.edit');
    Route::get('/agencies/filter', [AgencyController::class, 'filter'])->name('agencies.filter');

//    event agencies
    Route::post('/event-agencies/store', [EventAgencyController::class, 'store'])->name('event-agencies.store');


//    prizes
    Route::get('/prizes', [PrizeController::class, 'index'])->name('prizes-management');
    Route::post('/prizes/store', [PrizeController::class, 'store'])->name('prizes.store');

//    spinner
    Route::get('/spinner-management', [SpinnerController::class, 'index'])->name('spinner.management');
    Route::get('/spinner/{event}', [SpinnerController::class, 'show'])->name('spinner.show');

//    backup
    Route::post('/backup', [EventController::class, 'backup'])->name('backup');

//    index
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
