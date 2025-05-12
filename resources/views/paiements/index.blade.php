@extends('app')

@section('title', 'Liste des Paiements')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 bg-green-500 text-white flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium">Gestion des Paiements</h3>
            <p class="mt-1 max-w-2xl text-sm">Liste complète des paiements reçus</p>
        </div>
        <a href="{{ route('paiements.create') }}" class="bg-white text-green-500 px-4 py-2 rounded-md text-sm font-medium hover:bg-green-50">
            <i class="fas fa-plus mr-2"></i> Nouveau Paiement
        </a>
    </div>
    
    <!-- Barre de recherche et filtres -->
    <div class="px-4 py-3 bg-gray-50">
        <form action="{{ route('paiements.index') }}" method="GET" class="space-y-2">
            <div class="flex">
                <input type="text" name="search" placeholder="Rechercher un paiement..." class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" value="{{ request('search') }}">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-r-md hover:bg-green-600">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="flex flex-wrap gap-2">
                <div>
                    <label for="date_from" class="block text-xs font-medium text-gray-700">Date de début</label>
                    <input type="date" id="date_from" name="date_from" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 text-sm" value="{{ request('date_from') }}">
                </div>
                <div>
                    <label for="date_to" class="block text-xs font-medium text-gray-700">Date de fin</label>
                    <input type="date" id="date_to" name="date_to" class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 text-sm" value="{{ request('date_to') }}">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 text-sm">
                        Filtrer
                    </button>
                </div>
                <div class="flex items-end">
                    <a href="{{ route('paiements.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm flex items-center">
                        <i class="fas fa-times mr-2"></i> Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tableau des paiements -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client & Police</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($paiements as $paiement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $paiement->police->client->nom }} {{ $paiement->police->client->prenom }}</div>
                                <div class="text-sm text-blue-600">{{ $paiement->police->numero_police }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $paiement->date_paiement }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ number_format($paiement->montant, 2) }} €
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $paiement->methode_paiement }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $paiement->reference_transaction ?: 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('paiements.show', $paiement) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('paiements.edit', $paiement) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('paiements.destroy', $paiement) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Aucun paiement trouvé.
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
    {{ $paiements->links() }}
</div>
@endsection
