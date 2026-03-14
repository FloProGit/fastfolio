<?php

namespace Database\Factories;

use App\Domain\Skill\Enums\SkillCategory;
use App\Domain\Skill\Enums\SkillLevel;
use App\Domain\Skill\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {

        $word = fake()->unique()->word();
        return [
            'name'       => ['fr' => $word, 'en' => $word],
            'category'   => fake()->randomElement(SkillCategory::cases()),
            'level'      => fake()->randomElement(SkillLevel::cases()),
            'icon'       => null,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
