@extends('layouts.admin')
@section('title', 'Articles')

@section('content')

{{-- ── HEADER ────────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-xl font-bold" style="color:#1A1A2E;">Articles List</h1>
        <p class="text-sm text-gray-400 mt-0.5">Manage and curate all your blog posts.</p>
    </div>
    <a href="{{ route('admin.posts.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-semibold hover:opacity-90 active:scale-95 transition-all"
       style="background:#6C63FF;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        + New Article
    </a>
</div>

{{-- ── FILTERS ───────────────────────────────────────────── --}}
<div class="flex items-center gap-3 mb-4">
    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex items-center gap-3 flex-1">
        <div class="relative flex-1 max-w-xs">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search articles, authors..."
                   class="w-full pl-9 pr-4 py-2 text-sm rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent transition-all">
        </div>
        <select name="status" class="text-sm px-3 py-2 rounded-xl border border-gray-200 bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#6C63FF] transition-all">
            <option value="">All Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <select name="category" class="text-sm px-3 py-2 rounded-xl border border-gray-200 bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#6C63FF] transition-all">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 rounded-xl text-sm font-medium text-white transition-all hover:opacity-90" style="background:#4A4A8A;">
            Filter
        </button>
    </form>
    @if(request('search') || request('status') || request('category'))
        <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-gray-400 hover:text-red-500 transition-colors whitespace-nowrap">
            Clear Filters
        </a>
    @endif
</div>

{{-- ── TOTAL BANNER ──────────────────────────────────────── --}}
<div class="rounded-2xl px-6 py-4 mb-5 flex items-center justify-between" style="background:linear-gradient(135deg,#4A4A8A 0%,#6C63FF 100%);">
    <div>
        <p class="text-xs font-semibold text-white/70 uppercase tracking-widest mb-0.5">Total Content</p>
        <p class="text-2xl font-bold text-white">{{ number_format($posts->total()) }} Articles</p>
    </div>
    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/15">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
    </div>
</div>

{{-- ── TABLE ─────────────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Article</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Category</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Status</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Comments</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Date Published</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posts as $post)
                    @php
                        $catColors = [
                            0 => ['text' => '#2563EB', 'bg' => 'rgba(37,99,235,0.08)'],
                            1 => ['text' => '#D97706', 'bg' => 'rgba(217,119,6,0.08)'],
                            2 => ['text' => '#059669', 'bg' => 'rgba(5,150,105,0.08)'],
                            3 => ['text' => '#7C3AED', 'bg' => 'rgba(124,58,237,0.08)'],
                            4 => ['text' => '#DB2777', 'bg' => 'rgba(219,39,119,0.08)'],
                        ];
                        $ci = $post->category_id % 5;
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors">

                        {{-- Article title + thumbnail --}}
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 flex-shrink-0">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-4 h-4 opacity-30" style="color:#4A4A8A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-xs line-clamp-1" style="color:#1A1A2E;">{{ $post->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">By {{ $post->user->name }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="px-6 py-3.5">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide"
                                  style="color:{{ $catColors[$ci]['text'] }};background:{{ $catColors[$ci]['bg'] }};">
                                {{ $post->category->name }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-3.5">
                            @if($post->published_at)
                                <span class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                                    Published
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-xs font-semibold text-amber-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                                    Draft
                                </span>
                            @endif
                        </td>

                        {{-- Comments --}}
                        <td class="px-6 py-3.5">
                            <span class="flex items-center gap-1.5 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                {{ $post->comments->count() }}
                            </span>
                        </td>

                        {{-- Date Published --}}
                        <td class="px-6 py-3.5 text-xs text-gray-400">
                            {{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-1 justify-end">
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                   class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-[#4A4A8A] hover:bg-indigo-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                      onsubmit="return confirm('Supprimer cet article ?')">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-xl flex items-center justify-center bg-gray-50">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-500 mb-1">No articles found.</p>
                            <a href="{{ route('admin.posts.create') }}" class="text-sm font-semibold hover:underline" style="color:#6C63FF;">
                                Create the first one →
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 flex justify-end">
            {{ $posts->links() }}
        </div>
    @endif
</div>

@endsection
