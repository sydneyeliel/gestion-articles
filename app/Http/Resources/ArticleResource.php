<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'titre'       => $this->titre,
            'description' => $this->description,
            'image'       => $this->image,
            'cree_le'     => $this->created_at->format('d/m/Y H:i'),
            'modifie_le'  => $this->updated_at->format('d/m/Y H:i'),
        ];
    }
}