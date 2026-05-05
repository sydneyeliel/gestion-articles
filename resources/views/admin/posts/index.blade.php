@extends('layouts.admin')
@section('title', 'Articles')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">{{ $posts->total() }} article(s) au total</p>
    <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-semibold hover:opacity-90 transition-all" style="background:#4A4A8A;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvel article
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100">
                    <th class="text-left px-6 py-3 font-medium">Titre</th>
                    <th class="text-left px-6 py-3 font-medium">Catégorie</th>
                    <th class="text-left px-6 py-3 font-medium">Statut</th>
                    <th class="text-left px-6 py-3 font-medium">Commentaires</th>
                    <th class="text-left px-6 py-3 font-medium">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium" style="color:#1A1A2E;">{{ Str::limit($post->title, 50) }}</td>
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
                                <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="text-xs text-gray-400 hover:text-gray-600 px-2.5 py-1 rounded-lg hover:bg-gray-100 transition-colors">Voir</a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-medium px-2.5 py-1 rounded-lg hover:bg-indigo-50 transition-colors" style="color:#4A4A8A;">Modifier</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Supprimer cet article ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-medium px-2.5 py-1 rounded-lg text-red-500 hover:bg-red-50 transition-colors">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">Aucun article. <a href="{{ route('admin.posts.create') }}" class="underline" style="color:#6C63FF;">Créer le premier</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">{{ $posts->links() }}</div>
    @endif
</div>

@endsection
