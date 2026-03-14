<?php

namespace Database\Factories;

use App\Domain\Project\Enums\ProjectStatus;
use App\Domain\Project\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $titleFr = fake()->unique()->sentence(3, true);
        $titleEn = fake()->unique()->sentence(3, true);

        return [
            'title' => ['fr' => $titleFr, 'en' => $titleEn],
            'slug' => ['fr' => Str::slug($titleFr), 'en' => Str::slug($titleEn)],
            'excerpt' => ['fr' => fake()->paragraph(), 'en' => fake()->paragraph()],
            'description' => ['fr' => fake()->paragraphs(3, true), 'en' => fake()->paragraphs(3, true)],
            'url' => fake()->optional()->url(),
            'repository_url' => fake()->optional()->url(),
            'status' => ProjectStatus::Draft,
            'featured' => false,
            'sort_order' => 0,
            'completed_at' => fake()->optional()->date(),
        ];
    }

    public function published(): static
    {
        return $this->state([
            'status' => ProjectStatus::Published,
        ]);
    }

    public function featured(): static
    {
        return $this->state([
            'featured' => true,
        ]);
    }
}
