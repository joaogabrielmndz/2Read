<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    protected $relationships = [
        'pages'
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->page_url,
            'title' => $this->pivot->custom_title ?? $this->title,
            'content' => $this->content,
            'status' => $this->scrapping_status,

            'is_read' => (bool) ($this->pivot->is_read ?? false),
            'is_archived' => (bool) ($this->pivot->is_archived ?? false),

            'saved_at' => $this->pivot->created_at?->toIso8601String(),
        ];
    }
}
