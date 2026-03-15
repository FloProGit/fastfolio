<?php

namespace Tests\Feature\Admin;

use App\Domain\Contact\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ContactCrudTest extends TestCase
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
    public function test_guest_cannot_access_contacts_index(string $locale): void
    {
        URL::defaults(['locale' => $locale]);

        $this->get("/{$locale}/admin/contacts")
            ->assertRedirect();
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_contacts_index(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        ContactMessage::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour',
        ]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/contacts")
            ->assertStatus(200)
            ->assertSee('Jean Dupont');
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_see_message_detail(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $message = ContactMessage::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, ceci est un test.',
        ]);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/contacts/{$message->uuid}")
            ->assertStatus(200)
            ->assertSee('Bonjour, ceci est un test.');
    }

    #[DataProvider('localeProvider')]
    public function test_viewing_message_marks_it_as_read(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $message = ContactMessage::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'message' => 'Test',
            'is_read' => false,
        ]);

        $this->assertFalse($message->is_read);

        $this->actingAs($this->admin)
            ->get("/{$locale}/admin/contacts/{$message->uuid}");

        $message->refresh();
        $this->assertTrue($message->is_read);
        $this->assertNotNull($message->read_at);
    }

    #[DataProvider('localeProvider')]
    public function test_admin_can_delete_message(string $locale): void
    {
        URL::defaults(['locale' => $locale]);
        $message = ContactMessage::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'message' => 'Test',
            'is_read' => false,
        ]);

        $this->actingAs($this->admin)
            ->delete("/{$locale}/admin/contacts/{$message->uuid}")
            ->assertRedirect("/{$locale}/admin/contacts");

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
