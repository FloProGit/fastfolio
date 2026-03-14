<?php

namespace Tests\Feature\Admin;

use App\Domain\Skill\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_guest_cannot_access_skills_index(): void
    {
        $this->get('/fr/admin/skills')
            ->assertRedirect();
    }

    public function test_admin_can_see_skills_index(): void
    {
        Skill::factory()->create(['name' => 'Laravel']);

        $this->actingAs($this->admin)
            ->get('/fr/admin/skills')
            ->assertStatus(200)
            ->assertSee('Laravel');
    }

    public function test_admin_can_see_create_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/fr/admin/skills/create')
            ->assertStatus(200)
            ->assertSee('Ajouter une compétence');
    }

    public function test_admin_can_create_skill(): void
    {
        $this->actingAs($this->admin)
            ->post('/fr/admin/skills', [
                'name' => 'Vue.js',
                'category' => 'frontend',
                'level' => 'advanced',
                'icon' => 'devicon-vuejs-plain',
                'sort_order' => 1,
            ])
            ->assertRedirect('/fr/admin/skills');

        $this->assertDatabaseHas('skills', [
            'name' => 'Vue.js',
            'category' => 'frontend',
            'level' => 'advanced',
        ]);
    }

    public function test_create_skill_validates_required_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/fr/admin/skills', [])
            ->assertSessionHasErrors(['name', 'category', 'level']);
    }

    public function test_create_skill_validates_enum_values(): void
    {
        $this->actingAs($this->admin)
            ->post('/fr/admin/skills', [
                'name' => 'Test',
                'category' => 'invalid',
                'level' => 'invalid',
            ])
            ->assertSessionHasErrors(['category', 'level']);
    }

    public function test_admin_can_update_skill(): void
    {
        $skill = Skill::factory()->create(['name' => 'Old Name']);

        $this->actingAs($this->admin)
            ->put('/fr/admin/skills/'.$skill->uuid, [
                'name' => 'New Name',
                'category' => 'backend',
                'level' => 'expert',
                'sort_order' => 5,
            ])
            ->assertRedirect('/fr/admin/skills');

        $this->assertEquals('New Name', $skill->fresh()->name);
    }

    public function test_admin_can_delete_skill(): void
    {
        $skill = Skill::factory()->create();

        $this->actingAs($this->admin)
            ->delete('/fr/admin/skills/'.$skill->uuid)
            ->assertRedirect('/fr/admin/skills');

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_uuid_is_generated_on_skill_creation(): void
    {
        $skill = Skill::factory()->create();

        $this->assertNotNull($skill->uuid);
    }
}
