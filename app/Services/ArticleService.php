<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public function getAll(): Collection
    {
        return Article::latest()->get();
    }

    public function getById(int $id): Article
    {
        return Article::findOrFail($id);
    }

    public function create(array $data): Article
    {
        return Article::create($data);
    }

    public function update(Article $article, array $data): Article
    {
        $article->update($data);
        return $article->fresh();
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}