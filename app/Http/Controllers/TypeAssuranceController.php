<?php

namespace App\Http\Controllers;

use App\Models\TypeAssurance;
use Illuminate\Http\Request;

class TypeAssuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
{
    // Récupérer tous les types d'assurance et les paginer
    $typeAssurances = TypeAssurance::orderBy('nom')->paginate(10);
    
    // Passer la variable $typeAssurances à la vue
    return view('type-assurances.index', compact('typeAssurances'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type-assurances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:type_assurances',
            'description' => 'required|string',
            'prix_base' => 'required|numeric|min:0',
        ]);
        
        $typeAssurance = TypeAssurance::create($validated);
        
        return redirect()->route('type-assurances.index')
            ->with('success', 'Type d\'assurance créé avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeAssurance  $typeAssurance
     * @return \Illuminate\Http\Response
     */
    public function show(TypeAssurance $typeAssurance)
    {
        $typeAssurance->load('polices');
        
        return view('type-assurances.show', compact('typeAssurance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeAssurance  $typeAssurance
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeAssurance $typeAssurance)
    {
        return view('type-assurances.edit', compact('typeAssurance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeAssurance  $typeAssurance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeAssurance $typeAssurance)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:type_assurances,nom,'.$typeAssurance->id,
            'description' => 'required|string',
            'prix_base' => 'required|numeric|min:0',
        ]);
        
        $typeAssurance->update($validated);
        
        return redirect()->route('type-assurances.index')
            ->with('success', 'Type d\'assurance mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeAssurance  $typeAssurance
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeAssurance $typeAssurance)
    {
        // Vérifier si ce type d'assurance est utilisé par des polices
        if ($typeAssurance->polices()->count() > 0) {
            return redirect()->route('type-assurances.index')
                ->with('error', 'Impossible de supprimer ce type d\'assurance car il est utilisé par des polices existantes.');
        }
        
        $typeAssurance->delete();
        
        return redirect()->route('type-assurances.index')
            ->with('success', 'Type d\'assurance supprimé avec succès!');
    }
}
