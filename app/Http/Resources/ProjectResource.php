<?php

namespace App\Http\Resources;

use App\Domain\Project\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Project */
class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->getTranslation('title'),
            'slug' => $this->getTranslation('slug'),
            'excerpt' => $this->getTranslation('excerpt'),
            'description' => $this->getTranslation('description'),
            'url' => $this->url,
            'repository_url' => $this->repository_url,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'featured' => $this->featured,
            'sort_order' => $this->sort_order,
            'completed_at' => $this->completed_at?->toDateString(),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'images' => ProjectImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
