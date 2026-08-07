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

return view('admin.assurances.create');

}
 
   
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


        return redirect()->route('assurances.index')->with('succes', 'assurance ajoutee');
      
    }

   

    
    public function edit(Assurance $assurance)
    {
            $assurances=Assurance::all();

        return view('admin.assurances.edit', compact('assurance', 'assurances'));
       
    }

    
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



        return redirect()->route('assurances.index')->with('succes', 'assurance modifiee');


       
    }

    
    public function destroy(Assurance $assurance)
    {
        $assurance->delete();
        return redirect()->route('assurances.index')->with('succes', 'assurance supprimer');
       
    }




   
}
