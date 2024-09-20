<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AktivitasPendidikan;
use App\Models\Santri;
use App\Models\Rombel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AktivitasPendidikanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $guruUser;

    protected function setUp(): void
    {
        parent::setUp();

        
        $this->adminUser = User::factory()->create(['role' => '2']);
        $this->guruUser = User::factory()->create(['role' => '1']);
    }

    public function admin_can_delete_aktivitas_pendidikan()
    {
        $aktivitas = AktivitasPendidikan::factory()->create();

        // Admin can delete
        $this->actingAs($this->adminUser);
        $response = $this->delete('/aktivitas/'. $aktivitas->id);
        $response->assertRedirect('/aktivitas');
        $this->assertDatabaseMissing('aktivitas_pendidikans', ['id' => $aktivitas->id]);

        $aktivitas = AktivitasPendidikan::factory()->create();
        $this->actingAs($this->guruUser);
        $response = $this->delete(route('aktivitas.destroy', $aktivitas->id));
        $response->assertRedirect(route('aktivitas.index'));
        $this->assertDatabaseMissing('aktivitas_pendidikans', ['id' => $aktivitas->id]);
    }
   

    /** @test */
    public function admin_or_guru_can_access_aktivitas_index()
    {
        // Admin can access
        $this->actingAs($this->adminUser);
        $response = $this->get(route('aktivitas.index'));
        $response->assertStatus(200);

        // Guru can access
        $this->actingAs($this->guruUser);
        $response = $this->get(route('aktivitas.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_admin_or_guru_cannot_access_aktivitas_index()
    {
        // Create a user with a different role
        $user = User::factory()->create(['role' => '0']);

        // Wali Santri cannot access
        $this->actingAs($user);
        $response = $this->get(route('aktivitas.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_or_guru_can_create_aktivitas_pendidikan()
    {
        $santri = Santri::factory()->create();
        $rombel = Rombel::factory()->create();
        $data = [
            'santri_id' => $santri->id,
            'rombel_id' => $rombel->id,
            'tahun_pelajaran' => '2024-2025',
        ];

        // Admin can create
        $response = $this->actingAs($this->adminUser)->post(route('aktivitas.store'), $data);
        $response->assertRedirect(route('aktivitas.index'));
        $this->assertDatabaseHas('aktivitas_pendidikans', $data);

        // Guru can create
        $response = $this->actingAs($this->guruUser)->post(route('aktivitas.store'), $data);
        $response->assertRedirect(route('aktivitas.index'));
        $this->assertDatabaseHas('aktivitas_pendidikans', $data);
    }

    /** @test */
    public function non_admin_or_guru_cannot_create_aktivitas_pendidikan()
    {
        $santri = Santri::factory()->create();
        $rombel = Rombel::factory()->create();
        $data = [
            'santri_id' => $santri->id,
            'rombel_id' => $rombel->id,
            'tahun_pelajaran' => '2024-2025',
        ];

        // Create a user with a different role
        $user = User::factory()->create(['role' => '0']);

        // Wali Santri cannot create
        $response = $this->actingAs($user)->post(route('aktivitas.store'), $data);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('aktivitas_pendidikans', $data);
    }


    

    /** @test */
    public function non_admin_or_guru_cannot_edit_aktivitas_pendidikan()
    {
        $aktivitas = AktivitasPendidikan::factory()->create();
        $santri = Santri::factory()->create();
        $rombel = Rombel::factory()->create();
        $updateData = [
            'santri_id' => $santri->id,
            'rombel_id' => $rombel->id,
            'tahun_pelajaran' => '2024-2025',
        ];

        // Create a user with a different role
        $user = User::factory()->create(['role' => '0']);

        // Wali Santri cannot edit
        $response = $this->actingAs($user)->put(route('aktivitas.update', $aktivitas->id), $updateData);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('aktivitas_pendidikans', [
            'id' => $aktivitas->id,
            'santri_id' => $santri->id,
            'rombel_id' => $rombel->id,
            'tahun_pelajaran' => '2024-2025',
        ]);
    }

    /** @test */


    /** @test */
    public function non_admin_or_guru_cannot_delete_aktivitas_pendidikan()
    {
        $aktivitas = AktivitasPendidikan::factory()->create();

        // Create a user with a different role
        $user = User::factory()->create(['role' => '0']);

        // Wali Santri cannot delete
        $response = $this->actingAs($user)->delete(route('aktivitas.destroy', $aktivitas->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('aktivitas_pendidikans', ['id' => $aktivitas->id]);
    }
}
