<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tamu (guest) diarahkan ke halaman login saat membuka sistem.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/inventaris');

        $response->assertRedirect('/login');
    }

    /**
     * Pengguna yang telah terotentikasi dapat melihat halaman inventaris.
     */
    public function test_authenticated_user_can_view_inventaris(): void
    {
        $user = User::factory()->create([
            'role' => 'penyewa',
        ]);

        $response = $this->actingAs($user)->get('/inventaris');

        $response->assertStatus(200);
    }
}
