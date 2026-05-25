<?php

namespace Tests\Feature;

use App\Models\MosqueMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MosqueMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_message(): void
    {
        $response = $this->post('/pesan/contact', [
            'name' => 'Ahmad',
            'email' => 'ahmad@example.com',
            'phone' => '081234567890',
            'subject' => 'Info kegiatan',
            'message' => 'Saya ingin bertanya tentang jadwal kajian pekanan.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('mosque_messages', [
            'type' => 'contact',
            'email' => 'ahmad@example.com',
            'subject' => 'Info kegiatan',
        ]);
    }

    public function test_same_sender_must_wait_before_sending_again(): void
    {
        $payload = [
            'name' => 'Ahmad',
            'email' => 'ahmad@example.com',
            'phone' => '081234567890',
            'subject' => 'Info kegiatan',
            'message' => 'Saya ingin bertanya tentang jadwal kajian pekanan.',
        ];

        $this->post('/pesan/contact', $payload)->assertRedirect();
        $this->from('/')->post('/pesan/contact', $payload)->assertRedirect('/');

        $this->assertSame(1, MosqueMessage::count());
    }
}
