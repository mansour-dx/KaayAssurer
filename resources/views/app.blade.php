<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Assurance Pro') - Votre partenaire confiance</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @yield('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0 text-xl font-bold">
                            Assurance Pro
                        </a>
                        <div class="hidden md:block ml-10">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Dashboard</a>
                                <a href="{{ route('clients.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Clients</a>
                                <a href="{{ route('polices.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Polices</a>
                                <a href="{{ route('type-assurances.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Types d'Assurance</a>
                                <a href="{{ route('sinistres.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Sinistres</a>
                                <a href="{{ route('paiements.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Paiements</a>
                            </div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="ml-3 relative">
                                <a href="#" class="text-white hover:text-gray-300">
                                    <i class="fas fa-user-circle text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Assurance Pro. Tous droits réservés.
                </p>
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>
</html>
