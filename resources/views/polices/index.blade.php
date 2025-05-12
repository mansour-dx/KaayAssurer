@extends('app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Polices d'Assurance</h1>
        <a href="{{ route('polices.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-plus mr-2"></i> Nouvelle police
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Filtres</h2>
            <form action="{{ route('polices.index') }}" method="GET" class="mt-3 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                    <input type="text" name="client" id="client" value="{{ request('client') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type d'assurance</label>
                    <select name="type" id="type" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">Tous</option>
                        @foreach($typeAssurances as $type)
                        <option value="{{ $type->id }}" @if(request('type') == $type->id) selected @endif>{{ $type->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut" id="statut" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">Tous</option>
                        <option value="active" @if(request('statut') == 'active') selected @endif>Active</option>
                        <option value="en_attente" @if(request('statut') == 'en_attente') selected @endif>En attente</option>
                        <option value="expirée" @if(request('statut') == 'expirée') selected @endif>Expirée</option>
                        <option value="résiliée" @if(request('statut') == 'résiliée') selected @endif>Résiliée</option>
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-search mr-2"></i> Filtrer
                    </button>
                    <a href="{{ route('polices.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prime</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($polices as $police)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $police->numero_police }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($police->client)
                            <a href="{{ route('clients.show', $police->client->id) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $police->client->nom }} {{ $police->client->prenom }}
                            </a>
                        @else
                            Client inconnu
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($police->typeAssurance)
                            {{ $police->typeAssurance->nom }}
                        @else
                            Non spécifié
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Du {{ $police->date_debut->format('d/m/Y') }}<br>
                        Au {{ $police->date_fin->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ number_format($police->prime_annuelle, 0, ',', ' ') }} F CFA
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                              @if($police->statut == 'active') bg-green-100 text-green-800 
                              @elseif($police->statut == 'expirée') bg-red-100 text-red-800 
                              @elseif($police->statut == 'résiliée') bg-gray-100 text-gray-800 
                              @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($police->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('polices.show', $police->id) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('polices.edit', $police->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('polices.destroy', $police->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette police?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Aucune police d'assurance trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $polices->links() }}
    </div>
</div>
@endsection
