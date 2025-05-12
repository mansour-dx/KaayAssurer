@extends('app')

@section('title', 'Déclarer un Sinistre')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 bg-red-500 text-white">
        <h3 class="text-lg leading-6 font-medium">Déclarer un Sinistre</h3>
        <p class="mt-1 max-w-2xl text-sm">Enregistrer un nouveau sinistre dans le système</p>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <form action="{{ route('sinistres.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label for="police_id" class="block text-sm font-medium text-gray-700">Police d'assurance</label>
                <select name="police_id" id="police_id" class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <option value="">Sélectionner une police</option>
                    @foreach($polices as $police)
                        <option value="{{ $police->id }}" {{ old('police_id', $policeId) == $police->id ? 'selected' : '' }}>
                            {{ $police->numero_police }} - {{ $police->client->nom }} {{ $police->client->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('police_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="date_sinistre" class="block text-sm font-medium text-gray-700">Date du sinistre</label>
                <input type="date" name="date_sinistre" id="date_sinistre" value="{{ old('date_sinistre') }}" class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('date_sinistre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="montant_estime" class="block text-sm font-medium text-gray-700">Montant estimé (€)</label>
                <input type="number" step="0.01" name="montant_estime" id="montant_estime" value="{{ old('montant_estime') }}" class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('montant_estime')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description du sinistre</label>
                <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="statut" id="statut" class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="validé" {{ old('statut') == 'validé' ? 'selected' : '' }}>Validé</option>
                    <option value="refusé" {{ old('statut') == 'refusé' ? 'selected' : '' }}>Refusé</option>
                </select>
                @error('statut')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('sinistres.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mr-2">
                Annuler
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
