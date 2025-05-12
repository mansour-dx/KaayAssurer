<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Police;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Paiement::with(['police.client']);
        
        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('reference_transaction', 'LIKE', "%{$search}%")
                  ->orWhereHas('police', function($q) use ($search) {
                      $q->where('numero_police', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('police.client', function($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                  });
        }
        
        // Filtrage par date
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date_paiement', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date_paiement', '<=', $request->date_to);
        }
        
        $paiements = $query->latest()->paginate(10);
        
        return view('paiements.index', compact('paiements'));
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
        
        return view('paiements.create', compact('polices', 'policeId'));
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
            'date_paiement' => 'required|date',
            'montant' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string|max:255',
            'reference_transaction' => 'nullable|string|max:255',
        ]);
        
        $paiement = Paiement::create($validated);
        
        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement enregistré avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function show(Paiement $paiement)
    {
        $paiement->load('police.client', 'police.typeAssurance');
        
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function edit(Paiement $paiement)
    {
        $polices = Police::with('client')->get();
        
        return view('paiements.edit', compact('paiement', 'polices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'police_id' => 'required|exists:polices,id',
            'date_paiement' => 'required|date',
            'montant' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string|max:255',
            'reference_transaction' => 'nullable|string|max:255',
        ]);
        
        $paiement->update($validated);
        
        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        
        return redirect()->route('paiements.index')
            ->with('success', 'Paiement supprimé avec succès!');
    }
}
