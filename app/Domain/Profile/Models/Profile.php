<?php

namespace App\Domain\Profile\Models;

use App\Domain\Shared\Traits\HasTranslations;
use App\Domain\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array $title
 * @property array $bio
 * @property array $resume_url
 * @property array $location
 * @property array $socials
 * @property array $seo_title
 * @property array $seo_desc
 */
class Profile extends Model
{
    use HasTranslations, HasUuid;

    protected $fillable = [
        'uuid',
        'title',
        'bio',
        'avatar',
        'resume_url',
        'location',
        'email',
        'socials',
        'seo_title',
        'seo_desc',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'bio' => 'array',
            'resume_url' => 'array',
            'location' => 'array',
            'socials' => 'array',
            'seo_title' => 'array',
            'seo_desc' => 'array',
        ];
    }

    // Singleton helper
    public static function singleton(): self
    {
        return static::firstOrCreate([], [
            'title' => ['fr' => '', 'en' => ''],
            'bio' => ['fr' => '', 'en' => ''],
            'email' => '',
        ]);
    }
}
