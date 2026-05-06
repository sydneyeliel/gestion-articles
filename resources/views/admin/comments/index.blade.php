@extends('layouts.admin')
@section('title', 'Commentaires')

@section('content')

{{-- ── FILTER TABS ───────────────────────────────────────── --}}
<div class="flex items-center gap-1 mb-6 bg-white rounded-xl border border-gray-100 shadow-sm p-1 w-fit">
    @foreach(['all' => 'Tous', 'pending' => 'En attente', 'approved' => 'Approuvés'] as $key => $label)
        <a href="{{ route('admin.comments.index', ['filter' => $key]) }}"
           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $filter === $key ? 'text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}"
           @if($filter === $key) style="background:#4A4A8A;" @endif>
            {{ $label }}
            @if($key === 'pending' && $pending > 0)
                <span class="px-1.5 py-0.5 text-xs font-bold rounded-full bg-amber-500 text-white">{{ $pending }}</span>
            @endif
        </a>
    @endforeach
</div>

{{-- ── COMMENTS TABLE ────────────────────────────────────── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Auteur</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Article</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Commentaire</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Date</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Statut</th>
                    <th class="px-6 py-3.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($comments as $comment)
                    <tr class="hover:bg-gray-50/60 transition-colors">

                        {{-- Author --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background:#6C63FF;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-xs whitespace-nowrap" style="color:#1A1A2E;">
                                    {{ $comment->user->name }}
                                </span>
                            </div>
                        </td>

                        {{-- Article title --}}
                        <td class="px-6 py-4 max-w-[180px]">
                            <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank"
                               class="text-xs font-medium hover:underline line-clamp-2 leading-snug"
                               style="color:#4A4A8A;">
                                {{ Str::limit($comment->post->title, 45) }}
                            </a>
                        </td>

                        {{-- Excerpt --}}
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                {{ Str::limit($comment->body, 90) }}
                            </p>
                        </td>

                        {{-- Date --}}
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                            {{ $comment->created_at->format('d M Y') }}
                        </td>

                        {{-- Status badge --}}
                        <td class="px-6 py-4">
                            @if($comment->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    En attente
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Approuvé
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 justify-end">
                                @if($comment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                        @csrf @method('PATCH')
                                        <button class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg text-white transition-all hover:opacity-80 active:scale-95"
                                                style="background:#10B981;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Approuver
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                                      onsubmit="return confirm('Supprimer ce commentaire ?')">
                                    @csrf @method('DELETE')
                                    <button class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg text-red-600 border border-red-200 hover:bg-red-50 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="w-12 h-12 mx-auto mb-4 rounded-xl flex items-center justify-center bg-gray-50">
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-500">Aucun commentaire dans cette catégorie.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($comments->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $comments->links() }}
        </div>
    @endif
</div>

@endsection
