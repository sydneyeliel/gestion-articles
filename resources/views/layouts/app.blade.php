<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Blog Simple')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col" style="background:#F8F8FF;color:#1A1A2E;font-family:'Inter',sans-serif;">

{{-- NAVBAR --}}
<header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl" style="color:#4A4A8A;">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3a1 1 0 110 2 1 1 0 010-2zm3 11H9v-2h6v2zm0-4H9v-2h6v2z"/>
                </svg>
                Blog Simple
            </a>

            {{-- Nav links --}}
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-[#4A4A8A] transition-colors">Accueil</a>
                <a href="{{ route('home') }}?category=" class="hover:text-[#4A4A8A] transition-colors">Catégories</a>
            </nav>

            {{-- Search + auth --}}
            <div class="flex items-center gap-3">
                <form action="{{ route('home') }}" method="GET" class="hidden sm:flex items-center">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}"
                               placeholder="Rechercher…"
                               class="pl-9 pr-3 py-1.5 text-sm rounded-full border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent w-48 transition-all">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>

                @auth
                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium px-3 py-1.5 rounded-full text-white transition-colors" style="background:#4A4A8A;">Admin</a>
                        @endif
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background:#6C63FF;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm text-gray-500 hover:text-red-500 transition-colors">Déconnexion</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold px-4 py-2 rounded-full border-2 transition-all hover:bg-[#4A4A8A] hover:text-white hover:border-[#4A4A8A]" style="border-color:#4A4A8A;color:#4A4A8A;">
                        Connexion
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- MAIN --}}
<main class="flex-1">
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="mt-16 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-500">© {{ date('Y') }} Blog Simple — Laravel + Tailwind CSS</p>
        <nav class="flex gap-4 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#4A4A8A]">Accueil</a>
            <a href="/api/posts" class="hover:text-[#4A4A8A]">API</a>
        </nav>
    </div>
</footer>

</body>
</html>
