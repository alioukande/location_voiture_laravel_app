<!-- <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Reservation;
// use App\Models\Voiture;
// use App\Models\Assurance;


// class ReservationController extends Controller
// {

    // Formulaire
    // public function create($voitureId)
    // {
    //     $voiture = Voiture::with('assurances')->findOrFail($voitureId);

    //     return view('reservations.create', compact('voiture'));
    // }


    // STORE
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'voiture_id' => 'required|exists:voitures,id',
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'start_time' => 'required',
    //         'end_time' => 'required',
    //         'date_reservation' => 'required|date',
    //         'assurances' => 'nullable|array',
    //         'assurances.*' => 'exists:assurances,id',
    //     ]);


    // $voiture = Voiture::find($request->voiture_id);
    // $assuranceIds = $request->input('assurances', []);
    // $totalAssurances = Assurance::whereIn('id', $assuranceIds)->sum('prix_base');
    // $total = $voiture->prix_par_jour + $totalAssurances;

        // créer réservation
        // $reservation = Reservation::create([
        //     'voiture_id' => $voiture->id,
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'start_time' => $data['start_time'],
        //     'end_time' => $data['end_time'],
        //     'date_reservation' => $data['date_reservation'],
        //     'total_price' => $total,
        // ]);

        // sync pivot assurances
    //     $reservation->assurances()->sync($assuranceIds);

    //     return redirect()->route('reservations.show', $reservation->id);
    // }


    // SHOW
//     public function show($id)
//     {
//         $reservation = Reservation::with('voiture', 'assurances')->findOrFail($id);

//         return view('reservations.show', compact('reservation'));
//     }

// } -->
