<?php

namespace Tests\Feature\Api;

use App\Domain\Profile\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_profile(): void
    {
        Profile::create([
            'title' => ['fr' => 'Développeur Full Stack', 'en' => 'Full Stack Developer'],
            'bio' => ['fr' => '<p>Ma bio FR</p>', 'en' => '<p>My bio EN</p>'],
            'email' => 'contact@example.com',
            'location' => ['fr' => 'Nîmes, France', 'en' => 'Nîmes, France'],
            'socials' => ['github' => 'https://github.com/test'],
        ]);

        $this->getJson('/api/profile', ['Accept-Language' => 'fr'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Développeur Full Stack',
                'email' => 'contact@example.com',
                'location' => 'Nîmes, France',
            ]);
    }

    public function test_api_returns_profile_in_english(): void
    {
        Profile::create([
            'title' => ['fr' => 'Développeur Full Stack', 'en' => 'Full Stack Developer'],
            'bio' => ['fr' => '<p>Ma bio FR</p>', 'en' => '<p>My bio EN</p>'],
            'email' => 'contact@example.com',
        ]);

        $this->getJson('/api/profile', ['Accept-Language' => 'en'])
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Full Stack Developer',
            ]);
    }

    public function test_api_does_not_expose_internal_id(): void
    {
        Profile::create([
            'title' => ['fr' => 'Test', 'en' => 'Test'],
            'bio' => ['fr' => '', 'en' => ''],
            'email' => 'test@example.com',
        ]);

        $response = $this->getJson('/api/profile')->assertStatus(200);

        $this->assertArrayHasKey('uuid', $response->json('data'));
        $this->assertArrayNotHasKey('id', $response->json('data'));
    }
}
