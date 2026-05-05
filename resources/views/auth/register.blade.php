<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Blog Simple</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center py-10" style="background:#F8F8FF;">

<div class="w-full max-w-md px-4">
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-bold text-2xl" style="color:#4A4A8A;">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3a1 1 0 110 2 1 1 0 010-2zm3 11H9v-2h6v2zm0-4H9v-2h6v2z"/>
            </svg>
            Blog Simple
        </a>
        <p class="mt-2 text-gray-500 text-sm">Créez votre compte gratuitement</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1.5" style="color:#1A1A2E;">Nom complet</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}"
                       placeholder="Jean Dupont">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1.5" style="color:#1A1A2E;">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }}"
                       placeholder="vous@exemple.fr">
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1.5" style="color:#1A1A2E;">Mot de passe</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent"
                       placeholder="Minimum 8 caractères">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1.5" style="color:#1A1A2E;">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6C63FF] focus:border-transparent"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all hover:opacity-90 active:scale-95" style="background:#4A4A8A;">
                Créer mon compte
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color:#6C63FF;">Se connecter</a>
        </p>
    </div>
</div>

</body>
</html>
