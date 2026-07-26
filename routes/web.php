<?php
 // ← AJOUTE CETTE LIGNE
 use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoitureController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AssuranceController;
use App\Http\Controllers\Admin\AvisController;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('home');
});

// Route::get('/media/{path}', function ($path) {
//     if (!Storage::disk('public')->exists($path)) {
//         abort(404);
//     }

//     $file = Storage::disk('public')->path($path);

//     return response()->file($file, [
//         'Access-Control-Allow-Origin' => '*',
//     ]);
// })->where('path', '.*');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function() {

     Route::get('/voitures', [VoitureController::class, 'index'])->name('voitures.index');


     Route::get('/voitures/create', [VoitureController::class, 'create'])->name('voitures.create');

     Route::get('/voitures/{id}', [VoitureController::class, 'show'])->name('voitures.show');

     Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('admin.dashboard');
    // route pour les avis
    Route::get('/admin/avis', [AvisController::class, 'index'])
    ->name('admin.avis.index');

Route::delete('/admin/avis/{avis}', [AvisController::class, 'destroy'])
    ->name('admin.avis.destroy');

    Route::put(
    '/admin/avis/{avis}/repondre',
    [AvisController::class, 'repondre']
)->name('admin.avis.repondre');

// fin routes pour les avis

    Route::resource('voitures', VoitureController::class)->middleware('auth');

       

// Routes assurances:

// Route::resource('assurances', AssuranceController::class);

// routes Reservations:


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes admin réservations
    Route::resource('reservations', AdminReservationController::class);
         Route::get('/voitures', [VoitureController::class, 'index'])->name('voitures.index');
         Route::resource('assurances', AssuranceController::class);



    // Actions statut
    Route::post('reservations/{reservation}/confirmer', [AdminReservationController::class, 'confirmer'])->name('reservations.confirmer');
    Route::post('reservations/{reservation}/annuler', [AdminReservationController::class, 'annuler'])->name('reservations.annuler');
    Route::post('reservations/{reservation}/terminer', [AdminReservationController::class, 'terminer'])->name('reservations.terminer');
});


// Route::get('/image/{filename}', function ($filename) {

//     $path = storage_path('app/public/voitures/' . $filename);

//     if (!File::exists($path)) {
//         return "Fichier introuvable";
//     }

//     return response()->file($path);
// });



// Route::get('/api/voitures', function () {
//     return \App\Models\Voiture::all();
// });


   



// // routes pour les reservations

//     Route::get('/reservations/create/{voitureId}', [ReservationController::class, 'create'])->name('reservations.create');
//     Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
//     Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');

});

