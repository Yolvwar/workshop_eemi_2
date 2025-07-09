<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon App')</title>

    {{-- Tailwind CSS (optionnel, tu peux le retirer si tu utilises autre chose) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Styles additionnels --}}
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-white shadow mb-6">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold">MonApp</a>
            <div>
                <a href="{{ route('pets.index') }}" class="mr-4 text-blue-500 hover:underline">Animaux</a>
                <a href="#" class="text-blue-500 hover:underline">À propos</a>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="container mx-auto px-4 mb-4">
            <div class="bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Contenu principal --}}
    <main class="container mx-auto px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center py-6 mt-12 text-sm text-gray-600">
        &copy; {{ date('Y') }} MonApp. Tous droits réservés.
    </footer>

    {{-- Scripts additionnels --}}
    @stack('scripts')
</body>

</html>