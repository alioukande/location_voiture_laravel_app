<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assurance;

class AssuranceController extends Controller
{
    public function index()
{
    $assurances=Assurance::all();
    return view('admin.assurances.index', compact('assurances'));
}



public function create()
{
    // $assurances=Assurance::all();

return view('admin.assurances.create');

}
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'=>'required|string',
            'description'=>'nullable|string',
            'prix_base'=>'required|numeric',
        ]);

        Assurance::create([
            'type'=>$request->type,
            'description'=>$request->description,
            'prix_base'=>$request->prix_base,
        ]);
        Assurance::create($request->only('type','description','prix_base'));


        return redirect()->route('assurances.index')->with('succes', 'assurance ajoutee');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assurance $assurance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assurance $assurance)
    {
            $assurances=Assurance::all();

        return view('admin.assurances.edit', compact('assurance', 'assurances'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assurance $assurance)
    {
        $request->validate([
            'type'=>'required|string',
            'description'=>'required|string',
            'prix_base'=>'required|numeric|min:0',

        ]);

        $assurance->update([
            'type'=>$request->type,
            'description'=>$request->description,
            'prix_base'=>$request->prix_base,
        ]);

                // Assurance::update($request->only('type','description','prix_base'));


        return redirect()->route('assurances.index')->with('succes', 'assurance modifiee');


        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assurance $assurance)
    {
        // dd($assurance->id);
        $assurance->delete();
        return redirect()->route('assurances.index')->with('succes', 'assurance supprimer');
        //
    }




    //
}
