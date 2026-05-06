@extends('layouts.app')

@section('title', 'Accueil — Blog Simple')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── HERO TITLE ────────────────────────────────────────── --}}
    <h1 class="font-bold mb-8" style="font-size:48px;color:#1A1A2E;line-height:1.15;">Latest Articles</h1>

    {{-- ── FEATURED ARTICLE CARD ────────────────────────────── --}}
    @if($posts->count() && !request('search') && !request('category') && $posts->currentPage() === 1)
        @php $featured = $posts->first(); @endphp
        <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 mb-12 grid md:grid-cols-[60%_40%]">

            {{-- Cover image (left 60%) --}}
            <a href="{{ route('posts.show', $featured->slug) }}" class="block overflow-hidden" style="min-height:320px;">
                @if($featured->image)
                    <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                         style="min-height:320px;">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="min-height:320px;background:linear-gradient(135deg,#1A1A2E 0%,#4A4A8A 100%);">
                        <svg class="w-20 h-20 opacity-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </a>

            {{-- Text (right 40%) --}}
            <div class="p-8 lg:p-10 flex flex-col justify-center">
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-5 w-fit"
                      style="background:rgba(108,99,255,0.1);color:#6C63FF;">
                    Featured
                </span>
                <h2 class="font-bold leading-tight mb-4" style="font-size:1.6rem;color:#1A1A2E;">
                    <a href="{{ route('posts.show', $featured->slug) }}" class="hover:opacity-80 transition-opacity">
                        {{ $featured->title }}
                    </a>
                </h2>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">{{ $featured->excerpt }}</p>
                <div class="flex items-center gap-3 mt-auto">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                         style="background:#4A4A8A;">
                        {{ strtoupper(substr($featured->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold" style="color:#1A1A2E;">{{ $featured->user->name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $featured->published_at->format('M d, Y') }}
                            @if(method_exists($featured, 'readingTime'))
                                · {{ $featured->readingTime() }} min read
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ── SEARCH MOBILE ─────────────────────────────────────── --}}
    <form action="{{ route('home') }}" method="GET" class="sm:hidden mb-6">
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" name="search" value="{{ request('search') }}"
                   placeholder="Search articles..."
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF]">
        </div>
    </form>

    {{-- ── MAIN LAYOUT: GRID + SIDEBAR ──────────────────────── --}}
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ── ARTICLES GRID ─────────────────────────────────── --}}
        <section class="flex-1 min-w-0">

            @if(request('search') || request('category'))
                <div class="flex flex-wrap items-center gap-2 mb-6 text-sm text-gray-500">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    @if(request('search'))
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">"{{ request('search') }}"</span>
                    @endif
                    @if(request('category'))
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">{{ request('category') }}</span>
                    @endif
                    <a href="{{ route('home') }}" class="text-xs text-red-500 hover:underline">✕ Clear</a>
                </div>
            @endif

            @if($posts->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 flex flex-col group">

                            {{-- Cover image with category badge overlay --}}
                            <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 flex-shrink-0">
                                <a href="{{ route('posts.show', $post->slug) }}" class="block w-full h-full">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full" style="background:linear-gradient(135deg,#1A1A2E 0%,#4A4A8A 100%);"></div>
                                    @endif
                                </a>
                                {{-- Category badge overlaid on image --}}
                                <a href="{{ route('home', ['category' => $post->category->slug]) }}"
                                   class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-xs font-semibold text-white transition-opacity hover:opacity-90"
                                   style="background:rgba(26,26,46,0.75);backdrop-filter:blur(4px);">
                                    {{ $post->category->name }}
                                </a>
                            </div>

                            {{-- Card body --}}
                            <div class="p-5 flex flex-col flex-1">

                                {{-- Date + comment count --}}
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs text-gray-400">{{ $post->published_at->format('M d, Y') }}</span>
                                    <span class="flex items-center gap-1 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $post->approvedComments->count() }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h2 class="font-bold text-base leading-snug mb-2 line-clamp-2" style="color:#1A1A2E;">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:opacity-75 transition-opacity">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                {{-- Excerpt --}}
                                <p class="text-sm text-gray-500 leading-relaxed line-clamp-3 flex-1 mb-4">{{ $post->excerpt }}</p>

                                {{-- Author + Read more --}}
                                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                             style="background:#4A4A8A;">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-medium" style="color:#1A1A2E;">{{ $post->user->name }}</span>
                                    </div>
                                    <a href="{{ route('posts.show', $post->slug) }}"
                                       class="flex items-center gap-1 text-xs font-semibold transition-all hover:gap-2"
                                       style="color:#6C63FF;">
                                        Read more
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
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
                <div class="text-center py-24">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl flex items-center justify-center bg-gray-100">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-600 mb-1">No articles found.</p>
                    <p class="text-sm text-gray-400 mb-4">Try different search terms.</p>
                    <a href="{{ route('home') }}" class="inline-block text-sm font-semibold px-4 py-2 rounded-xl transition-all hover:opacity-90"
                       style="color:#6C63FF;background:rgba(108,99,255,0.1);">
                        View all articles
                    </a>
                </div>
            @endif
        </section>

        {{-- ── SIDEBAR ─────────────────────────────────────── --}}
        <aside id="categories" class="lg:w-64 xl:w-72 space-y-6 flex-shrink-0">

            {{-- Categories --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-base mb-5" style="color:#1A1A2E;">Categories</h3>
                <ul class="space-y-3">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('home', array_filter(['category' => $cat->slug, 'search' => request('search')])) }}"
                               class="flex items-center justify-between group">
                                <span class="text-sm transition-colors {{ request('category') === $cat->slug ? 'font-semibold' : 'text-gray-600 group-hover:text-gray-900' }}"
                                      style="{{ request('category') === $cat->slug ? 'color:#6C63FF;' : '' }}">
                                    {{ $cat->name }}
                                </span>
                                <span class="text-sm font-medium text-gray-400">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Recent Posts --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="font-bold text-base mb-5" style="color:#1A1A2E;">Recent Posts</h3>
                <ul class="space-y-4">
                    @foreach($recent as $r)
                        <li class="flex gap-3 group">
                            <a href="{{ route('posts.show', $r->slug) }}"
                               class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100 block">
                                @if($r->image)
                                    <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full" style="background:linear-gradient(135deg,#1A1A2E,#4A4A8A);"></div>
                                @endif
                            </a>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('posts.show', $r->slug) }}"
                                   class="text-sm font-medium leading-snug line-clamp-2 block hover:opacity-75 transition-opacity"
                                   style="color:#1A1A2E;">
                                    {{ $r->title }}
                                </a>
                                <p class="text-xs text-gray-400 mt-1">{{ $r->published_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="rounded-2xl p-6" style="background:#4A4A8A;">
                <h3 class="font-bold text-base text-white mb-2">Newsletter</h3>
                <p class="text-sm mb-5" style="color:rgba(255,255,255,0.75);">
                    Join 15,000+ readers who receive our weekly curation of thoughtful articles.
                </p>
                <form onsubmit="return false;">
                    <input type="email" placeholder="Your email address"
                           class="w-full px-4 py-2.5 rounded-xl text-sm bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 mb-3 transition-all">
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold transition-all hover:opacity-90 active:scale-95"
                            style="background:#6C63FF;color:white;">
                        Subscribe
                    </button>
                </form>
            </div>

        </aside>
    </div>
</div>

{{-- ── NEWSLETTER SECTION ───────────────────────────────────── --}}
<section id="newsletter" class="mt-20 scroll-mt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="rounded-3xl px-8 py-14 md:px-16 text-center relative overflow-hidden"
         style="background:linear-gradient(135deg,#1A1A2E 0%,#4A4A8A 60%,#6C63FF 100%);">

        {{-- Decorative blobs --}}
        <div class="absolute top-0 right-0 w-64 h-64 rounded-full opacity-10"
             style="background:#6C63FF;transform:translate(30%,-30%);"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 rounded-full opacity-10"
             style="background:#6C63FF;transform:translate(-30%,30%);"></div>

        <div class="relative max-w-xl mx-auto">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-5"
                  style="background:rgba(108,99,255,0.4);color:#fff;">
                Weekly Newsletter
            </span>
            <h2 class="font-bold text-white mb-3" style="font-size:2rem;line-height:1.2;">
                Stay ahead of the curve.
            </h2>
            <p class="mb-8" style="color:rgba(255,255,255,0.7);font-size:1rem;">
                Join 15,000+ readers who receive our weekly curation of the most thoughtful articles, insights and inspiration.
            </p>
            <form onsubmit="return false;" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="Your email address"
                       class="flex-1 px-5 py-3 rounded-xl text-sm focus:outline-none focus:ring-2"
                       style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:#fff;--tw-ring-color:rgba(255,255,255,0.4);"
                       onfocus="this.style.background='rgba(255,255,255,0.18)'"
                       onblur="this.style.background='rgba(255,255,255,0.12)'">
                <button type="submit"
                        class="px-6 py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 active:scale-95 whitespace-nowrap"
                        style="background:#6C63FF;">
                    Subscribe free →
                </button>
            </form>
            <p class="mt-4 text-xs" style="color:rgba(255,255,255,0.4);">No spam, ever. Unsubscribe at any time.</p>
        </div>
    </div>
</section>

{{-- ── ABOUT SECTION ────────────────────────────────────────── --}}
<section id="about" class="mt-20 scroll-mt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 gap-10 items-center">

        {{-- Text --}}
        <div>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-5"
                  style="background:rgba(108,99,255,0.1);color:#6C63FF;">
                About Blog Simple
            </span>
            <h2 class="font-bold mb-4" style="font-size:2rem;line-height:1.2;color:#1A1A2E;">
                A space for thoughtful ideas.
            </h2>
            <p class="text-gray-500 leading-relaxed mb-4">
                Blog Simple is an independent publication dedicated to ideas that matter. We believe quality writing deserves a clean, distraction-free home — no clutter, just content.
            </p>
            <p class="text-gray-500 leading-relaxed mb-8">
                Our writers cover technology, creativity, productivity, and culture. Every article is hand-picked, carefully edited and written to spark genuine curiosity.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 active:scale-95"
                   style="background:#6C63FF;">
                    Explore articles
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold border transition-all hover:bg-gray-50"
                   style="border-color:#e5e7eb;color:#1A1A2E;">
                    Join the community
                </a>
            </div>
        </div>

        {{-- Stats cards --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
                <p class="font-bold text-3xl mb-1" style="color:#6C63FF;">{{ number_format($totalPosts) }}+</p>
                <p class="text-sm text-gray-500 font-medium">Articles published</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
                <p class="font-bold text-3xl mb-1" style="color:#6C63FF;">{{ $categories->count() }}</p>
                <p class="text-sm text-gray-500 font-medium">Categories</p>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
                <p class="font-bold text-3xl mb-1" style="color:#6C63FF;">15k+</p>
                <p class="text-sm text-gray-500 font-medium">Newsletter readers</p>
            </div>
            <div class="rounded-2xl p-6 text-center" style="background:linear-gradient(135deg,#4A4A8A,#6C63FF);">
                <p class="font-bold text-3xl text-white mb-1">100%</p>
                <p class="text-sm font-medium" style="color:rgba(255,255,255,0.75);">Free to read</p>
            </div>
        </div>
    </div>
</section>

@endsection
