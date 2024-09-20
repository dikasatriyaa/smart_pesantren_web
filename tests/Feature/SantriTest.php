<?php

// tests/Feature/SantriTest.php

namespace Tests\Feature;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SantriTest extends TestCase
{
    use RefreshDatabase;

    protected $guru;
    protected $waliSantri;
    protected $waliAsrama;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat pengguna uji dengan berbagai peran
        $this->guru = User::factory()->create(['role' => '1']); // Guru
        $this->waliSantri = User::factory()->create(['role' => '3']); // Wali Santri
        $this->waliAsrama = User::factory()->create(['role' => '0']); // Wali Asrama
        $this->admin = User::factory()->create(['role' => '2']); // Admin
    }

    /** @test */
    public function test_santri_index_page_for_admin()
    {
        $response = $this->actingAs($this->admin)->get('/santri');

        $response->assertStatus(200);
        $response->assertViewIs('santris.index');
    }

    /** @test */
    public function test_santri_index_page_for_guru()
    {
        $response = $this->actingAs($this->guru)->get('/santri');

        $response->assertStatus(200);
        $response->assertViewIs('santris.index');
    }

    /** @test */
    public function test_santri_index_page_for_wali_santri_is_invalid()
    {
        $response = $this->actingAs($this->waliSantri)->get('/santri');

        $response->assertStatus(403);
    }

    /** @test */
    public function test_santri_index_page_for_wali_asrama_is_invalid()
    {
        $response = $this->actingAs($this->waliAsrama)->get('/santri');

        $response->assertStatus(403);
    }

    /** @test */
    public function test_create_santri_page_for_admin()
    {
        $response = $this->actingAs($this->admin)->get('/santri/create');

        $response->assertStatus(200);
        $response->assertViewIs('santris.create');
    }

    /** @test */
    public function test_create_santri_page_for_guru_is_invalid()
    {
        $response = $this->actingAs($this->guru)->get('/santri/create');

        $response->assertStatus(403);
    }

    /** @test */
    public function test_create_santri_page_for_wali_santri_is_invalid()
    {
        $response = $this->actingAs($this->waliSantri)->get('/santri/create');

        $response->assertStatus(403);
    }

    /** @test */
    public function test_create_santri_page_for_wali_asrama_is_invalid()
    {
        $response = $this->actingAs($this->waliAsrama)->get('/santri/create');

        $response->assertStatus(403);
    }

    /** @test */
    public function test_store_santri_as_admin()
    {
        $response = $this->actingAs($this->admin)->post('/santri', [
            'name' => 'New Santri',
            'nik' => '987654321',
            'address' => 'Jl. Test No. 1',
            'phone_number' => '08987654321',
        ]);

        $response->assertRedirect('/santri');
        $this->assertDatabaseHas('santris', [
            'name' => 'New Santri',
            'nik' => '987654321',
        ]);
    }

    /** @test */
    public function test_store_santri_as_guru_is_invalid()
    {
        $response = $this->actingAs($this->guru)->post('/santri', [
            'name' => 'New Santri',
            'nik' => '987654321',
            'address' => 'Jl. Test No. 1',
            'phone_number' => '08987654321',
        ]);

        $response->assertStatus(403);

    }

    /** @test */
    public function test_store_santri_as_wali_santri_is_invalid()
    {
        $response = $this->actingAs($this->waliSantri)->post('/santri', [
            'name' => 'New Santri',
            'nik' => '987654321',
            'address' => 'Jl. Test No. 1',
            'phone_number' => '08987654321',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_store_santri_as_wali_asrama_is_invalid()
    {
        $response = $this->actingAs($this->waliAsrama)->post('/santri', [
            'name' => 'New Santri',
            'nik' => '987654321',
            'address' => 'Jl. Test No. 1',
            'phone_number' => '08987654321',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_edit_santri_page_for_admin()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->admin)->get("/santri/{$santri->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('santris.edit');
    }

    /** @test */
    public function test_edit_santri_page_for_guru_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->guru)->get("/santri/{$santri->id}/edit");

        $response->assertStatus(403);
    }

    /** @test */
    public function test_edit_santri_page_for_wali_santri_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->waliSantri)->get("/santri/{$santri->id}/edit");

        $response->assertStatus(403);
    }

    /** @test */
    public function test_edit_santri_page_for_wali_asrama_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->waliAsrama)->get("/santri/{$santri->id}/edit");

        $response->assertStatus(403);
    }

    /** @test */
    public function test_update_santri_as_admin()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->admin)->put("/santri/{$santri->id}", [
            'name' => 'Updated Santri',
            'nik' => '123456789',
            'address' => 'Jl. Updated No. 2',
            'phone_number' => '08887776655',
        ]);

        $response->assertRedirect('/santri');
        $this->assertDatabaseHas('santris', [
            'name' => 'Updated Santri',
        ]);
    }

    /** @test */
/** @test */
public function test_update_santri_as_guru_is_invalid()
{
    // Buat santri untuk diperbarui
    $santri = Santri::factory()->create();

    // Autentikasi sebagai guru
    $response = $this->actingAs($this->guru)->put("/santri/{$santri->id}", [
        'name' => 'Updated Santri',
        'nik' => '123456789',
        'address' => 'Jl. Updated No. 2',
        'phone_number' => '08887776655',
    ]);

    // Periksa jika respons adalah 403 Forbidden karena guru tidak memiliki izin
    $response->assertStatus(403);
    
    // Periksa bahwa database tidak berubah
    $this->assertDatabaseMissing('santris', [
        'name' => 'Updated Santri',
        'nik' => '123456789',
    ]);
}


    /** @test */
    public function test_update_santri_as_wali_santri_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->waliSantri)->put("/santri/{$santri->id}", [
            'name' => 'Updated Santri',
            'nik' => '123456789',
            'address' => 'Jl. Updated No. 2',
            'phone_number' => '08887776655',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_update_santri_as_wali_asrama_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->waliAsrama)->put("/santri/{$santri->id}", [
            'name' => 'Updated Santri',
            'nik' => '123456789',
            'address' => 'Jl. Updated No. 2',
            'phone_number' => '08887776655',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_delete_santri_as_admin()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/santri/{$santri->id}");

        $response->assertRedirect('/santri');
        $this->assertDatabaseMissing('santris', [
            'id' => $santri->id,
        ]);
    }

    /** @test */
    public function test_delete_santri_as_guru_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->guru)->delete("/santri/{$santri->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function test_delete_santri_as_wali_santri_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->waliSantri)->delete("/santri/{$santri->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function test_delete_santri_as_wali_asrama_is_invalid()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->waliAsrama)->delete("/santri/{$santri->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function test_store_santri_validation_fails()
    {
        $response = $this->actingAs($this->admin)->post('/santri', []);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function test_update_santri_validation_fails()
    {
        $santri = Santri::factory()->create();

        $response = $this->actingAs($this->admin)->put("/santri/{$santri->id}", [
            'name' => '',
            'nik' => 000000,
        ]);

        $response->assertSessionHasErrors(['name', 'nik']);
    }

    /** @test */
    public function test_delete_santri_not_found()
    {
        $response = $this->actingAs($this->admin)->delete("/santri/999"); // ID yang tidak ada

        $response->assertStatus(404);
    }
}
