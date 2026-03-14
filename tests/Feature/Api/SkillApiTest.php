<?php

namespace Tests\Feature\Api;

use App\Domain\Skill\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_skills(): void
    {
        Skill::factory()->create([
            'name'     => 'Laravel',
            'category' => 'backend',
            'level'    => 'expert',
        ]);

        $this->getJson('/api/skills')
            ->assertStatus(200)
            ->assertJsonFragment([
                'name'           => 'Laravel',
                'category'       => 'backend',
                'category_label' => 'Back-end',
                'level'          => 'expert',
                'level_label'    => 'Expert',
            ]);
    }

    public function test_api_returns_skills_ordered(): void
    {
        Skill::factory()->create(['name' => 'Vue.js', 'sort_order' => 2]);
        Skill::factory()->create(['name' => 'Laravel', 'sort_order' => 1]);

        $response = $this->getJson('/api/skills')->assertStatus(200);

        $names = collect($response->json('data'))->pluck('name')->toArray();
        $this->assertEquals(['Laravel', 'Vue.js'], $names);
    }

    public function test_api_does_not_expose_internal_id(): void
    {
        Skill::factory()->create();

        $response = $this->getJson('/api/skills')->assertStatus(200);

        $firstSkill = $response->json('data.0');
        $this->assertArrayHasKey('uuid', $firstSkill);
        $this->assertArrayNotHasKey('id', $firstSkill);
    }


    public function test_api_returns_skills_in_french(): void
    {
        Skill::factory()->create([
            'name'     => ['fr' => 'Gestion de projet', 'en' => 'Project Management'],
            'category' => 'backend',
            'level'    => 'expert',
        ]);

        $this->getJson('/api/skills',['Accept-Language' => 'fr'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'name'           => 'Gestion de projet',
                'category'       => 'backend',
                'category_label' => 'Back-end',
                'level'          => 'expert',
                'level_label'    => 'Expert',
            ]);
    }

    public function test_api_returns_skills_in_english(): void
    {
        Skill::factory()->create([
            'name'     => ['fr' => 'Gestion de projet', 'en' => 'Project Management'],
            'category' => 'backend',
            'level'    => 'expert',
        ]);

        $this->getJson('/api/skills', ['Accept-Language' => 'en'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'name'           => 'Project Management',
                'category_label' => 'Back-end',
                'level_label'    => 'Expert',
            ]);
    }

}
