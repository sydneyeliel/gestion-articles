@extends('layouts.admin')
@section('title', 'Modifier l\'article')

@section('content')

<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="flex gap-6">

        {{-- Main --}}
        <div class="flex-1 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">Titre <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                       class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                <label class="block text-sm font-semibold mt-4 mb-1.5 text-gray-500">Slug actuel</label>
                <input type="text" value="{{ $post->slug }}" readonly class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-400 cursor-not-allowed">
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">Catégorie <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full px-4 py-3 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-3" style="color:#1A1A2E;">Image de couverture</label>
                @if($post->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Cover actuel" class="h-36 rounded-xl object-cover">
                        <p class="text-xs text-gray-400 mt-1">Image actuelle — uploadez une nouvelle pour la remplacer</p>
                    </div>
                @endif
                <div id="drop-zone" class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-[#6C63FF] hover:bg-indigo-50 transition-all">
                    <p class="text-sm text-gray-500">Glissez-déposez ou <span class="font-semibold" style="color:#6C63FF;">parcourez</span></p>
                    <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                </div>
                <div id="image-preview" class="mt-3 hidden">
                    <img id="preview-img" src="" class="rounded-xl max-h-40 object-cover">
                </div>
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <label class="block text-sm font-semibold mb-1.5" style="color:#1A1A2E;">Contenu <span class="text-red-500">*</span></label>
                <textarea name="body" rows="16" required
                          class="w-full px-4 py-3 rounded-xl border text-sm resize-y focus:outline-none focus:ring-2 focus:ring-[#6C63FF] {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">{{ old('body', $post->body) }}</textarea>
                @error('body') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="w-72 flex-shrink-0 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-sm mb-4" style="color:#1A1A2E;">Publication</h3>

                <label class="flex items-center gap-3 cursor-pointer mb-6">
                    <div class="relative">
                        <input type="checkbox" name="published" value="1" id="publish-toggle" class="sr-only" {{ $post->published_at ? 'checked' : '' }}>
                        <div class="toggle-track w-11 h-6 rounded-full border-2 border-gray-200 bg-gray-200 transition-all"></div>
                        <div class="toggle-thumb absolute top-0.5 left-0.5 w-5 h-5 rounded-full bg-white shadow transition-all"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700" id="publish-label">{{ $post->published_at ? 'Publié' : 'Brouillon' }}</span>
                </label>

                <button type="submit" class="w-full py-3 rounded-xl text-white text-sm font-semibold hover:opacity-90 active:scale-95 transition-all mb-3" style="background:#4A4A8A;">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.posts.index') }}" class="block w-full py-2.5 rounded-xl text-sm font-medium text-center text-gray-500 hover:bg-gray-100 transition-colors">
                    Annuler
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-6">
                <h3 class="font-bold text-sm text-red-600 mb-3">Zone de danger</h3>
                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Supprimer définitivement cet article ?')">
                    @csrf @method('DELETE')
                    <button class="w-full py-2.5 rounded-xl text-sm font-medium text-red-600 border border-red-200 hover:bg-red-50 transition-colors">
                        Supprimer l'article
                    </button>
                </form>
            </div>

        </div>
    </div>
</form>

<script>
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('image-input');
const preview = document.getElementById('image-preview');
const previewImg = document.getElementById('preview-img');
dropZone?.addEventListener('click', () => fileInput.click());
dropZone?.addEventListener('dragover', e => { e.preventDefault(); });
dropZone?.addEventListener('drop', e => { e.preventDefault(); if (e.dataTransfer.files[0]) { fileInput.files = e.dataTransfer.files; showPreview(e.dataTransfer.files[0]); } });
fileInput?.addEventListener('change', () => { if (fileInput.files[0]) showPreview(fileInput.files[0]); });
function showPreview(file) { const r = new FileReader(); r.onload = e => { previewImg.src = e.target.result; preview.classList.remove('hidden'); }; r.readAsDataURL(file); }

const toggle = document.getElementById('publish-toggle');
const label = document.getElementById('publish-label');
const track = document.querySelector('.toggle-track');
const thumb = document.querySelector('.toggle-thumb');
function updateToggle() {
    if (toggle.checked) { track.style.background = '#4A4A8A'; track.style.borderColor = '#4A4A8A'; thumb.style.transform = 'translateX(20px)'; label.textContent = 'Publié'; }
    else { track.style.background = ''; track.style.borderColor = ''; thumb.style.transform = ''; label.textContent = 'Brouillon'; }
}
toggle?.addEventListener('change', updateToggle);
updateToggle();
</script>

@endsection
