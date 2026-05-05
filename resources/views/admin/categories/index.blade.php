@extends('layouts.admin')
@section('title', 'Catégories')

@section('content')

<div class="flex gap-6">

    {{-- Form --}}
    <div class="w-80 flex-shrink-0 space-y-4">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-sm mb-4" style="color:#1A1A2E;">Nouvelle catégorie</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
                @csrf
                <div>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nom de la catégorie"
                           class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl text-white text-sm font-semibold hover:opacity-90 transition-all" style="background:#4A4A8A;">
                    Ajouter
                </button>
            </form>
        </div>

    </div>

    {{-- List --}}
    <div class="flex-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <p class="text-sm text-gray-500">{{ $categories->count() }} catégorie(s)</p>
            </div>
            <ul class="divide-y divide-gray-50">
                @forelse($categories as $cat)
                    <li class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full" style="background:#6C63FF;"></div>
                            <div>
                                <p class="font-medium text-sm" style="color:#1A1A2E;">{{ $cat->name }}</p>
                                <p class="text-xs text-gray-400">{{ $cat->posts_count }} article(s) · slug: {{ $cat->slug }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            {{-- Edit inline --}}
                            <button onclick="toggleEdit({{ $cat->id }})" class="text-xs font-medium px-2.5 py-1 rounded-lg hover:bg-indigo-50 transition-colors" style="color:#4A4A8A;">Modifier</button>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-medium px-2.5 py-1 rounded-lg text-red-500 hover:bg-red-50 transition-colors">Supprimer</button>
                            </form>
                        </div>
                    </li>
                    <li id="edit-{{ $cat->id }}" class="hidden px-6 py-3 bg-indigo-50 border-b border-indigo-100">
                        <form method="POST" action="{{ route('admin.categories.update', $cat) }}" class="flex gap-2">
                            @csrf @method('PUT')
                            <input type="text" name="name" value="{{ $cat->name }}"
                                   class="flex-1 px-3 py-2 rounded-lg border border-indigo-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF]">
                            <button class="px-4 py-2 rounded-lg text-white text-sm font-medium" style="background:#4A4A8A;">Enregistrer</button>
                            <button type="button" onclick="toggleEdit({{ $cat->id }})" class="px-4 py-2 rounded-lg text-gray-500 text-sm hover:bg-white transition-colors">Annuler</button>
                        </form>
                    </li>
                @empty
                    <li class="px-6 py-12 text-center text-gray-400 text-sm">Aucune catégorie. Créez-en une !</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<script>
function toggleEdit(id) {
    const el = document.getElementById('edit-' + id);
    el.classList.toggle('hidden');
}
</script>

@endsection
