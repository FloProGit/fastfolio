<?php

namespace Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthWebTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public static function localeProvider(): array
    {
        return [
            'english' => ['en'],
            'french' => ['fr'],
        ];
    }

    #[DataProvider('localeProvider')]
    public function test_login_page_is_accessible(string $locale)
    {
        $response = $this->get("/{$locale}/admin/login");
        $response->assertStatus(200);
    }

    #[DataProvider('localeProvider')]
    public function test_redirect_when_login(string $locale)
    {

        $response = $this->actingAs($this->user)->get("/{$locale}/admin/login");

        $response->assertRedirect("/{$locale}/admin/dashboard");

    }
}
