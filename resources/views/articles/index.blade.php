@extends('articles.layout')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <h2 style="font-size:1.4rem;">Articles <span style="font-size:0.9rem; color:#888;">({{ count($articles) }})</span></h2>
    <a href="/articles/create" class="btn btn-primary">+ Nouvel article</a>
</div>

@if(count($articles) === 0)
    <div style="text-align:center; padding:3rem; color:#888; border: 2px dashed #ddd; border-radius:8px;">
        Aucun article pour le moment. Créez-en un !
    </div>
@else
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:1rem;">
        @foreach($articles as $article)
        <div class="card">
            @if($article->image)
                <img src="{{ $article->image }}" alt="{{ $article->titre }}" style="width:100%; height:160px; object-fit:cover;" onerror="this.style.display='none'">
            @else
                <div style="width:100%; height:160px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:0.85rem;">Aucune image</div>
            @endif
            <div style="padding:1rem;">
                <h3 style="font-size:1rem; margin-bottom:0.5rem;">{{ $article->titre }}</h3>
                <p style="font-size:0.85rem; color:#666; line-height:1.5; margin-bottom:1rem;">{{ Str::limit($article->description, 100) }}</p>
                <div style="display:flex; gap:8px;">
                    <a href="/articles/{{ $article->id }}/edit" class="btn btn-warning" style="font-size:0.8rem; padding:5px 12px;">Modifier</a>
                    <form method="POST" action="/articles/{{ $article->id }}" onsubmit="return confirm('Supprimer cet article ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="font-size:0.8rem; padding:5px 12px;">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
