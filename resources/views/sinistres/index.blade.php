@extends('app')

@section('title', 'Liste des Sinistres')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 bg-red-500 text-white flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium">Gestion des Sinistres</h3>
            <p class="mt-1 max-w-2xl text-sm">Liste complète des sinistres déclarés</p>
        </div>
        <a href="{{ route('sinistres.create') }}" class="bg-white text-red-500 px-4 py-2 rounded-md text-sm font-medium hover:bg-red-50">
            <i class="fas fa-plus mr-2"></i> Nouveau Sinistre
        </a>
    </div>
    
    <!-- Barre de recherche et filtres -->
    <div class="px-4 py-3 bg-gray-50">
        <form action="{{ route('sinistres.index') }}" method="GET" class="space-y-2">
            <div class="flex">
                <input type="text" name="search" placeholder="Rechercher un sinistre..." class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" value="{{ request('search') }}">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-r-md hover:bg-red-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="flex space-x-2">
                <select name="statut" class="rounded-md border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 text-sm">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="validé" {{ request('statut') == 'validé' ? 'selected' : '' }}>Validé</option>
                    <option value="refusé" {{ request('statut') == 'refusé' ? 'selected' : '' }}>Refusé</option>
                </select>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 text-sm">
                    Filtrer
                </button>
                <a href="{{ route('sinistres.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm flex items-center">
                    <i class="fas fa-times mr-2"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tableau des sinistres -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client & Police</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montants</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sinistres as $sinistre)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $sinistre->police->client->nom }} {{ $sinistre->police->client->prenom }}</div>
                                <div class="text-sm text-blue-600">{{ $sinistre->police->numero_police }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $sinistre->date_sinistre }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 truncate max-w-xs">{{ $sinistre->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Estimé: {{ number_format($sinistre->montant_estime, 2) }} €</div>
                                @if($sinistre->montant_rembourse)
                                <div class="text-sm text-green-600">Remboursé: {{ number_format($sinistre->montant_rembourse, 2) }} €</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($sinistre->statut == 'en_attente') bg-yellow-100 text-yellow-800
                                    @elseif($sinistre->statut == 'validé') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $sinistre->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('sinistres.show', $sinistre) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sinistres.edit', $sinistre) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sinistres.destroy', $sinistre) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sinistre?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Aucun sinistre trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $sinistres->links() }}
</div>
@endsection
