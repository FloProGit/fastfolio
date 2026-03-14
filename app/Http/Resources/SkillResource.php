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
            'uuid'           => $this->uuid,
            'name'           => $this->getTranslation('name'),
            'category'       => $this->category->value,
            'category_label' => $this->category->label(),
            'level'          => $this->level->value,
            'level_label'    => $this->level->label(),
            'icon'           => $this->icon,
            'sort_order'     => $this->sort_order,
        ];
    }
}
