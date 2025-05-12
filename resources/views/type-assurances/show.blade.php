@extends('app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Détails du Type d'Assurance</h1>
        <div class="flex space-x-3">
            <a href="{{ route('type-assurances.edit', $typeAssurance->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('type-assurances.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">{{ $typeAssurance->nom }}</h2>
            <p class="text-sm text-gray-600">Code: {{ $typeAssurance->code }}</p>
        </div>
        
        <div class="p-6 space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Description</h3>
                <p class="mt-2 text-gray-600">{{ $typeAssurance->description ?: 'Aucune description disponible' }}</p>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900">Couverture</h3>
                <p class="mt-2 text-gray-600">{{ $typeAssurance->couverture ?: 'Aucun détail de couverture disponible' }}</p>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900">Conditions</h3>
                <p class="mt-2 text-gray-600">{{ $typeAssurance->conditions ?: 'Aucune condition spécifiée' }}</p>
            </div>
        </div>
    </div>
    
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Polices liées à ce type d'assurance</h2>
        
        @if($typeAssurance->polices->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Début</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fin</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($typeAssurance->polices as $police)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $police->numero_police }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($police->client)
                                {{ $police->client->nom }} {{ $police->client->prenom }}
                            @else
                                Client inconnu
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $police->date_debut->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $police->date_fin->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                  @if($police->statut == 'active') bg-green-100 text-green-800 
                                  @elseif($police->statut == 'expirée') bg-red-100 text-red-800 
                                  @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($police->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('polices.show', $police->id) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 text-center text-gray-500">
            Aucune police d'assurance associée à ce type
        </div>
        @endif
    </div>
</div>
@endsection
