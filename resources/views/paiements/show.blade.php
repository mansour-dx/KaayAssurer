@extends('app')

@section('title', 'Détails du Paiement')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 bg-green-500 text-white flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium">Détails du Paiement</h3>
            <p class="mt-1 max-w-2xl text-sm">Informations complètes sur le paiement</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('paiements.edit', $paiement) }}" class="bg-white text-green-500 px-4 py-2 rounded-md text-sm font-medium hover:bg-green-50">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <a href="{{ route('paiements.index') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>
    
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Client</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $paiement->police->client->nom }} {{ $paiement->police->client->prenom }}
                </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Police d'assurance</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $paiement->police->numero_police }} ({{ $paiement->police->typeAssurance->nom }})
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Date du paiement</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $paiement->date_paiement }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Montant</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ number_format($paiement->montant, 2) }} €</dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Méthode de paiement</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $paiement->methode_paiement }}</dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Référence de transaction</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $paiement->reference_transaction ?: 'Non renseignée' }}
                </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Date d'enregistrement</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $paiement->created_at }}</dd>
            </div>
        </dl>
    </div>
</div>

<!-- Option: Ajout d'une section pour imprimer un reçu -->
<div class="mt-4 flex justify-end">
    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition">
        <i class="fas fa-print mr-2"></i> Imprimer le reçu
    </button>
</div>
@endsection
