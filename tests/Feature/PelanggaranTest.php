<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pelanggaran;
use App\Models\Santri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelanggaranControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $waliAsramaUser;
    protected $guruUser;
    protected $waliSantriUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users for each role
        $this->adminUser = User::factory()->create(['role' => '2']);
        $this->waliAsramaUser = User::factory()->create(['role' => '3']);
        $this->guruUser = User::factory()->create(['role' => '1']);
        $this->waliSantriUser = User::factory()->create(['role' => '0']);
    }

    /** @test */
    public function only_admin_and_wali_asrama_can_access_pelanggaran_index()
    {
        // Admin can access
        $this->actingAs($this->adminUser);
        $response = $this->get('/pelanggaran');
        $response->assertStatus(200);
        $response->assertViewIs('pelanggaran.index');

        // Wali Asrama can access
        $this->actingAs($this->waliAsramaUser);
        $response = $this->get('/pelanggaran');
        $response->assertStatus(200);
        $response->assertViewIs('pelanggaran.index');

        // Guru cannot access
        $this->actingAs($this->guruUser);
        $response = $this->get('/pelanggaran');
        $response->assertStatus(403);

        // Wali Santri cannot access
        $this->actingAs($this->waliSantriUser);
        $response = $this->get('/pelanggaran');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_wali_asrama_can_access_create_pelanggaran()
    {
        // Admin can access
        $this->actingAs($this->adminUser);
        $response = $this->get('/pelanggaran/create');
        $response->assertStatus(200);
        $response->assertViewIs('pelanggaran.create');

        // Wali Asrama can access
        $this->actingAs($this->waliAsramaUser);
        $response = $this->get('/pelanggaran/create');
        $response->assertStatus(200);
        $response->assertViewIs('pelanggaran.create');

        // Guru cannot access
        $this->actingAs($this->guruUser);
        $response = $this->get('/pelanggaran/create');
        $response->assertStatus(403);

        // Wali Santri cannot access
        $this->actingAs($this->waliSantriUser);
        $response = $this->get('/pelanggaran/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_wali_asrama_can_store_pelanggaran()
    {
        $santri = Santri::factory()->create();
        $data = [
            'santri_id' => $santri->id,
            'pelanggaran' => 'Terlambat',
            'tindakan' => 'Peringatan',
            'tanggal' => now()->toDateString(),
        ];

        // Admin can store
        $this->actingAs($this->adminUser);
        $response = $this->post('/pelanggaran', $data);
        $response->assertRedirect('/pelanggaran');
        $this->assertDatabaseHas('pelanggarans', $data);

        // Wali Asrama can store
        $this->actingAs($this->waliAsramaUser);
        $response = $this->post('/pelanggaran', $data);
        $response->assertRedirect('/pelanggaran');
        $this->assertDatabaseHas('pelanggarans', $data);

        // Guru cannot store
        $this->actingAs($this->guruUser);
        $response = $this->post('/pelanggaran', $data);
        $response->assertStatus(403);

        // Wali Santri cannot store
        $this->actingAs($this->waliSantriUser);
        $response = $this->post('/pelanggaran', $data);
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_wali_asrama_can_update_pelanggaran()
    {
        $pelanggaran = Pelanggaran::factory()->create();
        $updateData = [
            'santri_id' => $pelanggaran->santri_id,
            'pelanggaran' => 'Telat Masuk',
            'tindakan' => 'Skorsing',
            'tanggal' => now()->toDateString(),
        ];

        // Admin can update
        $this->actingAs($this->adminUser);
        $response = $this->put('/pelanggaran/' . $pelanggaran->id, $updateData);
        $response->assertRedirect('/pelanggaran');
        $this->assertDatabaseHas('pelanggarans', $updateData);

        // Wali Asrama can update
        $this->actingAs($this->waliAsramaUser);
        $response = $this->put('/pelanggaran/' . $pelanggaran->id, $updateData);
        $response->assertRedirect('/pelanggaran');
        $this->assertDatabaseHas('pelanggarans', $updateData);

        // Guru cannot update
        $this->actingAs($this->guruUser);
        $response = $this->put('/pelanggaran/' . $pelanggaran->id, $updateData);
        $response->assertStatus(403);

        // Wali Santri cannot update
        $this->actingAs($this->waliSantriUser);
        $response = $this->put('/pelanggaran/' . $pelanggaran->id, $updateData);
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_wali_asrama_can_delete_pelanggaran()
    {
        $pelanggaran = Pelanggaran::factory()->create();

        // Admin can delete
        $this->actingAs($this->adminUser);
        $response = $this->delete('/pelanggaran/' . $pelanggaran->id);
        $response->assertRedirect('/pelanggaran');
        $this->assertDatabaseMissing('pelanggarans', ['id' => $pelanggaran->id]);

        $pelanggaran = Pelanggaran::factory()->create();
        // Wali Asrama can delete
        $this->actingAs($this->waliAsramaUser);
        $response = $this->delete('/pelanggaran/' . $pelanggaran->id);
        $response->assertRedirect('/pelanggaran');
        $this->assertDatabaseMissing('pelanggarans', ['id' => $pelanggaran->id]);

        $pelanggaran = Pelanggaran::factory()->create();
        // Guru cannot delete
        $this->actingAs($this->guruUser);
        $response = $this->delete('/pelanggaran/' . $pelanggaran->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('pelanggarans', ['id' => $pelanggaran->id]);

        $pelanggaran = Pelanggaran::factory()->create();
        // Wali Santri cannot delete
        $this->actingAs($this->waliSantriUser);
        $response = $this->delete('/pelanggaran/' . $pelanggaran->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('pelanggarans', ['id' => $pelanggaran->id]);
    }
}
