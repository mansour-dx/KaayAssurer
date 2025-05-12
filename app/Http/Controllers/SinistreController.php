<?php

namespace App\Http\Controllers;

use App\Models\Sinistre;
use App\Models\Police;
use Illuminate\Http\Request;

class SinistreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Sinistre::with(['police.client', 'police.typeAssurance']);
        
        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('police', function($q) use ($search) {
                      $q->where('numero_police', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('police.client', function($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                  });
        }
        
        // Filtrage par statut
        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }
        
        $sinistres = $query->latest()->paginate(10);
        
        return view('sinistres.index', compact('sinistres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $polices = Police::with('client')
                ->where('statut', 'active')
                ->get();
        
        // Pré-sélectionner une police si fournie
        $policeId = $request->police_id;
        
        return view('sinistres.create', compact('polices', 'policeId'));
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
            'police_id' => 'required|exists:polices,id',
            'date_sinistre' => 'required|date|before_or_equal:today',
            'description' => 'required|string',
            'montant_estime' => 'nullable|numeric|min:0',
            'statut' => 'required|in:en_attente,validé,refusé',
        ]);
        
        $sinistre = Sinistre::create($validated);
        
        return redirect()->route('sinistres.show', $sinistre)
            ->with('success', 'Sinistre déclaré avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sinistre  $sinistre
     * @return \Illuminate\Http\Response
     */
    public function show(Sinistre $sinistre)
    {
        $sinistre->load('police.client', 'police.typeAssurance');
        
        return view('sinistres.show', compact('sinistre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sinistre  $sinistre
     * @return \Illuminate\Http\Response
     */
    public function edit(Sinistre $sinistre)
    {
        $polices = Police::with('client')->get();
        
        return view('sinistres.edit', compact('sinistre', 'polices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sinistre  $sinistre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sinistre $sinistre)
    {
        $validated = $request->validate([
            'police_id' => 'required|exists:polices,id',
            'date_sinistre' => 'required|date|before_or_equal:today',
            'description' => 'required|string',
            'montant_estime' => 'nullable|numeric|min:0',
            'montant_rembourse' => 'nullable|numeric|min:0',
            'statut' => 'required|in:en_attente,validé,refusé',
        ]);
        
        $sinistre->update($validated);
        
        return redirect()->route('sinistres.show', $sinistre)
            ->with('success', 'Sinistre mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sinistre  $sinistre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sinistre $sinistre)
    {
        $sinistre->delete();
        
        return redirect()->route('sinistres.index')
            ->with('success', 'Sinistre supprimé avec succès!');
    }
}
