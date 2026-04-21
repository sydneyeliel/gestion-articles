<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class ArticleController extends Controller
{
    public function __construct(
        private readonly ArticleService $articleService
    ) {}

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
}