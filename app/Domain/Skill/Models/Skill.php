<?php

namespace App\Domain\Skill\Models;

use App\Domain\Project\Models\Project;
use App\Domain\Shared\Traits\HasTranslations;
use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Skill\Enums\SkillCategory;
use App\Domain\Skill\Enums\SkillLevel;
use Database\Factories\SkillFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $uuid
 * @property string $name
 * @property SkillCategory $category
 * @property SkillLevel $level
 * @property string|null $icon
 * @property int $sort_order
 */
class Skill extends Model
{
    use HasFactory, HasTranslations ,HasUuid;

    protected $fillable = [
        'name',
        'category',
        'level',
        'icon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'category' => SkillCategory::class,
            'level' => SkillLevel::class,
            'sort_order' => 'integer',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByCategory($query, SkillCategory $category)
    {
        return $query->where('category', $category);
    }

    protected static function newFactory()
    {
        return SkillFactory::new();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_skill');
    }
}
