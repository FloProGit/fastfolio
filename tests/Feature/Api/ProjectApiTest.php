<?php

namespace Tests\Feature\Api;

use App\Domain\Project\Models\Project;
use App\Domain\Skill\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_only_published_projects(): void
    {
        Project::factory()->published()->create([
            'title' => ['fr' => 'Projet public', 'en' => 'Public project'],
        ]);
        Project::factory()->create([
            'title' => ['fr' => 'Brouillon', 'en' => 'Draft'],
        ]);

        $response = $this->getJson('/api/projects', ['Accept-Language' => 'fr'])->assertStatus(200);

        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Projet public', $response->json('data.0.title'));
    }

    public function test_api_returns_projects_ordered(): void
    {
        Project::factory()->published()->create([
            'title' => ['fr' => 'Deuxième', 'en' => 'Second'],
            'sort_order' => 2,
        ]);
        Project::factory()->published()->create([
            'title' => ['fr' => 'Premier', 'en' => 'First'],
            'sort_order' => 1,
        ]);

        $response = $this->getJson('/api/projects', ['Accept-Language' => 'fr'])->assertStatus(200);

        $titles = collect($response->json('data'))->pluck('title')->toArray();
        $this->assertEquals(['Premier', 'Deuxième'], $titles);
    }

    public function test_api_returns_project_detail(): void
    {
        $project = Project::factory()->published()->create([
            'title' => ['fr' => 'Mon projet', 'en' => 'My project'],
            'description' => ['fr' => 'Description FR', 'en' => 'Description EN'],
        ]);

        $this->getJson('/api/projects/'.$project->uuid, ['Accept-Language' => 'fr'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Mon projet',
                'description' => 'Description FR',
            ]);
    }

    public function test_api_returns_project_with_skills(): void
    {
        $project = Project::factory()->published()->create();
        $skill = Skill::factory()->create([
            'name' => ['fr' => 'Laravel', 'en' => 'Laravel'],
        ]);
        $project->skills()->attach($skill);

        $response = $this->getJson('/api/projects/'.$project->uuid)
            ->assertStatus(200);

        $this->assertEquals('Laravel', $response->json('data.skills.0.name'));
    }

    public function test_api_does_not_expose_internal_id(): void
    {
        Project::factory()->published()->create();

        $response = $this->getJson('/api/projects')->assertStatus(200);

        $firstProject = $response->json('data.0');
        $this->assertArrayHasKey('uuid', $firstProject);
        $this->assertArrayNotHasKey('id', $firstProject);
    }

    public function test_api_returns_project_in_french(): void
    {
        Project::factory()->published()->create([
            'title' => ['fr' => 'Mon projet', 'en' => 'My project'],
        ]);

        $this->getJson('/api/projects', ['Accept-Language' => 'fr'])
            ->assertStatus(200)
            ->assertJsonFragment(['title' => 'Mon projet']);
    }

    public function test_api_returns_project_in_english(): void
    {
        Project::factory()->published()->create([
            'title' => ['fr' => 'Mon projet', 'en' => 'My project'],
        ]);

        $this->getJson('/api/projects', ['Accept-Language' => 'en'])
            ->assertStatus(200)
            ->assertJsonFragment(['title' => 'My project']);
    }

    public function test_api_returns_404_for_unknown_project(): void
    {
        $this->getJson('/api/projects/fake-uuid')
            ->assertStatus(404);
    }
}
