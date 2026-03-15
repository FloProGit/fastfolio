<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_send_contact_message(): void
    {
        $this->postJson('/api/contact', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'subject' => 'Demande de devis',
            'message' => 'Bonjour, je souhaite un devis pour un site web.',
        ])
            ->assertStatus(201)
            ->assertJsonFragment(['message' => 'Message envoyé.']);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'subject' => 'Demande de devis',
            'is_read' => false,
        ]);
    }

    public function test_contact_message_validates_required_fields(): void
    {
        $this->postJson('/api/contact', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }

    public function test_contact_message_validates_email_format(): void
    {
        $this->postJson('/api/contact', [
            'name' => 'Test',
            'email' => 'pas-un-email',
            'message' => 'Test',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_subject_is_optional(): void
    {
        $this->postJson('/api/contact', [
            'name' => 'Test',
            'email' => 'test@example.com',
            'message' => 'Message sans sujet.',
        ])
            ->assertStatus(201);

        $this->assertDatabaseHas('contact_messages', [
            'subject' => null,
        ]);
    }
}
