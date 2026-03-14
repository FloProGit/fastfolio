<?php

namespace Tests\Feature\Admin;

use App\Domain\Project\Models\Project;
use App\Domain\Skill\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public static function localeProvider(): array
    {
        return [
            'english' => ['en'],
            'french' => ['fr'],
        ];
    }

    #[DataProvider('localeProvider')]
    public function test_guest_cannot_access_projects_index(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->get("/{$locale}/admin/projects")
            ->assertRedirect();
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_projects_index(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        Project::factory()->create([
            'title' => ['fr' => 'Mon projet', 'en' => 'My project'],
        ]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/projects")
            ->assertStatus(200)
            ->assertSee($locale === 'fr' ? 'Mon projet' : 'My project');
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_create_form(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/projects/create")
            ->assertStatus(200);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_create_project(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $skill = Skill::factory()->create();

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/projects", [
                'title' => ['fr' => 'Nouveau projet', 'en' => 'New project'],
                'slug' => ['fr' => 'nouveau-projet', 'en' => 'new-project'],
                'excerpt' => ['fr' => 'Extrait FR', 'en' => 'Excerpt EN'],
                'description' => ['fr' => 'Description FR', 'en' => 'Description EN'],
                'url' => 'https://example.com',
                'repository_url' => 'https://github.com/example',
                'status' => 'draft',
                'featured' => true,
                'sort_order' => 1,
                'completed_at' => '2025-01-15',
                'skill_ids' => [$skill->id],
            ])
            ->assertRedirect("/{$locale}/admin/projects");

        $this->assertDatabaseHas('projects', [
            'status' => 'draft',
            'featured' => true,
        ]);

        $project = Project::first();
        $this->assertTrue($project->skills->contains($skill));
    }

    #[DataProvider('localeProvider')]
    public function test_create_project_validates_required_fields(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/projects", [])
            ->assertSessionHasErrors(['title', 'slug', 'description', 'status']);
    }

    #[DataProvider('localeProvider')]
    public function test_create_project_validates_enum_values(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/projects", [
                'title' => ['fr' => 'Test', 'en' => 'Test'],
                'slug' => ['fr' => 'test', 'en' => 'test'],
                'description' => ['fr' => 'Desc', 'en' => 'Desc'],
                'status' => 'invalid',
            ])
            ->assertSessionHasErrors(['status']);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_update_project(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $project = Project::factory()->create();

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/projects/{$project->uuid}", [
                'title' => ['fr' => 'Titre modifié', 'en' => 'Updated title'],
                'slug' => ['fr' => 'titre-modifie', 'en' => 'updated-title'],
                'description' => ['fr' => 'Nouvelle desc', 'en' => 'New desc'],
                'status' => 'published',
                'featured' => false,
                'sort_order' => 3,
            ])
            ->assertRedirect("/{$locale}/admin/projects");

        $project->refresh();
        $this->assertEquals('Titre modifié', $project->title['fr']);
        $this->assertEquals('Updated title', $project->title['en']);
        $this->assertEquals('published', $project->status->value);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_update_project_skills(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $project = Project::factory()->create();
        $skill1 = Skill::factory()->create();
        $skill2 = Skill::factory()->create();
        $project->skills()->attach($skill1);

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/projects/{$project->uuid}", [
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'status' => $project->status->value,
                'skill_ids' => [$skill2->id],
            ])
            ->assertRedirect("/{$locale}/admin/projects");

        $project->refresh();
        $this->assertFalse($project->skills->contains($skill1));
        $this->assertTrue($project->skills->contains($skill2));
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_delete_project(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $project = Project::factory()->create();

        $this->actingAs($this->admin)
            ->delete("/{$locale}/admin/projects/{$project->uuid}")
            ->assertRedirect("/{$locale}/admin/projects");

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_uuid_is_generated_on_project_creation(): void
    {
        $project = Project::factory()->create();

        $this->assertNotNull($project->uuid);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_create_project_with_images(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        Storage::fake('public');

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/projects", [
                'title' => ['fr' => 'Projet avec images', 'en' => 'Project with images'],
                'slug' => ['fr' => 'projet-images', 'en' => 'project-images'],
                'description' => ['fr' => 'Desc FR', 'en' => 'Desc EN'],
                'status' => 'draft',
                'images' => [
                    [
                        'file' => UploadedFile::fake()->image('photo.jpg', 800, 600),
                        'alt_fr' => 'Photo du projet',
                        'alt_en' => 'Project photo',
                        'is_main' => true,
                    ],
                ],
            ])
            ->assertRedirect("/{$locale}/admin/projects");

        $project = Project::first();
        $this->assertCount(1, $project->images);
        $this->assertTrue($project->images->first()->is_main);
        $this->assertEquals('Photo du projet', $project->images->first()->alt['fr']);
        Storage::disk('public')->assertExists($project->images->first()->path);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_delete_project_images(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        Storage::fake('public');

        $project = Project::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg');
        $path = $file->store("projects/{$project->id}", 'public');

        $image = $project->images()->create([
            'path' => $path,
            'alt' => ['fr' => 'Test', 'en' => 'Test'],
            'sort_order' => 0,
            'is_main' => false,
        ]);

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/projects/{$project->uuid}", [
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'status' => $project->status->value,
                'delete_images' => [$image->id],
            ])
            ->assertRedirect("/{$locale}/admin/projects");

        $this->assertDatabaseMissing('project_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($path);
    }
}
