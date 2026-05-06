@extends('layouts.admin')
@section('title', 'Modifier l\'article')

@section('content')

{{-- Delete form lives OUTSIDE the edit form to prevent nesting --}}
<form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
      id="delete-form"
      onsubmit="return confirm('Supprimer définitivement cet article ?')">
    @csrf @method('DELETE')
</form>

<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" id="post-form">
    @csrf @method('PUT')

    <div class="flex gap-6 items-start">

        {{-- ── MAIN COLUMN (70%) ─────────────────────────── --}}
        <div class="flex-1 min-w-0 space-y-5">

            {{-- Title + Slug --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                           placeholder="Titre de l'article…"
                           class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent transition-all {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 hover:border-gray-300' }}">
                    @error('title')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1.5 text-gray-400">Slug actuel</label>
                    <div class="relative">
                        <input type="text" value="{{ $post->slug }}" readonly
                               class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-400 cursor-not-allowed">
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Category --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">
                    Catégorie <span class="text-red-500">*</span>
                </label>
                <select name="category_id" required
                        class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent transition-all {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 hover:border-gray-300' }}">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Cover image --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-4" style="color:#1A1A2E;">Image de couverture</label>

                @if($post->image)
                    <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Image actuelle"
                             class="h-16 w-24 rounded-lg object-cover flex-shrink-0">
                        <div>
                            <p class="text-xs font-medium text-gray-600">Image actuelle</p>
                            <p class="text-xs text-gray-400 mt-0.5">Uploadez une nouvelle image pour la remplacer</p>
                        </div>
                    </div>
                @endif

                <div id="drop-zone"
                     class="relative border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition-all {{ $errors->has('image') ? 'border-red-300 bg-red-50' : 'border-gray-200 hover:border-[#6C63FF] hover:bg-indigo-50/50' }}">
                    <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                    <div id="drop-content">
                        <div class="w-10 h-10 mx-auto mb-2 rounded-xl flex items-center justify-center bg-gray-100">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Glissez-déposez ou <span class="font-semibold" style="color:#6C63FF;">parcourez</span></p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — max. 2 Mo</p>
                    </div>
                </div>

                <div id="image-preview" class="mt-3 hidden">
                    <div class="relative inline-block">
                        <img id="preview-img" src="" alt="Aperçu" class="rounded-xl max-h-48 object-cover shadow-sm">
                        <button type="button" id="remove-image"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white shadow-md flex items-center justify-center text-gray-500 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                @error('image')
                    <p class="mt-2 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Body --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">
                    Contenu <span class="text-red-500">*</span>
                </label>
                <textarea name="body" rows="18" required
                          class="w-full px-4 py-3 rounded-xl border text-sm resize-y focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent transition-all {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 hover:border-gray-300' }}">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- ── SIDEBAR (30%) ─────────────────────────────── --}}
        <div class="w-72 flex-shrink-0 space-y-5">

            {{-- Publication card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-sm mb-5" style="color:#1A1A2E;">Publication</h3>

                <div class="flex items-center justify-between mb-6 p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <div>
                        <p class="text-sm font-medium" style="color:#1A1A2E;" id="publish-label">
                            {{ $post->published_at ? 'Publié' : 'Brouillon' }}
                        </p>
                        <p class="text-xs text-gray-400" id="publish-desc">
                            {{ $post->published_at ? 'Visible sur le blog' : 'Non visible sur le blog' }}
                        </p>
                    </div>
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="published" value="1" id="publish-toggle" class="sr-only"
                               {{ $post->published_at ? 'checked' : '' }}>
                        <div class="toggle-track w-12 h-6 rounded-full border-2 border-gray-200 bg-gray-200 transition-all duration-200"></div>
                        <div class="toggle-thumb absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-all duration-200"></div>
                    </label>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-white text-sm font-semibold hover:opacity-90 active:scale-95 transition-all mb-3"
                        style="background:#4A4A8A;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.posts.index') }}"
                   class="block w-full py-2.5 rounded-xl text-sm font-medium text-center text-gray-500 hover:bg-gray-100 transition-colors">
                    Annuler
                </a>
            </div>

            {{-- View on blog --}}
            @if($post->published_at)
                <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Voir sur le blog
                </a>
            @endif

            {{-- Danger zone --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-6">
                <h3 class="font-bold text-sm text-red-600 mb-1">Zone de danger</h3>
                <p class="text-xs text-gray-400 mb-4">Cette action est irréversible.</p>
                <button type="submit" form="delete-form"
                        class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-red-600 border border-red-200 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer l'article
                </button>
            </div>

        </div>
    </div>
</form>

<script>
// Image drag & drop
const dropZone    = document.getElementById('drop-zone');
const fileInput   = document.getElementById('image-input');
const preview     = document.getElementById('image-preview');
const previewImg  = document.getElementById('preview-img');
const dropContent = document.getElementById('drop-content');
const removeBtn   = document.getElementById('remove-image');

dropZone?.addEventListener('click', (e) => {
    if (e.target !== removeBtn && !removeBtn?.contains(e.target)) fileInput.click();
});
dropZone?.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.classList.add('border-[#6C63FF]', 'bg-indigo-50/50');
});
dropZone?.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-[#6C63FF]', 'bg-indigo-50/50');
});
dropZone?.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('border-[#6C63FF]', 'bg-indigo-50/50');
    if (e.dataTransfer.files[0]) { fileInput.files = e.dataTransfer.files; showPreview(e.dataTransfer.files[0]); }
});
fileInput?.addEventListener('change', () => { if (fileInput.files[0]) showPreview(fileInput.files[0]); });

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        preview.classList.remove('hidden');
        dropContent.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

removeBtn?.addEventListener('click', e => {
    e.stopPropagation();
    preview.classList.add('hidden');
    dropContent.classList.remove('hidden');
    fileInput.value = '';
});

// Publish toggle
const toggle = document.getElementById('publish-toggle');
const label  = document.getElementById('publish-label');
const desc   = document.getElementById('publish-desc');
const track  = document.querySelector('.toggle-track');
const thumb  = document.querySelector('.toggle-thumb');

function updateToggle() {
    if (toggle.checked) {
        track.style.background  = '#4A4A8A';
        track.style.borderColor = '#4A4A8A';
        thumb.style.transform   = 'translateX(24px)';
        label.textContent = 'Publié';
        desc.textContent  = 'Visible sur le blog';
    } else {
        track.style.background  = '';
        track.style.borderColor = '';
        thumb.style.transform   = '';
        label.textContent = 'Brouillon';
        desc.textContent  = 'Non visible sur le blog';
    }
}
toggle?.addEventListener('change', updateToggle);
updateToggle();
</script>

@endsection
