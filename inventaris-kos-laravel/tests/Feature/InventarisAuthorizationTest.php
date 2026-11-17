<?php

namespace Tests\Feature;

use App\Models\Inventaris;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventarisAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $staff;
    protected User $penyewa;
    protected Inventaris $asetContoh;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name'  => 'Admin Kos',
            'email' => 'admin@kos.com',
            'role'  => 'admin',
        ]);

        $this->staff = User::factory()->create([
            'name'  => 'Staff Kos',
            'email' => 'staff@kos.com',
            'role'  => 'staff',
        ]);

        $this->penyewa = User::factory()->create([
            'name'  => 'Penyewa Kos',
            'email' => 'penyewa@kos.com',
            'role'  => 'penyewa',
        ]);

        $this->asetContoh = Inventaris::create([
            'nama_aset'  => 'Kasur Busa Single',
            'kategori'   => 'Furniture',
            'merk'       => 'Inoac',
            'lokasi'     => 'Kamar 101',
            'kondisi'    => 'Baik',
            'keterangan' => 'Kondisi bagus dan bersih',
        ]);
    }

    /**
     * Halaman login dapat diakses dengan baik oleh tamu.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Inventaris Kos');
    }

    /**
     * Pengguna dapat login dengan email dan password yang valid.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email'    => 'admin@kos.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/inventaris');
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * Pengguna gagal login jika kredensial salah.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email'    => 'admin@kos.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pengguna dapat logout dan diarahkan ke login.
     */
    public function test_user_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Role Penyewa: Dapat melihat daftar aset.
     */
    public function test_penyewa_can_view_inventaris_list(): void
    {
        $response = $this->actingAs($this->penyewa)->get('/inventaris');

        $response->assertStatus(200);
        $response->assertSee('Kasur Busa Single');
        $response->assertSee('Hanya Lihat');
        $response->assertDontSee('+ Tambah Aset');
    }

    /**
     * Role Penyewa: Ditolak (403) saat mengakses form tambah aset.
     */
    public function test_penyewa_cannot_access_create_form(): void
    {
        $response = $this->actingAs($this->penyewa)->get('/inventaris/create');

        $response->assertStatus(403);
    }

    /**
     * Role Penyewa: Ditolak (403) saat menyimpan aset baru.
     */
    public function test_penyewa_cannot_store_inventaris(): void
    {
        $response = $this->actingAs($this->penyewa)->post('/inventaris', [
            'nama_aset' => 'Meja Belajar',
            'kategori'  => 'Furniture',
            'merk'      => 'IKEA',
            'lokasi'    => 'Kamar 102',
            'kondisi'   => 'Baik',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Role Penyewa: Ditolak (403) saat mengakses form edit aset.
     */
    public function test_penyewa_cannot_edit_inventaris(): void
    {
        $response = $this->actingAs($this->penyewa)->get("/inventaris/{$this->asetContoh->id}/edit");

        $response->assertStatus(403);
    }

    /**
     * Role Penyewa: Ditolak (403) saat menghapus aset.
     */
    public function test_penyewa_cannot_delete_inventaris(): void
    {
        $response = $this->actingAs($this->penyewa)->delete("/inventaris/{$this->asetContoh->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('inventaris', ['id' => $this->asetContoh->id]);
    }

    /**
     * Role Staff: Dapat membuka form tambah dan menyimpan aset baru.
     */
    public function test_staff_can_create_and_store_inventaris(): void
    {
        $responseForm = $this->actingAs($this->staff)->get('/inventaris/create');
        $responseForm->assertStatus(200);

        $responseStore = $this->actingAs($this->staff)->post('/inventaris', [
            'nama_aset'  => 'Dispenser Air Galon',
            'kategori'   => 'Elektronik',
            'merk'       => 'Miyako',
            'lokasi'     => 'Dapur Bersama',
            'kondisi'    => 'Baik',
            'keterangan' => 'Ditaruh di lantai 1',
        ]);

        $responseStore->assertRedirect('/inventaris');
        $this->assertDatabaseHas('inventaris', ['nama_aset' => 'Dispenser Air Galon']);
    }

    /**
     * Role Staff: Dapat mengedit dan memperbarui aset.
     */
    public function test_staff_can_edit_and_update_inventaris(): void
    {
        $responseEdit = $this->actingAs($this->staff)->get("/inventaris/{$this->asetContoh->id}/edit");
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->actingAs($this->staff)->put("/inventaris/{$this->asetContoh->id}", [
            'nama_aset'  => 'Kasur Busa Single Diperbarui',
            'kategori'   => 'Furniture',
            'merk'       => 'Inoac',
            'lokasi'     => 'Kamar 101',
            'kondisi'    => 'Rusak Ringan',
            'keterangan' => 'Perlu ganti sprei',
        ]);

        $responseUpdate->assertRedirect('/inventaris');
        $this->assertDatabaseHas('inventaris', ['nama_aset' => 'Kasur Busa Single Diperbarui']);
    }

    /**
     * Role Staff: Ditolak (403) saat mencoba menghapus data aset.
     */
    public function test_staff_cannot_delete_inventaris(): void
    {
        $response = $this->actingAs($this->staff)->delete("/inventaris/{$this->asetContoh->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('inventaris', ['id' => $this->asetContoh->id]);
    }

    /**
     * Role Admin: Dapat melakukan operasi hapus data aset.
     */
    public function test_admin_can_delete_inventaris(): void
    {
        $response = $this->actingAs($this->admin)->delete("/inventaris/{$this->asetContoh->id}");

        $response->assertRedirect('/inventaris');
        $this->assertDatabaseMissing('inventaris', ['id' => $this->asetContoh->id]);
    }
}
