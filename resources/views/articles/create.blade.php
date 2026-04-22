@extends('articles.layout')

@section('content')
<div class="card" style="max-width:600px; margin:0 auto; padding:1.5rem;">
    <h2 style="margin-bottom:1.5rem; font-size:1.2rem;">Nouvel article</h2>

    <form method="POST" action="/articles">
        @csrf
        <div class="form-group">
            <label>Titre *</label>
            <input type="text" name="titre" value="{{ old('titre') }}" placeholder="Titre de l'article" />
            @error('titre') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" placeholder="Description de l'article...">{{ old('description') }}</textarea>
            @error('description') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label>URL de l'image</label>
            <input type="text" name="image" value="{{ old('image') }}" placeholder="https://exemple.com/image.jpg" />
            @error('image') <div class="error-msg">{{ $message }}</div> @enderror
        </div>
        <div style="display:flex; gap:8px; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="/articles" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection