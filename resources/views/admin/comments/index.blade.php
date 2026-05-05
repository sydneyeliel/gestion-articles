@extends('layouts.admin')
@section('title', 'Commentaires')

@section('content')

{{-- Filter tabs --}}
<div class="flex items-center gap-1 mb-6 bg-white rounded-xl border border-gray-100 shadow-sm p-1 w-fit">
    @foreach(['all' => 'Tous', 'pending' => 'En attente', 'approved' => 'Approuvés'] as $key => $label)
        <a href="{{ route('admin.comments.index', ['filter' => $key]) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $filter === $key ? 'text-white shadow-sm' : 'text-gray-500 hover:text-gray-700' }}"
           style="{{ $filter === $key ? 'background:#4A4A8A;' : '' }}">
            {{ $label }}
            @if($key === 'pending' && $pending > 0)
                <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-amber-500 text-white">{{ $pending }}</span>
            @endif
        </a>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                    <th class="text-left px-6 py-3 font-medium">Auteur</th>
                    <th class="text-left px-6 py-3 font-medium">Article</th>
                    <th class="text-left px-6 py-3 font-medium">Commentaire</th>
                    <th class="text-left px-6 py-3 font-medium">Date</th>
                    <th class="text-left px-6 py-3 font-medium">Statut</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($comments as $comment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background:#6C63FF;">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-xs" style="color:#1A1A2E;">{{ $comment->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500 max-w-xs">
                            <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank" class="hover:underline" style="color:#4A4A8A;">{{ Str::limit($comment->post->title, 40) }}</a>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 max-w-xs">{{ Str::limit($comment->body, 80) }}</td>
                        <td class="px-6 py-4 text-xs text-gray-400">{{ $comment->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($comment->status === 'pending')
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">En attente</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Approuvé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 justify-end">
                                @if($comment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                        @csrf @method('PATCH')
                                        <button class="text-xs font-medium px-3 py-1.5 rounded-lg text-white transition-all hover:opacity-80" style="background:#10B981;">Approuver</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Supprimer ce commentaire ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-medium px-3 py-1.5 rounded-lg text-red-600 border border-red-200 hover:bg-red-50 transition-colors">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Aucun commentaire dans cette catégorie.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($comments->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $comments->links() }}</div>
    @endif
</div>

@endsection
