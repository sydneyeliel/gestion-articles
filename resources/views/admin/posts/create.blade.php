@extends('layouts.admin')
@section('title', 'Nouvel article')

@section('content')

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="flex gap-6">

        {{-- ── Main (70%) ──────────────────────────────── --}}
        <div class="flex-1 space-y-5">

            {{-- Title --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">Titre <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="post-title" value="{{ old('title') }}" required
                       class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}"
                       placeholder="Titre de l'article…">
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <label class="block text-sm font-semibold mt-4 mb-1.5 text-gray-500">Slug (auto)</label>
                <input type="text" id="post-slug" readonly
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-400 cursor-not-allowed"
                       placeholder="slug-genere-automatiquement">
            </div>

            {{-- Category --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">Catégorie <span class="text-red-500">*</span></label>
                <select name="category_id" required
                        class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                    <option value="">Choisir une catégorie…</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Image upload --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-3" style="color:#1A1A2E;">Image de couverture</label>
                <div id="drop-zone"
                     class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center cursor-pointer hover:border-[#6C63FF] hover:bg-indigo-50 transition-all">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm text-gray-500 mb-1">Glissez-déposez ou <span class="font-semibold" style="color:#6C63FF;">parcourez</span></p>
                    <p class="text-xs text-gray-400">PNG, JPG, WEBP — max. 2 Mo</p>
                    <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                </div>
                <div id="image-preview" class="mt-3 hidden">
                    <img id="preview-img" src="" alt="Preview" class="rounded-xl max-h-48 object-cover">
                </div>
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Body --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">Contenu <span class="text-red-500">*</span></label>
                <textarea name="body" rows="16" required
                          class="w-full px-4 py-3 rounded-xl border text-sm resize-y focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}"
                          placeholder="Rédigez le contenu de votre article…">{{ old('body') }}</textarea>
                @error('body') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ── Sidebar (30%) ───────────────────────────── --}}
        <div class="w-72 flex-shrink-0 space-y-5">

            {{-- Publish --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-sm mb-4" style="color:#1A1A2E;">Publication</h3>

                <label class="flex items-center gap-3 cursor-pointer mb-6">
                    <div class="relative">
                        <input type="checkbox" name="published" value="1" id="publish-toggle" class="sr-only" {{ old('published') ? 'checked' : '' }}>
                        <div class="toggle-track w-11 h-6 rounded-full border-2 border-gray-200 bg-gray-200 transition-all"></div>
                        <div class="toggle-thumb absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-all"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700" id="publish-label">Brouillon</span>
                </label>

                <button type="submit" class="w-full py-3 rounded-xl text-white text-sm font-semibold hover:opacity-90 active:scale-95 transition-all mb-3" style="background:#4A4A8A;">
                    Enregistrer l'article
                </button>
                <a href="{{ route('admin.posts.index') }}" class="block w-full py-2.5 rounded-xl text-sm font-medium text-center text-gray-500 hover:bg-gray-100 transition-colors">
                    Annuler
                </a>
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

dropZone?.addEventListener('click', () => fileInput.click());
dropZone?.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-[#6C63FF]'); });
dropZone?.addEventListener('dragleave', () => dropZone.classList.remove('border-[#6C63FF]'));
dropZone?.addEventListener('drop', e => {
    e.preventDefault();
    if (e.dataTransfer.files[0]) { fileInput.files = e.dataTransfer.files; showPreview(e.dataTransfer.files[0]); }
});
fileInput?.addEventListener('change', () => { if (fileInput.files[0]) showPreview(fileInput.files[0]); });

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = e => { previewImg.src = e.target.result; preview.classList.remove('hidden'); };
    reader.readAsDataURL(file);
}

// Publish toggle
const toggle = document.getElementById('publish-toggle');
const label  = document.getElementById('publish-label');
const track  = document.querySelector('.toggle-track');
const thumb  = document.querySelector('.toggle-thumb');

function updateToggle() {
    if (toggle.checked) {
        track.style.background = '#4A4A8A'; track.style.borderColor = '#4A4A8A';
        thumb.style.transform = 'translateX(20px)';
        label.textContent = 'Publié';
    } else {
        track.style.background = ''; track.style.borderColor = '';
        thumb.style.transform = '';
        label.textContent = 'Brouillon';
    }
}
toggle?.addEventListener('change', updateToggle);
updateToggle();
</script>

@endsection
