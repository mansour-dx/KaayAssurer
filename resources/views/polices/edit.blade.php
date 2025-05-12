@extends('app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Modifier la Police d'Assurance</h1>
        <a href="{{ route('polices.show', $police->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    @if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <ul class="list-disc pl-4">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <form action="{{ route('polices.update', $police->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="numero_police" class="block text-sm font-medium text-gray-700">Numéro de police</label>
                    <input type="text" name="numero_police" id="numero_police" value="{{ old('numero_police', $police->numero_police) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
                
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                    <select name="client_id" id="client_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        <option value="">Sélectionnez un client</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" @if(old('client_id', $police->client_id) == $client->id) selected @endif>
                            {{ $client->nom }} {{ $client->prenom }} - {{ $client->email }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="type_assurance_id" class="block text-sm font-medium text-gray-700">Type d'assurance</label>
                    <select name="type_assurance_id" id="type_assurance_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        <option value="">Sélectionnez un type</option>
                        @foreach($typeAssurances as $type)
                        <option value="{{ $type->id }}" @if(old('type_assurance_id', $police->type_assurance_id) == $type->id) selected @endif>
                            {{ $type->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut" id="statut" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        <option value="en_attente" @if(old('statut', $police->statut) == 'en_attente') selected @endif>En attente</option>
                        <option value="active" @if(old('statut', $police->statut) == 'active') selected @endif>Active</option>
                        <option value="expirée" @if(old('statut', $police->statut) == 'expirée') selected @endif>Expirée</option>
                        <option value="résiliée" @if(old('statut', $police->statut) == 'résiliée') selected @endif>Résiliée</option>
                    </select>
                </div>
                
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut', $police->date_debut->format('Y-m-d')) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
                
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin', $police->date_fin->format('Y-m-d')) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
                
                <div>
                    <label for="prime_annuelle" class="block text-sm font-medium text-gray-700">Prime annuelle (F CFA)</label>
                    <input type="number" name="prime_annuelle" id="prime_annuelle" value="{{ old('prime_annuelle', $police->prime_annuelle) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
                
                <div>
                    <label for="franchise" class="block text-sm font-medium text-gray-700">Franchise (F CFA)</label>
                    <input type="number" name="franchise" id="franchise" value="{{ old('franchise', $police->franchise) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                
                <div class="md:col-span-2">
                    <label for="couverture_details" class="block text-sm font-medium text-gray-700">Détails de la couverture</label>
                    <textarea name="couverture_details" id="couverture_details" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('couverture_details', $police->couverture_details) }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('notes', $police->notes) }}</textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Mettre à jour
                </button>
                
                <div>
                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="document.getElementById('delete-form').submit();">
                        Supprimer cette police
                    </button>
                </div>
            </div>
        </form>
        
        <form id="delete-form" action="{{ route('polices.destroy', $police->id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
