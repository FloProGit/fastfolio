<?php

namespace Tests\Unit;

use App\Domain\Shared\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class HasTranslationsTest extends TestCase
{
    private function makeModel(array $attributes): Model
    {
        return new class($attributes) extends Model
        {
            use HasTranslations;

            protected $guarded = [];

            protected function casts(): array
            {
                return [
                    'name' => 'array',
                ];
            }
        };
    }

    public function test_returns_translation_for_given_locale(): void
    {
        $model = $this->makeModel(['name' => ['fr' => 'Bonjour', 'en' => 'Hello']]);

        $this->assertEquals('Hello', $model->getTranslation('name', 'en'));
        $this->assertEquals('Bonjour', $model->getTranslation('name', 'fr'));
    }

    public function test_falls_back_to_default_locale(): void
    {
        $model = $this->makeModel(['name' => ['fr' => 'Bonjour']]);

        app()->setLocale('en');
        config(['app.fallback_locale' => 'fr']);

        $this->assertEquals('Bonjour', $model->getTranslation('name', 'en'));
    }

    public function test_returns_null_when_no_translation_exists(): void
    {
        $model = $this->makeModel(['name' => []]);

        $this->assertNull($model->getTranslation('name', 'de'));
    }

    public function test_uses_current_locale_when_none_specified(): void
    {
        $model = $this->makeModel(['name' => ['fr' => 'Bonjour', 'en' => 'Hello']]);

        app()->setLocale('fr');

        $this->assertEquals('Bonjour', $model->getTranslation('name'));
    }
}
