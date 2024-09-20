<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Akademik;
use App\Models\Mapel;
use App\Models\Santri;
use App\Models\Rombel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AkademikTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $guruUser;
    protected $waliSantriUser;
    protected $waliAsramaUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users for each role
        $this->adminUser = User::factory()->create(['role' => '2']);
        $this->guruUser = User::factory()->create(['role' => '1']);
        $this->waliSantriUser = User::factory()->create(['role' => '0']);
        $this->waliAsramaUser = User::factory()->create(['role' => '3']);
    }

    /** @test */
    public function test_only_admin_and_guru_can_access_akademik_index()
    {
        // Admin can access
        $this->actingAs($this->adminUser);
        $response = $this->get('/akademik');
        $response->assertStatus(200);
        $response->assertViewIs('akademiks.index');

        // Guru can access
        $this->actingAs($this->guruUser);
        $response = $this->get('/akademik');
        $response->assertStatus(200);
        $response->assertViewIs('akademiks.index');

        // Wali Santri cannot access
        $this->actingAs($this->waliSantriUser);
        $response = $this->get('/akademik');
        $response->assertStatus(403);

        // Wali Asrama cannot access
        $this->actingAs($this->waliAsramaUser);
        $response = $this->get('/akademik');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_guru_can_create_akademik()
    {
        // Admin can access
        $this->actingAs($this->adminUser);
        $response = $this->get('/akademik/create');
        $response->assertStatus(200);
        $response->assertViewIs('akademiks.create');

        // Guru cannot access
        $this->actingAs($this->guruUser);
        $response = $this->get('/akademik/create');
        $response->assertStatus(200);
        $response->assertViewIs('akademiks.create');

        // Wali Santri cannot access
        $this->actingAs($this->waliSantriUser);
        $response = $this->get('/akademik/create');
        $response->assertStatus(403);

        // Wali Asrama cannot access
        $this->actingAs($this->waliAsramaUser);
        $response = $this->get('/akademik/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_guru_can_store_akademik()
    {
        $mapel = Mapel::factory()->create();
        $santri = Santri::factory()->create();
        
        // Admin can store
        $this->actingAs($this->adminUser);
        $response = $this->post('/akademik', [
            'mapel_id' => $mapel->id,
            'tahun_pelajaran' => '2023-2024',
            'nilai' => ['A'],
            'santri_id' => [$santri->id],
        ]);
        $response->assertRedirect('/akademik');
        $this->assertDatabaseHas('akademiks', ['santri_id' => $santri->id]);

        // Guru can store
        $this->actingAs($this->guruUser);
        $response = $this->post('/akademik', [
            'mapel_id' => $mapel->id,
            'tahun_pelajaran' => '2023-2024',
            'nilai' => ['A'],
            'santri_id' => [$santri->id],
        ]);
        $response->assertRedirect('/akademik');
        $this->assertDatabaseHas('akademiks', ['santri_id' => $santri->id]);

        // Wali Santri cannot store
        $this->actingAs($this->waliSantriUser);
        $response = $this->post('/akademik', [
            'mapel_id' => $mapel->id,
            'tahun_pelajaran' => '2023-2024',
            'nilai' => ['A'],
            'santri_id' => [$santri->id],
        ]);
        $response->assertStatus(403);

        // Wali Asrama cannot store
        $this->actingAs($this->waliAsramaUser);
        $response = $this->post('/akademik', [
            'mapel_id' => $mapel->id,
            'tahun_pelajaran' => '2023-2024',
            'nilai' => ['A'],
            'santri_id' => [$santri->id],
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_and_guru_can_update_akademik()
    {
        $akademik = Akademik::factory()->create();
        $updateData = [
            'santri_id' => $akademik->santri_id,
            'mapel_id' => $akademik->mapel_id,
            'tahun_pelajaran' => '2023-2024',
            'nilai' => 'B',
        ];

        // Admin can update
        $this->actingAs($this->adminUser);
        $response = $this->put('/akademik/' . $akademik->id, $updateData);
        $response->assertRedirect('/akademik');
        $this->assertDatabaseHas('akademiks', $updateData);

        // Guru can update
        $this->actingAs($this->guruUser);
        $response = $this->put('/akademik/' . $akademik->id, $updateData);
        $response->assertRedirect('/akademik');
        $this->assertDatabaseHas('akademiks', $updateData);

        // Wali Santri cannot update
        $this->actingAs($this->waliSantriUser);
        $response = $this->put('/akademik/' . $akademik->id, $updateData);
        $response->assertStatus(403);

        // Wali Asrama cannot update
        $this->actingAs($this->waliAsramaUser);
        $response = $this->put('/akademik/' . $akademik->id, $updateData);
        $response->assertStatus(403);
    }

    /** @test */
 /** @test */
 public function admin_can_delete_akademik()
 {
     $akademik = Akademik::factory()->create();

     // Admin can delete
     $this->actingAs($this->adminUser);
     $response = $this->delete('/akademik/' . $akademik->id);
     $response->assertRedirect('/akademik');
     $this->assertDatabaseMissing('akademiks', ['id' => $akademik->id]);
 }

 /** @test */
 public function guru_can_delete_akademik()
 {
     $akademik = Akademik::factory()->create();

     // Guru can delete
     $this->actingAs($this->guruUser);
     $response = $this->delete('/akademik/' . $akademik->id);
     $response->assertRedirect('/akademik');
     $this->assertDatabaseMissing('akademiks', ['id' => $akademik->id]);
 }

 /** @test */
 public function wali_santri_cannot_delete_akademik()
 {
     $akademik = Akademik::factory()->create();

     // Wali Santri cannot delete
     $this->actingAs($this->waliSantriUser);
     $response = $this->delete('/akademik/' . $akademik->id);
     $response->assertStatus(403);
     $this->assertDatabaseHas('akademiks', ['id' => $akademik->id]);
 }

 /** @test */
 public function wali_asrama_cannot_delete_akademik()
 {
     $akademik = Akademik::factory()->create();

     // Wali Asrama cannot delete
     $this->actingAs($this->waliAsramaUser);
     $response = $this->delete('/akademik/' . $akademik->id);
     $response->assertStatus(403);
     $this->assertDatabaseHas('akademiks', ['id' => $akademik->id]);
 }
}

