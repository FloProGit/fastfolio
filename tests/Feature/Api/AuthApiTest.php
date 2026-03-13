<?php


namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;


    public function test_login_returns_token()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login',[
            'email'=> $user->email,
            'password'=> 'password',
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure(['token']);
    }

    public function test_login_fails_with_invalid_password(){
        $user = User::factory()->create();


        $response = $this->postJson('/api/login',[
            'email'=>$user->email,
            'password'=>'wrong-password',
        ]);

        $response->assertStatus(422)
        ->assertJsonValidationErrors('email');
    }

    public function test_login_fails_with_invalid_email(){
        User::factory()->create();

        $response = $this->postJson('/api/login',[
            'email'=>'randommail@rand.fr',
            'password'=>'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }


    public function test_logout_deletes_token(){
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/logout');

        $response->assertStatus(200);

        $this->assertCount(0, $user->fresh()->tokens);
    }

    public function test_logout_fails_without_auth(){
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }


    public function test_return_route_protected_by_token(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJsonFragment(['email'=>$user->email]);
    }

    public function test_return_route_not_protected_by_token(){

        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }
}
