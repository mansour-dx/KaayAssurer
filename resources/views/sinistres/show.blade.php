@extends('app')

@section('title', 'Détails du Sinistre')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 bg-red-500 text-white flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium">Détails du Sinistre</h3>
            <p class="mt-1 max-w-2xl text-sm">Informations complètes sur le sinistre</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('sinistres.edit', $sinistre) }}" class="bg-white text-red-500 px-4 py-2 rounded-md text-sm font-medium hover:bg-red-50">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('sinistres.index') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>
    
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Client</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $sinistre->police->client->nom }} {{ $sinistre->police->client->prenom }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Police d'assurance</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $sinistre->police->numero_police }} ({{ $sinistre->police->typeAssurance->nom }})
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Date du sinistre</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $sinistre->date_sinistre }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                <dd class="mt-1 sm:mt-0 sm:col-span-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($sinistre->statut == 'en_attente') bg-yellow-100 text-yellow-800
                        @elseif($sinistre->statut == 'validé') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $sinistre->statut }}
                    </span>
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Montant estimé</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($sinistre->montant_estime, 2) }} €</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Montant remboursé</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $sinistre->montant_rembourse ? number_format($sinistre->montant_rembourse, 2) . ' €' : 'Non remboursé' }}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Description</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $sinistre->description }}
                </dd>
            </div>
        </dl>
    </div>
</div>
@endsection
