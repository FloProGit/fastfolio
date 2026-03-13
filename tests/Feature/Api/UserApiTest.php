<?php

namespace Tests\Feature\Api;




use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_uuid_is_generated_on_creation(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->uuid);
        $this->assertTrue(str_starts_with($user->uuid, '0'));  // UUID v7 commence par 0
    }

    public function test_uuid_is_not_overwritten_on_update(): void
    {
        $user = User::factory()->create();
        $originalUuid = $user->uuid;

        $user->update(['name' => 'Updated']);

        $this->assertEquals($originalUuid, $user->fresh()->uuid);
    }
}
