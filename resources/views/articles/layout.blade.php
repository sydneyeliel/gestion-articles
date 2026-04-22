<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Articles</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; color: #333; }
        nav { background: #1E3A5F; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        nav h1 { color: white; font-size: 1.2rem; }
        nav a { color: #90CAF9; text-decoration: none; font-size: 0.9rem; }
        nav a:hover { color: white; }
        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.9rem; text-decoration: none; display: inline-block; }
        .btn-primary { background: #1E3A5F; color: white; }
        .btn-primary:hover { background: #16304f; }
        .btn-warning { background: #F59E0B; color: white; }
        .btn-warning:hover { background: #D97706; }
        .btn-danger { background: #EF4444; color: white; }
        .btn-danger:hover { background: #DC2626; }
        .btn-secondary { background: #6B7280; color: white; }
        .btn-secondary:hover { background: #4B5563; }
        .alert-success { background: #D1FAE5; color: #065F46; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; border: 1px solid #6EE7B7; }
        .alert-error { background: #FEE2E2; color: #991B1B; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; border: 1px solid #FCA5A5; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.85rem; color: #555; margin-bottom: 4px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; font-family: Arial, sans-serif; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #1E3A5F; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .error-msg { font-size: 0.8rem; color: #EF4444; margin-top: 3px; }
        .card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <nav>
        <h1>📰 Gestion des Articles</h1>
        <a href="/articles">← Retour à la liste</a>
    </nav>
    <div class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>

