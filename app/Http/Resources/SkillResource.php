<?php

namespace App\Http\Resources;

use App\Domain\Skill\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Skill */
class SkillResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'category' => $this->category->value,
            'level' => $this->level->value,
            'icon' => $this->icon,
            'sort_order' => $this->sort_order,
        ];
    }
}
