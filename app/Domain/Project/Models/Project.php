<?php

namespace App\Domain\Project\Models;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Shared\Traits\HasTranslations;
use App\Domain\Shared\Traits\HasUuid;
use App\Domain\Skill\Models\Skill;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property ProjectStatus $status
 * @property \Illuminate\Support\Carbon|null $completed_at
 */
class Project extends Model
{
    use HasFactory, HasTranslations ,HasUuid;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'excerpt',
        'description',
        'url',
        'repository_url',
        'status',
        'featured',
        'sort_order',
        'completed_at',
    ];

    protected static function newFactory()
    {
        return ProjectFactory::new();
    }

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'slug' => 'array',
            'description' => 'array',
            'excerpt' => 'array',
            'status' => ProjectStatus::class,
            'featured' => 'boolean',
            'sort_order' => 'integer',
            'completed_at' => 'date',
        ];
    }

    // Relations

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'project_skill');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->ordered();
    }

    // Scopes

    public function scopePublished($query)
    {
        return $query->where('status', ProjectStatus::Published);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
