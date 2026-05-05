@extends('layouts.app')

@section('title', 'Accueil — Blog Simple')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Hero --}}
    <div class="mb-10">
        <h1 class="text-5xl font-extrabold mb-2" style="color:#1A1A2E;">Derniers Articles</h1>
        <p class="text-gray-500 text-lg">Explorez nos articles, découvertes et analyses.</p>
    </div>

    {{-- Search mobile --}}
    <form action="{{ route('home') }}" method="GET" class="sm:hidden mb-6">
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <div class="relative">
            <input type="search" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un article…"
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </form>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ── ARTICLES GRID ──────────────────────────── --}}
        <section class="flex-1">

            @if(request('search') || request('category'))
                <div class="flex items-center gap-2 mb-6 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    Filtres actifs :
                    @if(request('search'))
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">Recherche : "{{ request('search') }}"</span>
                    @endif
                    @if(request('category'))
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Catégorie : {{ request('category') }}</span>
                    @endif
                    <a href="{{ route('home') }}" class="text-red-500 hover:underline ml-1">Effacer</a>
                </div>
            @endif

            @if($posts->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 flex flex-col">
                            {{-- Cover --}}
                            <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-video overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 opacity-30" style="color:#4A4A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            <div class="p-5 flex flex-col flex-1">
                                {{-- Category badge --}}
                                <div class="flex items-center justify-between mb-3">
                                    <a href="{{ route('home', ['category' => $post->category->slug]) }}"
                                       class="px-2.5 py-1 rounded-full text-xs font-semibold transition-colors hover:opacity-80"
                                       style="background:rgba(108,99,255,0.12);color:#6C63FF;">
                                        {{ $post->category->name }}
                                    </a>
                                    <span class="flex items-center gap-1 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/></svg>
                                        {{ $post->approvedComments->count() }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h2 class="font-bold text-base leading-snug mb-2 hover:text-[#4A4A8A] transition-colors" style="color:#1A1A2E;">
                                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>

                                {{-- Excerpt --}}
                                <p class="text-sm text-gray-500 leading-relaxed mb-4 flex-1">{{ $post->excerpt }}</p>

                                {{-- Footer --}}
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background:#4A4A8A;">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium" style="color:#1A1A2E;">{{ $post->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $post->published_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('posts.show', $post->slug) }}"
                                       class="text-xs font-semibold flex items-center gap-1 hover:gap-2 transition-all" style="color:#6C63FF;">
                                        Lire
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10 flex justify-center">
                    {{ $posts->links() }}
                </div>

            @else
                <div class="text-center py-20 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="font-medium text-gray-500">Aucun article trouvé.</p>
                </div>
            @endif
        </section>

        {{-- ── SIDEBAR ────────────────────────────────── --}}
        <aside class="lg:w-72 space-y-6 flex-shrink-0">

            {{-- Categories --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-4" style="color:#4A4A8A;">Catégories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home', array_filter(['search' => request('search')])) }}"
                           class="flex items-center justify-between text-sm py-1.5 px-3 rounded-lg transition-colors {{ !request('category') ? 'font-semibold text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                           style="{{ !request('category') ? 'background:#4A4A8A;' : '' }}">
                            <span>Tous les articles</span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ !request('category') ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">{{ $posts->total() }}</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('home', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                               class="flex items-center justify-between text-sm py-1.5 px-3 rounded-lg transition-colors {{ request('category') === $cat->slug ? 'font-semibold text-white' : 'text-gray-600 hover:bg-gray-50' }}"
                               style="{{ request('category') === $cat->slug ? 'background:#4A4A8A;' : '' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ request('category') === $cat->slug ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' }}">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Recent posts --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-sm uppercase tracking-wider mb-4" style="color:#4A4A8A;">Articles récents</h3>
                <ul class="space-y-4">
                    @foreach($recent as $r)
                        <li class="flex gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-indigo-100 to-purple-100">
                                @if($r->image)
                                    <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 opacity-40" style="color:#4A4A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('posts.show', $r->slug) }}" class="text-sm font-medium leading-snug hover:text-[#4A4A8A] transition-colors line-clamp-2" style="color:#1A1A2E;">{{ $r->title }}</a>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $r->published_at->format('d M Y') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </aside>
    </div>
</div>
@endsection
