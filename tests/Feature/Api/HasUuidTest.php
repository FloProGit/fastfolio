<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasUuidTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_uuid_is_generated_on_creation(): void
    {
        $this->assertNotNull($this->user->uuid);
        $this->assertTrue(str_starts_with($this->user->uuid, '0'));  // UUID v7 commence par 0
    }

    public function test_uuid_is_not_overwritten_on_update(): void
    {
        $originalUuid = $this->user->uuid;

        $this->user->update(['name' => 'Updated']);

        $this->assertEquals($originalUuid, $this->user->fresh()->uuid);
    }
}
