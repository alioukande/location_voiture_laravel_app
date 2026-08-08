<?php
 use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoitureController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AssuranceController;
use App\Http\Controllers\Admin\AvisController;

const PROFILE_ROUTE = '/profile';


Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get(PROFILE_ROUTE, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILE_ROUTE, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILE_ROUTE, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function() {

     Route::get('/voitures', [VoitureController::class, 'index'])->name('voitures.index');


     Route::get('/voitures/create', [VoitureController::class, 'create'])->name('voitures.create');

     Route::get('/voitures/{id}', [VoitureController::class, 'show'])->name('voitures.show');

     Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.dashboard');
    Route::get('/admin/avis', [AvisController::class, 'index'])
    ->name('admin.avis.index');

Route::delete('/admin/avis/{avis}', [AvisController::class, 'destroy'])
    ->name('admin.avis.destroy');

    Route::put(
    '/admin/avis/{avis}/repondre',
    [AvisController::class, 'repondre']
)->name('admin.avis.repondre');



    Route::resource('voitures', VoitureController::class)->middleware('auth');

       



Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('reservations', AdminReservationController::class);
         Route::get('/voitures', [VoitureController::class, 'index'])->name('voitures.index');
         Route::resource('assurances', AssuranceController::class);



   
    Route::post('reservations/{reservation}/confirmer', [AdminReservationController::class, 'confirmer'])->name('reservations.confirmer');
    Route::post('reservations/{reservation}/annuler', [AdminReservationController::class, 'annuler'])->name('reservations.annuler');
    Route::post('reservations/{reservation}/terminer', [AdminReservationController::class, 'terminer'])->name('reservations.terminer');
});







   




});

