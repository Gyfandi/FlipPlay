<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'release_year' => $this->release_year,

            'anime_detail' => $this->whenLoaded('animeDetail'),
            'manga_detail' => $this->whenLoaded('mangaDetail'),
            'light_novel_detail' => $this->whenLoaded('lightNovelDetail'),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
