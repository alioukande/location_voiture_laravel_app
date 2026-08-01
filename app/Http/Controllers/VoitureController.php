<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Assurance;

use Illuminate\Http\Request;

class VoitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voitures=Voiture::with('assurances')->get();
        return view('admin.voitures.index', compact('voitures'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $assurances = Assurance::all();

        return view('admin.voitures.create', compact('assurances'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {
        // dd($voiture->image, $voiture->getTable());


        $request->validate([
            
            'model'=>'required|string',
            'marque'=>'required|string',
            'prix_par_jour'=>'required|numeric',
            'annee' => 'required|integer|min:1990|max:'.date('Y'),
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
            'statut'=>'required|string',
            'assurances'=>'nullable | array',
            'assurances.*'=>'exists:assurances,id',


        ]);

        $imagePath= null;

        if ($request->hasfile('image')){
            $imagePath=$request->file('image')->store('voitures','public');
            // dd($imagePath);
        }

        $voiture=Voiture::create([
            
            'model'=>$request->model,
            'marque'=>$request->marque,
            'prix_par_jour'=>$request->prix_par_jour,
            'annee'=>$request->annee,
            'image'=>$imagePath,
            'statut'=>$request->statut,
        ]);


        if($request->has('assurances')){
            $voiture->assurances()->sync($request->assurances);

        }

        return redirect()->route('voitures.index');


        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Voiture $voiture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voiture $voiture)
    {
        $assurances=Assurance::all();

        return view('admin.voitures.edit' , compact('voiture', 'assurances'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voiture $voiture)
    {
        $request->validate([
            'model'=>'required|string',
            'marque'=>'required|string',
            'prix_par_jour'=>'required|numeric',
            'annee'=>'required|integer|min:1990|max:'.date('Y'),
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
            'statut'=>'required|string',
             'assurances'=>'nullable|array',
            'assurances.*'=>'exists:assurances,id',


        ]); 
        $imagePath=$voiture->image;
        if($request->hasfile('iamge')){
            if($voiture->image && file_exists(storage_path('app/public/'.$voiture->image))){
                unlink(storage_path('app/public/'.$voiture->image));
            }
        }
        $imagePath=$request->file('image')->store('voitures','public');

        $voiture->update([
            'model'=>$request->model,
            'marque'=>$request->marque,
            'prix_par_jour'=>$request->prix_par_jour,
            'annee'=>$request->annee,
            'image'=>$imagePath,
            'statut'=>$request->statut,
        ]);
        $voiture->assurances()->sync($request->assurances ?? []  );

        return redirect()->route('voitures.index')->with('succes','voiture mise a jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voiture $voiture)
    {
        if($voiture->image && file_exists(storage_path('app/public/'.$voiture->image))){
            unlink(storage_path('app/public/'.$voiture->image));
        }
        //
        $voiture->delete();

         return redirect()->route('voitures.index')->with('succes' ,'voiture supprimer !');
    }

    
}
