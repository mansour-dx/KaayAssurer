@extends('app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Détails de la Police d'Assurance</h1>
        <div class="flex space-x-3">
            <a href="{{ route('polices.edit', $police->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('polices.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Police N° {{ $police->numero_police }}</h2>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                      @if($police->statut == 'active') bg-green-100 text-green-800 
                      @elseif($police->statut == 'expirée') bg-red-100 text-red-800 
                      @elseif($police->statut == 'résiliée') bg-gray-100 text-gray-800 
                      @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($police->statut) }}
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <h3 class="font-medium text-gray-900 mb-3">Informations Générales</h3>
                    <table class="min-w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 text-sm font-medium text-gray-500">Type d'assurance</td>
                                <td class="py-2 text-sm text-gray-900">
                                    @if($police->typeAssurance)
                                        {{ $police->typeAssurance->nom }}
                                    @else
                                        Non spécifié
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 text-sm font-medium text-gray-500">Date de début</td>
                                <td class="py-2 text-sm text-gray-900">{{ $police->date_debut->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-sm font-medium text-gray-500">Date de fin</td>
                                <td class="py-2 text-sm text-gray-900">{{ $police->date_fin->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-sm font-medium text-gray-500">Durée</td>
                                <td class="py-2 text-sm text-gray-900">
                                    {{ $police->date_debut->diffInMonths($police->date_fin) }} mois
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="md:col-span-1">
                    <h3 class="font-medium text-gray-900 mb-3">Informations Financières</h3>
                    <table class="min-w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 text-sm font-medium text-gray-500">Prime annuelle</td>
                                <td class="py-2 text-sm text-gray-900">{{ number_format($police->prime_annuelle, 0, ',', ' ') }} F CFA</td>
                            </tr>
                            <tr>
                                <td class="py-2 text-sm font-medium text-gray-500">Franchise</td>
                                <td class="py-2 text-sm text-gray-900">
                                    @if($police->franchise)
                                        {{ number_format($police->franchise, 0, ',', ' ') }} F CFA
                                    @else
                                        Non applicable
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="md:col-span-1">
                    <h3 class="font-medium text-gray-900 mb-3">Client</h3>
                    @if($police->client)
                    <div class="border border-gray-200 rounded p-3">
                        <p class="text-sm font-medium text-gray-900">{{ $police->client->nom }} {{ $police->client->prenom }}</p>
                        <p class="text-sm text-gray-500">{{ $police->client->email }}</p>
                        <p class="text-sm text-gray-500">{{ $police->client->telephone }}</p>
                        <a href="{{ route('clients.show', $police->client->id) }}" class="mt-2 inline-flex text-xs leading-5 font-semibold text-blue-600 hover:text-blue-900">
                            Voir la fiche client
                        </a>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">Client inconnu</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Détails de la couverture</h3>
                        <div class="bg-gray-50 rounded p-3 text-sm text-gray-700">
                            {!! nl2br(e($police->couverture_details)) ?: 'Aucun détail de couverture spécifié' !!}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Notes</h3>
                        <div class="bg-gray-50 rounded p-3 text-sm text-gray-700">
                            {!! nl2br(e($police->notes)) ?: 'Aucune note' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Sinistres associés à cette police</h2>
        
        @if($police->sinistres && $police->sinistres->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($police->sinistres as $sinistre)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sinistre->reference }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $sinistre->date_sinistre->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($sinistre->description, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($sinistre->montant_estime, 0, ',', ' ') }} F CFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                  @if($sinistre->statut == 'réglé') bg-green-100 text-green-800 
                                  @elseif($sinistre->statut == 'rejeté') bg-red-100 text-red-800 
                                  @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($sinistre->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('sinistres.show', $sinistre->id) }}" class="text-blue-600 hover:text-blue-900">
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
            Aucun sinistre enregistré pour cette police
        </div>
        @endif
    </div>
</div>
@endsection
