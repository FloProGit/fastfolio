<?php

namespace Tests\Feature\Admin;

use App\Domain\Profile\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProfileCrudTest extends TestCase
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
    public function test_guest_cannot_access_profile_edit(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->get("/{$locale}/admin/profile")
            ->assertRedirect();
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_profile_edit(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/profile")
            ->assertStatus(200);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_update_profile(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/profile", [
                'title' => ['fr' => 'Dev Full Stack', 'en' => 'Full Stack Dev'],
                'bio' => ['fr' => '<p>Bio FR</p>', 'en' => '<p>Bio EN</p>'],
                'email' => 'contact@example.com',
                'location' => ['fr' => 'Nîmes, France', 'en' => 'Nîmes, France'],
                'socials' => ['github' => 'https://github.com/test'],
            ])
            ->assertRedirect("/{$locale}/admin/profile");

        $profile = Profile::first();
        $this->assertEquals('Dev Full Stack', $profile->title['fr']);
        $this->assertEquals('Full Stack Dev', $profile->title['en']);
        $this->assertEquals('contact@example.com', $profile->email);
    }

    #[DataProvider('localeProvider')]
    public function test_update_validates_required_fields(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/profile", [])
            ->assertSessionHasErrors(['title', 'bio', 'email']);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_upload_avatar(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        Storage::fake('public');

        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/profile", [
                'title' => ['fr' => 'Test', 'en' => 'Test'],
                'bio' => ['fr' => 'Bio', 'en' => 'Bio'],
                'email' => 'test@example.com',
                'avatar' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
            ])
            ->assertRedirect("/{$locale}/admin/profile");

        $profile = Profile::first();
        $this->assertNotNull($profile->avatar);
        Storage::disk('public')->assertExists($profile->avatar);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_replace_avatar(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        Storage::fake('public');

        // Premier upload
        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/profile", [
                'title' => ['fr' => 'Test', 'en' => 'Test'],
                'bio' => ['fr' => 'Bio', 'en' => 'Bio'],
                'email' => 'test@example.com',
                'avatar' => UploadedFile::fake()->image('old.jpg'),
            ]);

        $oldPath = Profile::first()->avatar;

        // Deuxième upload
        $this->actingAs($this->admin)
            ->put("/{$locale}/admin/profile", [
                'title' => ['fr' => 'Test', 'en' => 'Test'],
                'bio' => ['fr' => 'Bio', 'en' => 'Bio'],
                'email' => 'test@example.com',
                'avatar' => UploadedFile::fake()->image('new.jpg'),
            ]);

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists(Profile::first()->avatar);
    }
}
