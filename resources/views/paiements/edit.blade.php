@extends('app')

@section('title', 'Modifier Paiement')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 bg-green-500 text-white">
        <h3 class="text-lg leading-6 font-medium">Modifier un Paiement</h3>
        <p class="mt-1 max-w-2xl text-sm">Modification des informations du paiement</p>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <form action="{{ route('paiements.update', $paiement) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label for="police_id" class="block text-sm font-medium text-gray-700">Police d'assurance</label>
                <select name="police_id" id="police_id" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @foreach($polices as $police)
                        <option value="{{ $police->id }}" {{ old('police_id', $paiement->police_id) == $police->id ? 'selected' : '' }}>
                            {{ $police->numero_police }} - {{ $police->client->nom }} {{ $police->client->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('police_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="date_paiement" class="block text-sm font-medium text-gray-700">Date du paiement</label>
                <input type="date" name="date_paiement" id="date_paiement" value="{{ old('date_paiement', $paiement->date_paiement) }}" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('date_paiement')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="montant" class="block text-sm font-medium text-gray-700">Montant (€)</label>
                <input type="number" step="0.01" name="montant" id="montant" value="{{ old('montant', $paiement->montant) }}" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('montant')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="methode_paiement" class="block text-sm font-medium text-gray-700">Méthode de paiement</label>
                <select name="methode_paiement" id="methode_paiement" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <option value="carte_bancaire" {{ old('methode_paiement', $paiement->methode_paiement) == 'carte_bancaire' ? 'selected' : '' }}>Carte bancaire</option>
                    <option value="virement" {{ old('methode_paiement', $paiement->methode_paiement) == 'virement' ? 'selected' : '' }}>Virement</option>
                    <option value="cheque" {{ old('methode_paiement', $paiement->methode_paiement) == 'cheque' ? 'selected' : '' }}>Chèque</option>
                    <option value="especes" {{ old('methode_paiement', $paiement->methode_paiement) == 'especes' ? 'selected' : '' }}>Espèces</option>
                    <option value="prelevement" {{ old('methode_paiement', $paiement->methode_paiement) == 'prelevement' ? 'selected' : '' }}>Prélèvement automatique</option>
                </select>
                @error('methode_paiement')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="reference_transaction" class="block text-sm font-medium text-gray-700">Référence de transaction</label>
                <input type="text" name="reference_transaction" id="reference_transaction" value="{{ old('reference_transaction', $paiement->reference_transaction) }}" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <p class="text-xs text-gray-500 mt-1">Optionnel - Numéro de chèque, référence de virement, etc.</p>
                @error('reference_transaction')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('paiements.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mr-2">
                Annuler
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
