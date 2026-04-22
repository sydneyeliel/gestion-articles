<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

    // ── API REST ──────────────────────────────────────────────

    public function index(): AnonymousResourceCollection
    {
        $articles = $this->articleService->getAll();
        return ArticleResource::collection($articles);
    }

    public function store(StoreArticleRequest $request): JsonResponse
    {
        $article = $this->articleService->create($request->validated());
        return (new ArticleResource($article))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): ArticleResource
    {
        $article = $this->articleService->getById($id);
        return new ArticleResource($article);
    }

    public function update(UpdateArticleRequest $request, int $id): ArticleResource
    {
        $article = $this->articleService->getById($id);
        $updated = $this->articleService->update($article, $request->validated());
        return new ArticleResource($updated);
    }

    public function destroy(int $id): JsonResponse
    {
        $article = $this->articleService->getById($id);
        $this->articleService->delete($article);
        return response()->json([
            'message' => 'Article supprimé avec succès.',
        ]);
    }

    // ── Méthodes Web (Blade) ──────────────────────────────────

    public function indexWeb()
    {
        $articles = $this->articleService->getAll();
        return view('articles.index', compact('articles'));
    }

    public function createWeb()
    {
        return view('articles.create');
    }

    public function storeWeb(Request $request)
    {
        $request->validate([
            'titre'       => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'image'       => ['nullable', 'url', 'max:500'],
        ]);
        $this->articleService->create($request->only('titre', 'description', 'image'));
        return redirect()->route('articles.index')->with('success', 'Article créé avec succès !');
    }

    public function editWeb(int $id)
    {
        $article = $this->articleService->getById($id);
        return view('articles.edit', compact('article'));
    }

    public function updateWeb(Request $request, int $id)
    {
        $request->validate([
            'titre'       => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'image'       => ['nullable', 'url', 'max:500'],
        ]);
        $article = $this->articleService->getById($id);
        $this->articleService->update($article, $request->only('titre', 'description', 'image'));
        return redirect()->route('articles.index')->with('success', 'Article modifié avec succès !');
    }

    public function destroyWeb(int $id)
    {
        $article = $this->articleService->getById($id);
        $this->articleService->delete($article);
        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès !');
    }
}
