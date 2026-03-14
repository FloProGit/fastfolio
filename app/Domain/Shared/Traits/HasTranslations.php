<?php

namespace App\Domain\Shared\Traits;

trait HasTranslations
{
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        return $this->{$field}[$locale] ?? $this->{$field}[$this->getFallbackLocale()] ?? null;
    }

    protected function getFallbackLocale(): string
    {
        return config('app.fallback_locale', 'fr');
    }
}
