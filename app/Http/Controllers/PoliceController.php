<?php


namespace App\Http\Controllers;

use App\Models\Police;
use App\Models\Client;
use App\Models\TypeAssurance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PoliceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Police::with(['client', 'typeAssurance']);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('numero_police', 'LIKE', "%{$search}%")
                  ->orWhereHas('client', function ($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                  });
        }

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $polices = $query->latest()->paginate(10);

        return view('polices.index', compact('polices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clients = Client::orderBy('nom')->get();
        $typesAssurance = TypeAssurance::orderBy('nom')->get();

        // Pré-sélectionner un client si fourni
        $clientId = $request->client_id;

        return view('polices.create', compact('clients', 'typesAssurance', 'clientId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'type_assurance_id' => 'required|exists:type_assurances,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant' => 'required|numeric|min:0',
        ]);

        // Générer un numéro de police unique
        $validated['numero_police'] = 'POL-' . Str::random(8) . '-' . date('Y');

        $police = Police::create($validated);

        return redirect()->route('polices.show', $police)
            ->with('success', 'Police d\'assurance créée avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Police $police
     * @return \Illuminate\Http\Response
     */
    public function show(Police $police)
    {
        $police->load(['client', 'typeAssurance', 'sinistres', 'paiements']);

        return view('polices.show', compact('police'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Police $police
     * @return \Illuminate\Http\Response
     */
    public function edit(Police $police)
    {
        $clients = Client::orderBy('nom')->get();
        $typesAssurance = TypeAssurance::orderBy('nom')->get();

        return view('polices.edit', compact('police', 'clients', 'typesAssurance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Police $police
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Police $police)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'type_assurance_id' => 'required|exists:type_assurances,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant' => 'required|numeric|min:0',
            'statut' => 'required|in:active,expirée,résiliée',
        ]);

        $police->update($validated);

        return redirect()->route('polices.show', $police)
            ->with('success', 'Police d\'assurance mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Police $police
     * @return \Illuminate\Http\Response
     */
    public function destroy(Police $police)
    {
        $police->delete();

        return redirect()->route('polices.index')
            ->with('success', 'Police d\'assurance supprimée avec succès!');
    }
}