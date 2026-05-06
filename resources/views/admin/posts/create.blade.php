@extends('layouts.admin')
@section('title', 'Nouvel article')

@section('content')

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" id="post-form">
    @csrf

    <div class="flex gap-6 items-start">

        {{-- ── MAIN COLUMN (70%) ─────────────────────────── --}}
        <div class="flex-1 min-w-0 space-y-5">

            {{-- Title + Slug --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="post-title" value="{{ old('title') }}" required
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
                    <label class="block text-sm font-semibold mb-1.5 text-gray-400">
                        Slug (généré automatiquement)
                    </label>
                    <div class="relative">
                        <input type="text" id="post-slug" readonly
                               class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-400 cursor-not-allowed"
                               placeholder="slug-genere-automatiquement">
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
                    <option value="">Choisir une catégorie…</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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

            {{-- Cover image drag & drop --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-4" style="color:#1A1A2E;">
                    Image de couverture
                </label>
                <div id="drop-zone"
                     class="relative border-2 border-dashed rounded-xl p-10 text-center cursor-pointer transition-all {{ $errors->has('image') ? 'border-red-300 bg-red-50' : 'border-gray-200 hover:border-[#6C63FF] hover:bg-indigo-50/50' }}">
                    <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                    <div id="drop-content">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-xl flex items-center justify-center bg-gray-100">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">
                            Glissez-déposez ou
                            <span class="font-semibold" style="color:#6C63FF;">parcourez</span>
                        </p>
                        <p class="text-xs text-gray-400">PNG, JPG, WEBP — max. 2 Mo</p>
                    </div>
                </div>
                <div id="image-preview" class="mt-3 hidden">
                    <div class="relative inline-block">
                        <img id="preview-img" src="" alt="Aperçu" class="rounded-xl max-h-52 object-cover shadow-sm">
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
                          placeholder="Rédigez le contenu de votre article…"
                          class="w-full px-4 py-3 rounded-xl border text-sm resize-y focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent transition-all {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 hover:border-gray-300' }}">{{ old('body') }}</textarea>
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

                {{-- Status toggle --}}
                <div class="flex items-center justify-between mb-6 p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <div>
                        <p class="text-sm font-medium" style="color:#1A1A2E;" id="publish-label">Brouillon</p>
                        <p class="text-xs text-gray-400" id="publish-desc">Non visible sur le blog</p>
                    </div>
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="published" value="1" id="publish-toggle" class="sr-only"
                               {{ old('published') ? 'checked' : '' }}>
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
                    Enregistrer l'article
                </button>
                <a href="{{ route('admin.posts.index') }}"
                   class="block w-full py-2.5 rounded-xl text-sm font-medium text-center text-gray-500 hover:bg-gray-100 transition-colors">
                    Annuler
                </a>
            </div>

            {{-- Tips card --}}
            <div class="rounded-2xl p-5 border border-indigo-100" style="background:rgba(108,99,255,0.04);">
                <p class="text-xs font-semibold mb-3" style="color:#4A4A8A;">Conseils de rédaction</p>
                <ul class="space-y-2 text-xs text-gray-500">
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 w-4 h-4 rounded-full flex-shrink-0 flex items-center justify-center text-white" style="background:#6C63FF;font-size:9px;">1</span>
                        Rédigez un titre accrocheur de 60–80 caractères.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 w-4 h-4 rounded-full flex-shrink-0 flex items-center justify-center text-white" style="background:#6C63FF;font-size:9px;">2</span>
                        Ajoutez une image de couverture au format 16:9.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-0.5 w-4 h-4 rounded-full flex-shrink-0 flex items-center justify-center text-white" style="background:#6C63FF;font-size:9px;">3</span>
                        Structurez le contenu avec des paragraphes courts.
                    </li>
                </ul>
            </div>

        </div>
    </div>
</form>

<script>
// Slug auto-generate
const titleInput = document.getElementById('post-title');
const slugInput  = document.getElementById('post-slug');
titleInput?.addEventListener('input', () => {
    slugInput.value = titleInput.value
        .toLowerCase()
        .normalize('NFD').replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim().replace(/\s+/g, '-');
});

// Image drag & drop
const dropZone   = document.getElementById('drop-zone');
const fileInput  = document.getElementById('image-input');
const preview    = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');
const dropContent = document.getElementById('drop-content');
const removeBtn  = document.getElementById('remove-image');

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
const toggle     = document.getElementById('publish-toggle');
const label      = document.getElementById('publish-label');
const desc       = document.getElementById('publish-desc');
const track      = document.querySelector('.toggle-track');
const thumb      = document.querySelector('.toggle-thumb');

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
