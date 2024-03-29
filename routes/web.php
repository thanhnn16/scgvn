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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//    events
    Route::get('/events', [EventController::class, 'index'])->name('events-management');
    Route::get('/events/history', [EventController::class, 'eventHistory'])->name('events-history');
    Route::get('/events/download-template', [EventController::class, 'download'])->name('events.download-template');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/import-with-data', [EventController::class, 'importWithAllData'])->name('events.import-with-data');
    Route::post('/events/reset', [EventController::class, 'reset'])->name('events.reset');

    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::post('/events/duplicate', [EventController::class, 'duplicateEvent'])->name('events.duplicate');
    Route::post('/events/archive', [EventController::class, 'archive'])->name('events.archive');

    Route::get('/events/all', [EventController::class, 'showAll'])->name('events.all');
    Route::get('/events/ongoing', [EventController::class, 'showOngoing'])->name('events.ongoing');
    Route::get('/events/upcoming', [EventController::class, 'showUpcoming'])->name('events.upcoming');
    Route::get('/events/past', [EventController::class, 'showPast'])->name('events.past');
    Route::get('/events/filter', [EventController::class, 'filter'])->name('events.filter');
    Route::get('/events/filterWithStatus', [EventController::class, 'filterWithStatus'])->name('events.filterWithStatus');
    Route::get('/events/detail', [EventController::class, 'getEventData'])->name('events.get-data');

    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/export/{event}', [EventController::class, 'export'])->name('events.export');

    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

//    provinces
    Route::post('/provinces/import', [ProvinceController::class, 'import'])->name('provinces.import');

//    agencies
    Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies-management');
    Route::get('/agencies/create', [AgencyController::class, 'create'])->name('agencies.create');
    Route::post('/agencies', [AgencyController::class, 'store'])->name('agencies.store');
    Route::delete('/agencies/destroy', [AgencyController::class, 'destroy'])->name('agencies.destroy');
    Route::get('/agencies/detail/{agency}', [AgencyController::class, 'show'])->name('agencies.show');
    Route::post('/agencies/update', [AgencyController::class, 'update'])->name('agencies.update');
    Route::get('/agencies/{agency}/edit', [AgencyController::class, 'edit'])->name('agencies.edit');
    Route::get('/agencies/filter', [AgencyController::class, 'filter'])->name('agencies.filter');
    Route::get('/agencies/download-template', [AgencyController::class, 'download'])->name('agencies.download-template');
    Route::get('/agencies/export', [AgencyController::class, 'export'])->name('agencies.export');

//    event agencies
    Route::post('/event-agencies/store', [EventAgencyController::class, 'store'])->name('event-agencies.store');
    Route::post('/event-agencies/storeOrUpdate', [EventAgencyController::class, 'storeOrUpdate'])->name('event-agencies.store_update');
    Route::post('/event-agencies/add-prize/add', [EventAgencyController::class, 'addPrize'])->name('event-agencies.add-prize');
    Route::post('/event-agencies/{eventAgency}', [EventAgencyController::class, 'destroy'])->name('event-agencies.destroy');


//    prizes
    Route::get('/prizes', [PrizeController::class, 'index'])->name('prizes-management');
    Route::post('/prizes/store', [PrizeController::class, 'store'])->name('prizes.store');
    Route::delete('/prizes/{prize}', [PrizeController::class, 'destroy'])->name('prizes.destroy');
    Route::post('/prizes/update', [PrizeController::class, 'update'])->name('prizes.update');
    Route::post('/prizes/remaining/', [PrizeController::class, 'remaining'])->name('prizes.update-remaining');

//    spinner
    Route::get('/spinner-management', [SpinnerController::class, 'index'])->name('spinner.management');
    Route::get('/spinner/{event}', [SpinnerController::class, 'show'])->name('spinner.show');

//    backup
    Route::post('/backup', [EventController::class, 'backup'])->name('backup');

//    index
    Route::get('/dashboard', function () {
        return redirect()->route('index');
    })->name('dashboard');

    Route::get('/', [EventController::class, 'index'])->name('index');
});


Route::get('/form-dang-ky', function () {
    $provinces = Province::all();
    return view('forms.reg-form', compact('provinces'));
})->name('forms.dang-ky');

Route::get('/get-agencies', [AgencyController::class, 'getFromProvince'])->name('get-agencies');
Route::post('/get-agencies/register', [EventAgencyController::class, 'register'])->name('event-agencies.register');


require __DIR__ . '/auth.php';
