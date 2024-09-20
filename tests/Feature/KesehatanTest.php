<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kesehatan;
use App\Models\Santri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KesehatanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $waliAsramaUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['role' => '2']);
        $this->waliAsramaUser = User::factory()->create(['role' => '3']);
    }

    public function test_admin_or_wali_asrama_can_access_kesehatan_index()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('kesehatan.index'));

        $response->assertStatus(200);
    }

    public function test_non_admin_or_wali_asrama_cannot_access_kesehatan_index()
    {
        $user = User::factory()->create(['role' => 0]);

        $response = $this->actingAs($user)->get(route('kesehatan.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_kesehatan()
    {
        $santri = Santri::factory()->create();
        $data = [
            'santri_id' => $santri->id,
            'keluhan' => 'Sakit kepala',
            'diagnosa' => 'Migraine',
            'dokter' => 'Dr. John',
            'obat_dikonsumsi' => 'Paracetamol',
            'obat_dokter' => 'Ibuprofen',
            'tanggal_masuk' => '2024-07-14',
            'tanggal_keluar' => null,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('kesehatan.store'), $data);

        $response->assertRedirect(route('kesehatan.index'));
        $this->assertDatabaseHas('kesehatans', $data);
    }

    public function test_admin_can_edit_kesehatan()
    {
        $kesehatan = Kesehatan::factory()->create();
        $santri = Santri::factory()->create();
        $updateData = [
            'santri_id' => $santri->id,
            'keluhan' => 'Demam tinggi',
            'diagnosa' => 'Demam berdarah',
            'dokter' => 'Dr. Smith',
            'obat_dikonsumsi' => 'Parasetamol',
            'obat_dokter' => 'Antibiotik',
            'tanggal_masuk' => '2024-07-14',
            'tanggal_keluar' => null,
        ];

        $response = $this->actingAs($this->adminUser)->put(route('kesehatan.update', $kesehatan->id), $updateData);

        $response->assertRedirect(route('kesehatan.index'));
        $this->assertDatabaseHas('kesehatans', $updateData);
    }

    public function test_admin_can_delete_kesehatan()
    {
        $kesehatan = Kesehatan::factory()->create();

        $response = $this->actingAs($this->adminUser)->delete(route('kesehatan.destroy', $kesehatan->id));

        $response->assertRedirect(route('kesehatan.index'));
        $this->assertDatabaseMissing('kesehatans', ['id' => $kesehatan->id]);
    }

    public function test_admin_can_update_tanggal_keluar()
    {
        $kesehatan = Kesehatan::factory()->create(['tanggal_keluar' => null]);

        $response = $this->actingAs($this->adminUser)->post(route('kesehatan.sembuh', $kesehatan->id));

        $response->assertJson(['success' => 'Kesehatan updated successfully']);
        $this->assertNotNull($kesehatan->fresh()->tanggal_keluar);
    }
}
