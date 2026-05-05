@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    @php
        $statsCards = [
            ['label' => 'Articles',             'value' => $stats['posts'],      'color' => '#4A4A8A', 'bg' => 'rgba(74,74,138,0.1)', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label' => 'Catégories',           'value' => $stats['categories'], 'color' => '#6C63FF', 'bg' => 'rgba(108,99,255,0.1)', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ['label' => 'Commentaires total',   'value' => $stats['comments'],   'color' => '#10B981', 'bg' => 'rgba(16,185,129,0.1)', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ['label' => 'En attente',           'value' => $stats['pending'],    'color' => '#F59E0B', 'bg' => 'rgba(245,158,11,0.1)', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'highlight' => true],
        ];
    @endphp

    @foreach($statsCards as $card)
        <div class="bg-white rounded-2xl p-6 border {{ !empty($card['highlight']) && $stats['pending'] > 0 ? 'border-amber-200' : 'border-gray-100' }} shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background:{{ $card['bg'] }};">
                    <svg class="w-6 h-6" style="color:{{ $card['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                @if(!empty($card['highlight']) && $stats['pending'] > 0)
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-amber-100 text-amber-700">Action requise</span>
                @endif
            </div>
            <p class="text-3xl font-extrabold mb-1" style="color:{{ $card['color'] }};">{{ $card['value'] }}</p>
            <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
        </div>
    @endforeach
</div>

{{-- Quick actions --}}
<div class="flex flex-wrap gap-3 mb-8">
    <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:opacity-90" style="background:#4A4A8A;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvel article
    </a>
    @if($stats['pending'] > 0)
        <a href="{{ route('admin.comments.index', ['filter' => 'pending']) }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all hover:opacity-90 bg-amber-500 text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $stats['pending'] }} commentaire(s) en attente
        </a>
    @endif
</div>

{{-- Recent posts table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-sm" style="color:#1A1A2E;">Articles récents</h2>
        <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold hover:underline" style="color:#6C63FF;">Voir tout →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-50">
                    <th class="text-left px-6 py-3 font-medium">Titre</th>
                    <th class="text-left px-6 py-3 font-medium">Catégorie</th>
                    <th class="text-left px-6 py-3 font-medium">Statut</th>
                    <th class="text-left px-6 py-3 font-medium">Commentaires</th>
                    <th class="text-left px-6 py-3 font-medium">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentPosts as $post)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium" style="color:#1A1A2E;">{{ Str::limit($post->title, 45) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium" style="background:rgba(108,99,255,0.1);color:#6C63FF;">{{ $post->category->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->published_at)
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Publié</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Brouillon</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $post->comments->count() }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $post->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 justify-end">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-medium px-2.5 py-1 rounded-lg hover:bg-indigo-50 transition-colors" style="color:#4A4A8A;">Modifier</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Supprimer cet article ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-medium px-2.5 py-1 rounded-lg text-red-500 hover:bg-red-50 transition-colors">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Aucun article.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
