<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@blog.fr',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $user = User::create([
            'name'     => 'Marie Dupont',
            'email'    => 'marie@blog.fr',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $cats = collect(['Technologie', 'Design', 'Développement', 'Actualité', 'Tutoriel'])
            ->map(fn($name) => Category::create(['name' => $name, 'slug' => Str::slug($name)]));

        $titles = [
            'Maîtriser Laravel 11 en 2025',
            'Tailwind CSS v4 — Guide complet',
            'Construire une API REST avec Laravel',
            'Design éditorial pour un blog moderne',
            'Les migrations Laravel expliquées',
        ];

        $bodies = [
            "Laravel est un framework PHP moderne qui rend le développement web agréable.\n\nIl offre une syntaxe élégante, une ORM puissante (Eloquent), un système de migration, des queues, des événements et bien plus encore.\n\nGrâce à son écosystème riche — Breeze, Sanctum, Horizon, Telescope — il est possible de construire des applications robustes très rapidement.",
            "Tailwind CSS est une approche utility-first qui permet de construire des interfaces sans quitter son fichier HTML.\n\nAu lieu d'écrire du CSS personnalisé, vous combinez des classes utilitaires directement dans vos templates. Cette approche favorise la cohérence et accélère le développement.",
            "Les APIs REST sont aujourd'hui la norme pour exposer des données. En Laravel, il suffit de créer des routes dans api.php, des contrôleurs dédiés et des API Resources pour formater les réponses JSON.\n\nSanctum permet d'ajouter une authentification stateless via tokens.",
            "Le design éditorial se caractérise par une typographie soignée, des espaces blancs généreux et une hiérarchie visuelle claire.\n\nInter est une police sans-serif conçue spécifiquement pour les écrans, très lisible à toutes les tailles.",
            "Les migrations Laravel permettent de versionner votre schéma de base de données. Chaque migration est un fichier PHP qui décrit les changements à appliquer.\n\nLa commande php artisan migrate applique les migrations en attente, et migrate:rollback permet d'annuler.",
        ];

        foreach (range(0, 4) as $i) {
            $post = Post::create([
                'title'        => $titles[$i],
                'slug'         => Str::slug($titles[$i]) . '-' . ($i + 1),
                'body'         => $bodies[$i],
                'image'        => null,
                'user_id'      => $admin->id,
                'category_id'  => $cats[$i]->id,
                'published_at' => now()->subDays($i * 3),
            ]);

            Comment::create([
                'body'    => 'Excellent article, très bien expliqué ! Je recommande à tous les développeurs.',
                'user_id' => $user->id,
                'post_id' => $post->id,
                'status'  => 'approved',
            ]);

            if ($i < 3) {
                Comment::create([
                    'body'    => 'Merci pour ce contenu de qualité. Avez-vous prévu un article sur les tests unitaires ?',
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'status'  => 'pending',
                ]);
            }
        }

        foreach (range(6, 12) as $i) {
            Post::create([
                'title'        => "Article de découverte numéro $i",
                'slug'         => "article-decouverte-$i",
                'body'         => "Contenu de l'article $i. " . str_repeat('Lorem ipsum dolor sit amet, consectetur adipiscing elit. ', 8),
                'image'        => null,
                'user_id'      => $user->id,
                'category_id'  => $cats->random()->id,
                'published_at' => now()->subDays($i),
            ]);
        }
    }
}
