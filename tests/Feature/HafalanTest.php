<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use App\Models\Hafalan;
use App\Models\Santri;
use App\Models\AktivitasPendidikan;
use App\Models\Rombel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HafalanTest extends TestCase
{
    use RefreshDatabase;
    protected $adminUser;
    protected $guruUser;
    protected $waliSantriUser;
    protected $waliAsramaUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat pengguna dengan berbagai role
        $this->adminUser = User::factory()->create(['role' => '2']);
        $this->waliAsramaUser = User::factory()->create(['role' => '3']);
        $this->guruUser = User::factory()->create(['role' => '1']);
        $this->waliSantriUser = User::factory()->create(['role' => '0']);
    }

    /** @test */
    public function only_admin_or_wali_asrama_can_view_hafalans_index()
    {
        $response = $this->actingAs($this->adminUser)->get('/hafalan');
        $response->assertStatus(200);

        $response = $this->actingAs($this->waliAsramaUser)->get('/hafalan');
        $response->assertStatus(200);

        $response = $this->actingAs($this->guruUser)->get('/hafalan');
        $response->assertStatus(403);

        $response = $this->actingAs($this->waliSantriUser)->get('/hafalan');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_or_wali_asrama_can_create_hafalan()
    {
        $guru = Guru::factory()->create();
        $rombel = Rombel::factory()->create();
        $santri = Santri::factory()->create();
        AktivitasPendidikan::factory()->create([
            'rombel_id' => $rombel->id,
            'santri_id' => $santri->id,
        ]);

        $data = [
            'guru_id' => $guru->id,
            'santri_id' => [$santri->id],
            'juz' => ['5'],
            'progres' => ['50%'],
            'catatan' => ['Belum lancar membaca'],
        ];

        $response = $this->actingAs($this->adminUser)->post('/hafalan', $data);
        $response->assertStatus(302); // Redirect after successful creation

        $response = $this->actingAs($this->waliAsramaUser)->post('/hafalan', $data);
        $response->assertStatus(302); // Redirect after successful creation

        $response = $this->actingAs($this->guruUser)->post('/hafalan', $data);
        $response->assertStatus(403); // Forbidden for non-admin or non-wali asrama

        $response = $this->actingAs($this->waliSantriUser)->post('/hafalan', $data);
        $response->assertStatus(403); // Forbidden for non-admin or non-wali asrama
    }

    /** @test */
    public function only_admin_or_wali_asrama_can_edit_hafalan()
    {
        $guru = Guru::factory()->create();
        $hafalan = Hafalan::factory()->create();

        $data = [
            'guru_id' => $guru->id,
            'santri_id' => $hafalan->santri_id,
            'juz' => '7',
            'progres' => '75%',
            'catatan' => 'Sudah mulai lancar',
        ];

        $response = $this->actingAs($this->adminUser)->put('/hafalan/' . $hafalan->id, $data);
        $response->assertStatus(302); // Redirect after successful update

        $response = $this->actingAs($this->waliAsramaUser)->put('/hafalan/' . $hafalan->id, $data);
        $response->assertStatus(302); // Redirect after successful update

        $response = $this->actingAs($this->guruUser)->put('/hafalan/' . $hafalan->id, $data);
        $response->assertStatus(403); // Forbidden for non-admin or non-wali asrama

        $response = $this->actingAs($this->waliSantriUser)->put('/hafalan/' . $hafalan->id, $data);
        $response->assertStatus(403); // Forbidden for non-admin or non-wali asrama
    }

    /** @test */
    public function only_admin_or_wali_asrama_can_delete_hafalan()
    {
        $hafalan = Hafalan::factory()->create();

        $response = $this->actingAs($this->adminUser)->delete('/hafalan/' . $hafalan->id);
        $response->assertStatus(302); // Redirect after successful deletion

        $response = $this->actingAs($this->waliAsramaUser)->delete('/hafalan/' . $hafalan->id);
        $response->assertStatus(404); // Redirect after successful deletion

        $response = $this->actingAs($this->guruUser)->delete('/hafalan/' . $hafalan->id);
        $response->assertStatus(404); // Forbidden for non-admin or non-wali asrama

        $response = $this->actingAs($this->waliSantriUser)->delete('/hafalan/' . $hafalan->id);
        $response->assertStatus(404); // Forbidden for non-admin or non-wali asrama
    }
}
