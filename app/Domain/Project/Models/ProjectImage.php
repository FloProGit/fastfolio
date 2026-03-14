<?php

namespace App\Domain\Project\Models;

use App\Domain\Shared\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use HasTranslations;

    protected $fillable = [
        'project_id',
        'path',
        'variants',
        'alt',
        'sort_order',
        'is_main',
    ];

    protected function casts(): array
    {
        return [
            'variants' => 'array',
            'alt' => 'array',
            'is_main' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Relations

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Scopes

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }
}
