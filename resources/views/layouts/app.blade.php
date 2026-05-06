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
        <div class="flex items-center h-16 gap-8">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="font-bold text-xl flex-shrink-0" style="color:#1A1A2E;">
                Blog Simple
            </a>

            {{-- Nav links --}}
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                @php $isHome = request()->routeIs('home') && !request('category'); @endphp
                <a href="{{ route('home') }}"
                   class="relative py-0.5 transition-colors {{ $isHome ? 'font-semibold' : 'text-gray-500 hover:text-gray-900' }}"
                   style="{{ $isHome ? 'color:#6C63FF;' : '' }}">
                    Explore
                    @if($isHome)
                        <span class="absolute -bottom-0.5 left-0 right-0 h-0.5 rounded-full" style="background:#6C63FF;"></span>
                    @endif
                </a>
                <a href="{{ route('home') }}#categories"
                   class="text-gray-500 hover:text-gray-900 transition-colors">
                    Categories
                </a>
                <a href="{{ route('home') }}#newsletter"
                   class="text-gray-500 hover:text-gray-900 transition-colors">
                    Newsletter
                </a>
                <a href="{{ route('home') }}#about"
                   class="text-gray-500 hover:text-gray-900 transition-colors">
                    About
                </a>
            </nav>

            {{-- Search --}}
            <div class="flex-1 hidden sm:block" style="max-width:280px;margin-left:auto;">
                <form action="{{ route('home') }}" method="GET">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="search" name="search" value="{{ request('search') }}"
                               placeholder="Search articles..."
                               class="w-full pl-9 pr-4 py-2 text-sm rounded-full border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                               style="--tw-ring-color:#6C63FF;">
                    </div>
                </form>
            </div>

            {{-- Auth --}}
            <div class="flex items-center gap-3 flex-shrink-0">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            Admin
                        </a>
                    @endif
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                             style="background:#6C63FF;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden md:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-sm font-semibold px-5 py-2 rounded-full text-white transition-all hover:opacity-90 active:scale-95"
                       style="background:#6C63FF;">
                        Get Started
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
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="mt-20 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <a href="{{ route('home') }}" class="font-bold text-lg" style="color:#1A1A2E;">Blog Simple</a>
                <p class="text-sm text-gray-400 mt-1">© {{ date('Y') }} Blog Simple. Designed for thoughtful creators.</p>
            </div>
            <nav class="flex flex-wrap gap-6 text-sm text-gray-500">
                <a href="#" class="hover:text-gray-900 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-900 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gray-900 transition-colors">Contact Us</a>
                <a href="/api/posts" class="hover:text-gray-900 transition-colors">RSS Feed</a>
            </nav>
            <div class="flex items-center gap-2">
                <button class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:border-gray-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </button>
                <button class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:border-gray-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
