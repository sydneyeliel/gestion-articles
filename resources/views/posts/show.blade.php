@extends('layouts.app')

@section('title', $post->title . ' — Blog Simple')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────── --}}
<div class="relative h-80 md:h-96 overflow-hidden">
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
             class="w-full h-full object-cover">
    @else
        <div class="w-full h-full" style="background:linear-gradient(135deg,#4A4A8A 0%,#6C63FF 100%);"></div>
    @endif
    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(26,26,46,0.85) 0%, rgba(26,26,46,0.3) 60%, transparent 100%);"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 max-w-4xl mx-auto">
        <a href="{{ route('home', ['category' => $post->category->slug]) }}"
           class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-4" style="background:#6C63FF;color:white;">
            {{ $post->category->name }}
        </a>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $post->title }}</h1>
    </div>
</div>

{{-- ── CONTENT ───────────────────────────────────────────────── --}}
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Meta --}}
    <div class="flex flex-wrap items-center gap-4 mb-8 pb-8 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background:#4A4A8A;">
                {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-sm" style="color:#1A1A2E;">{{ $post->user->name }}</p>
                <p class="text-xs text-gray-400">{{ $post->published_at->format('d F Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 text-sm text-gray-400 ml-auto">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $post->readingTime() }} min de lecture
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                {{ $post->approvedComments->count() }} commentaire(s)
            </span>
        </div>
    </div>

    {{-- Body --}}
    <div class="prose max-w-none text-gray-700 leading-relaxed mb-12" style="font-size:1.0625rem;">
        {!! nl2br(e($post->body)) !!}
    </div>

    {{-- ── COMMENTS ────────────────────────────────────── --}}
    <section class="border-t border-gray-100 pt-10" id="comments">

        <h2 class="text-2xl font-bold mb-6" style="color:#1A1A2E;">
            Commentaires <span class="text-lg font-normal text-gray-400">({{ $post->approvedComments->count() }})</span>
        </h2>

        {{-- Comment list --}}
        @if($post->approvedComments->count())
            <div class="space-y-6 mb-8">
                @foreach($post->approvedComments as $comment)
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background:#6C63FF;">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="font-semibold text-sm" style="color:#1A1A2E;">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('Supprimer ce commentaire ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->body }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-2xl p-8 text-center mb-8">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <p class="text-gray-500 text-sm">Soyez le premier à commenter !</p>
            </div>
        @endif

        {{-- Comment form / CTA --}}
        @auth
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold mb-4 text-sm" style="color:#1A1A2E;">Laisser un commentaire</h3>
                <form method="POST" action="{{ route('comments.store', $post->slug) }}" id="comment-form">
                    @csrf
                    <div class="relative">
                        <textarea name="body" id="comment-body" rows="4"
                                  maxlength="500"
                                  placeholder="Partagez votre avis… (min. 10 caractères, max. 500)"
                                  class="w-full px-4 py-3 rounded-xl border text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}">{{ old('body') }}</textarea>
                        <div class="flex items-center justify-between mt-2">
                            <div>
                                @error('body')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <span id="char-counter" class="text-xs text-gray-400">0 / 500</span>
                        </div>
                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-white text-sm font-semibold transition-all hover:opacity-90 active:scale-95" style="background:#4A4A8A;">
                            Publier le commentaire
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-6 text-center">
                <p class="text-gray-600 mb-4">Connectez-vous pour laisser un commentaire</p>
                <div class="flex items-center justify-center gap-3">
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-xl text-white text-sm font-semibold" style="background:#4A4A8A;">Se connecter</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 rounded-xl text-sm font-semibold border-2 hover:bg-[#4A4A8A] hover:text-white hover:border-[#4A4A8A] transition-all" style="border-color:#4A4A8A;color:#4A4A8A;">S'inscrire</a>
                </div>
            </div>
        @endauth
    </section>

    {{-- Related articles --}}
    @if($related->count())
        <section class="mt-14 border-t border-gray-100 pt-10">
            <h2 class="text-xl font-bold mb-6" style="color:#1A1A2E;">Articles similaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($related as $r)
                    <a href="{{ route('posts.show', $r->slug) }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                        <div class="aspect-video overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100">
                            @if($r->image)
                                <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="text-xs font-semibold mb-1" style="color:#6C63FF;">{{ $r->category->name }}</p>
                            <h3 class="text-sm font-bold leading-snug" style="color:#1A1A2E;">{{ $r->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

</div>

<script>
const body = document.getElementById('comment-body');
const counter = document.getElementById('char-counter');
if (body && counter) {
    const update = () => {
        const len = body.value.length;
        counter.textContent = len + ' / 500';
        counter.style.color = len > 450 ? '#EF4444' : '#9CA3AF';
    };
    body.addEventListener('input', update);
    update();
}
</script>

@endsection
