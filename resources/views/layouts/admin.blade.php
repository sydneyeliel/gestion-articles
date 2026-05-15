<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Tableau de bord')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex" style="background:#F1F0FA;color:#1A1A2E;font-family:'Inter',sans-serif;">

{{-- ── SIDEBAR ──────────────────────────────────────────────── --}}
<aside class="w-40 min-h-screen flex flex-col flex-shrink-0 shadow-lg" style="background:#1A1A2E;">

    {{-- Logo --}}
    <div class="px-4 py-5 border-b border-white/10">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#6C63FF;">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3a1 1 0 110 2 1 1 0 010-2zm3 11H9v-2h6v2zm0-4H9v-2h6v2z"/>
                </svg>
            </div>
            <div>
                <img src="{{ asset('images/logo.svg') }}" alt="NeyDys" class="h-7 w-auto brightness-0 invert">
                <p class="text-xs font-medium tracking-widest" style="color:#6C63FF;font-size:9px;">MANAGEMENT</p>
            </div>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-5 space-y-0.5">
        @php
            $navItems = [
                ['route' => 'admin.dashboard',        'label' => 'Dashboard',    'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'admin.posts.index',      'label' => 'Articles',     'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['route' => 'admin.categories.index', 'label' => 'Categories',   'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['route' => 'admin.comments.index',   'label' => 'Comments',     'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'badge' => true],
            ];
        @endphp

        @foreach($navItems as $item)
            @php $active = request()->routeIs($item['route'] . '*'); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-medium transition-all group {{ $active ? 'text-white' : 'text-gray-400 hover:text-white hover:bg-white/8' }}"
               style="{{ $active ? 'background:rgba(108,99,255,0.25);' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0 {{ $active ? 'text-[#6C63FF]' : 'text-gray-500 group-hover:text-[#6C63FF]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                </svg>
                <span>{{ $item['label'] }}</span>
                @if(!empty($item['badge']))
                    @php $pendingCount = \App\Models\Comment::where('status','pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto px-1.5 py-0.5 text-xs font-bold rounded-full bg-amber-500 text-white">{{ $pendingCount }}</span>
                    @endif
                @endif
            </a>
        @endforeach
    </nav>

    {{-- User --}}
    <div class="px-3 py-4 border-t border-white/10">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background:#6C63FF;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-gray-500 truncate" style="font-size:10px;">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-2 text-xs text-gray-400 hover:text-red-400 transition-colors px-2 py-1.5 rounded-lg hover:bg-white/5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- ── MAIN ─────────────────────────────────────────────────── --}}
<div class="flex-1 flex flex-col min-h-screen overflow-hidden">

    {{-- Top bar --}}
    <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center gap-4 shadow-sm">
        {{-- Search --}}
        <div class="relative flex-1 max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Search posts, users or tags..."
                   class="w-full pl-9 pr-4 py-2 text-sm rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent transition-all">
        </div>

        <div class="flex items-center gap-2 ml-auto">
            {{-- Notification --}}
            <button class="relative w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @php $pendingBell = \App\Models\Comment::where('status','pending')->count(); @endphp
                @if($pendingBell > 0)
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500"></span>
                @endif
            </button>

            {{-- Settings --}}
            <a href="{{ route('home') }}" class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </a>

            {{-- User --}}
            <div class="flex items-center gap-2.5 pl-3 border-l border-gray-200">
                <div>
                    <p class="text-sm font-semibold leading-tight text-right" style="color:#1A1A2E;">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 text-right tracking-wide" style="font-size:10px;">SUPER ADMINISTRATOR</p>
                </div>
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0" style="background:#6C63FF;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 p-6 overflow-auto">
        @if(session('success'))
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm mb-5">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>
</div>

</body>
</html>
