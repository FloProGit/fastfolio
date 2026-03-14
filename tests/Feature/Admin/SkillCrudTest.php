<?php

// tests/Feature/Admin/SkillCrudTest.php

namespace Tests\Feature\Admin;

use App\Domain\Skill\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SkillCrudTest extends TestCase
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
    public function test_guest_cannot_access_skills_index(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->get("/{$locale}/admin/skills")
            ->assertRedirect();
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_skills_index(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        Skill::factory()->create(['name' => ['fr' => 'Laravel', 'en' => 'Laravel']]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/skills")
            ->assertStatus(200)
            ->assertSee('Laravel');
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_create_form(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/skills/create")
            ->assertStatus(200);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_create_skill(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/skills", [
                'name' => ['fr' => 'Gestion de projet', 'en' => 'Project Management'],
                'category' => 'frontend',
                'level' => 'advanced',
                'icon' => 'devicon-vuejs-plain',
                'sort_order' => 1,
            ])
            ->assertRedirect("/{$locale}/admin/skills");

        $this->assertDatabaseHas('skills', [
            'category' => 'frontend',
            'level' => 'advanced',
        ]);
    }

    #[DataProvider('localeProvider')]
    public function test_create_skill_validates_required_fields(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/skills", [])
            ->assertSessionHasErrors(['name.fr', 'name.en', 'category', 'level']);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_update_skill(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $skill = Skill::factory()->create();

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/skills/{$skill->uuid}", [
                'name' => ['fr' => 'Nouveau nom', 'en' => 'New Name'],
                'category' => 'backend',
                'level' => 'expert',
                'sort_order' => 5,
            ])
            ->assertRedirect("/{$locale}/admin/skills");

        $skill->refresh();
        $this->assertEquals('Nouveau nom', $skill->name['fr']);
        $this->assertEquals('New Name', $skill->name['en']);
    }

    #[DataProvider('localeProvider')]
    public function test_create_skill_validates_enum_values(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->post("/{$locale}/admin/skills", [
                'name' => 'Test',
                'category' => 'invalid',
                'level' => 'invalid',
            ])
            ->assertSessionHasErrors(['category', 'level']);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_delete_skill(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $skill = Skill::factory()->create();

        $this->actingAs($this->admin)
            ->delete("/{$locale}/admin/skills/{$skill->uuid}")
            ->assertRedirect("/{$locale}/admin/skills");

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_uuid_is_generated_on_skill_creation(): void
    {
        $skill = Skill::factory()->create();

        $this->assertNotNull($skill->uuid);
    }
}
