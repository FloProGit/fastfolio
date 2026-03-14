<?php

namespace App\Http\Resources;

use App\Domain\Project\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ProjectImage */
class ProjectImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'path' => $this->path,
            'variants' => $this->variants,
            'alt' => $this->getTranslation('alt'),
            'sort_order' => $this->sort_order,
            'is_main' => $this->is_main,
        ];
    }
}
