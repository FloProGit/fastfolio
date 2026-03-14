<?php

namespace App\Domain\Skill\Models;

use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Skill\Enums\SkillCategory;
use App\Domain\Skill\Enums\SkillLevel;
use Database\Factories\SkillFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    use HasFactory, HasUuid;

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

    public function getTranslation(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field};

        if (is_string($value)) {
            return $value;
        }

        return $value[$locale] ?? $value['fr'] ?? '';
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
}
