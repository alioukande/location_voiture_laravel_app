
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\VoitureController;
use App\Models\Assurance;
use App\Models\Reservation;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\AvisController;





Route::middleware('auth:sanctum')->post(
    '/reservations',
    [ReservationController::class, 'store']
);


Route::get('/voitures', [VoitureController::class, 'index']);

Route::get('/assurances', function () {
    return Assurance::all();
});

Route::get('/reservations', function () {
    return Reservation::with(['voiture', 'assurance', 'user'])->get();
});



Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);


Route::get('/mes-reservations/{user_id}', function ($user_id) {

    $reservations = Reservation::with([
        'voiture',
        'assurance',
        'avis'
    ])
    ->where('user_id', $user_id)
    ->orderBy('id', 'desc')
    ->get();

    $reservations->each(function ($reservation) {
        $reservation->has_avis = $reservation->avis !== null;
    });

    return $reservations;
});

Route::get('/test-mail', function () {

    Mail::raw('Email de test' , function ($message) {
        $message->to('kandealiou687@gmail.com')
                ->subject('Test Mailtrap');
    });

    return 'Email envoyé';
});



Route::middleware('auth:sanctum')->put(
    '/profile',
    [AuthController::class, 'updateProfile']
);

Route::middleware('auth:sanctum')->post(
    '/profile/photo',
    [AuthController::class, 'updatePhoto']
);

Route::middleware('auth:sanctum')->post(
    '/reservations/{id}/annuler',
    [ReservationController::class, 'annuler']
);




Route::middleware('auth:sanctum')->group(function () {

    Route::post('/avis', [AvisController::class, 'store']);




});

      Route::get('/voitures/{id}/avis', [AvisController::class, 'index']);








