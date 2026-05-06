@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="flex gap-6">

    {{-- ── LEFT PANEL ──────────────────────────────────────── --}}
    <div class="flex-1 min-w-0 space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-xl font-bold" style="color:#1A1A2E;">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 mt-0.5">Welcome back. Here's what's happening with your blog today.</p>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-3 gap-4">

            {{-- Total Posts --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Total Posts</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(74,74,138,0.1);">
                        <svg class="w-4 h-4" style="color:#4A4A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold mb-2" style="color:#1A1A2E;">{{ $stats['posts'] }}</p>
                <p class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    +12% from last month
                </p>
            </div>

            {{-- Total Categories --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Total Categories</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(108,99,255,0.1);">
                        <svg class="w-4 h-4" style="color:#6C63FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold mb-2" style="color:#1A1A2E;">{{ $stats['categories'] }}</p>
                <p class="text-xs text-gray-400">Mainly Technology &amp; Lifestyle</p>
            </div>

            {{-- Total Comments --}}
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Total Comments</p>
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.1);">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold mb-2" style="color:#1A1A2E;">{{ $stats['comments'] }}</p>
                <p class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    +42 this week
                </p>
            </div>
        </div>

        {{-- Recent Articles table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-sm" style="color:#1A1A2E;">Recent Articles</h2>
                <p class="text-xs text-gray-400 mt-0.5">A list of the most recently created or updated blog posts.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-50">
                            <th class="text-left px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Article Title</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Category</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Comments</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Last</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentPosts as $post)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 flex-shrink-0">
                                            @if($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 opacity-30" style="color:#4A4A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="font-semibold text-xs hover:text-[#6C63FF] transition-colors line-clamp-1" style="color:#1A1A2E;">
                                                {{ $post->title }}
                                            </a>
                                            <p class="text-xs text-gray-400 line-clamp-1 mt-0.5">{{ Str::limit($post->excerpt ?? $post->body, 40) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold" style="background:rgba(108,99,255,0.1);color:#6C63FF;">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    @if($post->published_at)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-emerald-100 text-emerald-700">Published</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-amber-100 text-amber-700">Draft</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        {{ $post->comments->count() }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-xs text-gray-400">
                                    {{ $post->created_at->format('M d') }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">Aucun article.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-50 flex items-center justify-between">
                <p class="text-xs text-gray-400">Showing 1 to {{ $recentPosts->count() }} of {{ $stats['posts'] }} results</p>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-500 hover:bg-gray-50 transition-colors">Previous</a>
                    <span class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white" style="background:#6C63FF;">1</span>
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-500 hover:bg-gray-50 transition-colors">2</a>
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-500 hover:bg-gray-50 transition-colors">3</a>
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-500 hover:bg-gray-50 transition-colors">Next</a>
                </div>
            </div>
        </div>

        {{-- Real-time Activity --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-sm mb-4" style="color:#1A1A2E;">Real-time Activity</h2>
            <div class="space-y-4">
                @foreach($recentPosts->take(3) as $i => $post)
                    @php
                        $colors = ['bg-blue-500','bg-emerald-500','bg-amber-500'];
                        $labels = ['New Comment','Post Published','Update Pending'];
                        $textColors = ['text-blue-600','text-emerald-600','text-amber-600'];
                    @endphp
                    <div class="flex items-start gap-3">
                        <div class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0 {{ $colors[$loop->index % 3] }}"></div>
                        <div>
                            <p class="text-xs text-gray-700">
                                <span class="font-semibold {{ $textColors[$loop->index % 3] }}">{{ $labels[$loop->index % 3] }}</span>
                                on "{{ Str::limit($post->title, 45) }}"
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── RIGHT PANEL ─────────────────────────────────────── --}}
    <div class="w-72 flex-shrink-0 space-y-5">

        {{-- Articles header --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex items-start justify-between gap-2 mb-1">
                    <div>
                        <h2 class="font-bold text-sm" style="color:#1A1A2E;">Articles</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Manage and curate your publication content</p>
                    </div>
                    <a href="{{ route('admin.posts.create') }}"
                       class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-white text-xs font-semibold whitespace-nowrap flex-shrink-0 transition-all hover:opacity-90"
                       style="background:#6C63FF;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create New Post
                    </a>
                </div>
            </div>

            {{-- Filters --}}
            <div class="px-5 py-3 border-b border-gray-50 flex gap-2">
                <select class="flex-1 text-xs px-2 py-1.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#6C63FF]">
                    <option>All Status</option>
                    <option>Published</option>
                    <option>Draft</option>
                </select>
                <select class="flex-1 text-xs px-2 py-1.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#6C63FF]">
                    <option>All Categories</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pending alert --}}
            @if($stats['pending'] > 0)
                <div class="mx-4 my-3 flex items-center gap-2 px-3 py-2 rounded-lg bg-amber-50 border border-amber-200">
                    <svg class="w-3.5 h-3.5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <a href="{{ route('admin.comments.index', ['filter' => 'pending']) }}" class="text-xs font-semibold text-amber-700 hover:underline">
                        {{ $stats['pending'] }} Requires immediate action
                    </a>
                </div>
            @endif

            {{-- Article mini-list --}}
            <div class="divide-y divide-gray-50">
                @foreach($recentPosts->take(4) as $post)
                    <a href="{{ route('admin.posts.edit', $post) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                        <div class="w-9 h-9 rounded-lg overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 flex-shrink-0">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-4 h-4 opacity-30" style="color:#4A4A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold line-clamp-1 group-hover:text-[#6C63FF] transition-colors" style="color:#1A1A2E;">{{ $post->title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">By {{ $post->user->name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="px-5 py-3 border-t border-gray-50">
                <p class="text-xs text-gray-400">Showing 1 to {{ min(4, $recentPosts->count()) }} of <strong>{{ $stats['posts'] }}</strong> articles</p>
            </div>
        </div>

        {{-- Performance Boost card --}}
        <div class="rounded-2xl p-6" style="background:linear-gradient(135deg,#4A4A8A 0%,#6C63FF 100%);">
            <p class="font-bold text-white mb-1">Performance Boost</p>
            <p class="text-xs mb-5" style="color:rgba(255,255,255,0.75);">Your blog traffic is up by 15% this month. Ready to scale even further?</p>
            <div class="space-y-2">
                <button class="w-full py-2.5 rounded-xl text-sm font-semibold bg-white transition-all hover:bg-gray-50 flex items-center justify-center gap-2" style="color:#4A4A8A;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Optimize Cache
                </button>
                <button class="w-full py-2.5 rounded-xl text-sm font-semibold border border-white/30 text-white hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    View Detailed Report
                </button>
            </div>
        </div>

    </div>
</div>

@endsection
