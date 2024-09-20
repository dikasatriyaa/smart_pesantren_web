<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruTest extends TestCase
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
    public function test_only_admin_can_access_guru_index()
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/guru');
        $response->assertStatus(200);
        $response->assertViewIs('gurus.index');

        $this->actingAs($this->guruUser);
        $response = $this->get('/guru');
        $response->assertStatus(403);

        $this->actingAs($this->waliSantriUser);
        $response = $this->get('/guru');
        $response->assertStatus(403);

        $this->actingAs($this->waliAsramaUser);
        $response = $this->get('/guru');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_can_create_guru()
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/guru/create');
        $response->assertStatus(200);
        $response->assertViewIs('gurus.create');

        $this->actingAs($this->guruUser);
        $response = $this->get('/guru/create');
        $response->assertStatus(403);

        $this->actingAs($this->waliSantriUser);
        $response = $this->get('/guru/create');
        $response->assertStatus(403);

        $this->actingAs($this->waliAsramaUser);
        $response = $this->get('/guru/create');
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_can_store_guru()
    {
        $this->actingAs($this->adminUser);
        $user = User::factory()->create(['role' => 1]);

        $response = $this->post('/guru', [
            'user_id' => $user->id,
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'M.Sc',
            'status_pegawai' => 'Permanent',
            'npk' => '12345',
            'tmt_pegawai' => '2020-01-01',
            'npwp' => '1234567890',
        ]);
        $response->assertRedirect('/guru');
        $this->assertDatabaseHas('gurus', ['user_id' => $user->id]);

        $this->actingAs($this->guruUser);
        $response = $this->post('/guru', [
            'user_id' => $user->id,
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'M.Sc',
            'status_pegawai' => 'Permanent',
            'npk' => '12345',
            'tmt_pegawai' => '2020-01-01',
            'npwp' => '1234567890',
        ]);
        $response->assertStatus(403);

        $this->actingAs($this->waliSantriUser);
        $response = $this->post('/guru', [
            'user_id' => $user->id,
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'M.Sc',
            'status_pegawai' => 'Permanent',
            'npk' => '12345',
            'tmt_pegawai' => '2020-01-01',
            'npwp' => '1234567890',
        ]);
        $response->assertStatus(403);

        $this->actingAs($this->waliAsramaUser);
        $response = $this->post('/guru', [
            'user_id' => $user->id,
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'M.Sc',
            'status_pegawai' => 'Permanent',
            'npk' => '12345',
            'tmt_pegawai' => '2020-01-01',
            'npwp' => '1234567890',
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function only_admin_can_update_guru()
    {
    $guru = Guru::factory()->create();

    $updateData = [
        'user_id' => $this->adminUser->id, // Pastikan user_id diisi dengan benar
        'gelar_depan' => 'Dr.',
        'gelar_belakang' => 'M.Sc',
        'status_pegawai' => 'Tetap',
        'npk' => '12345',
        'tmt_pegawai' => '2023-01-01',
        'npwp' => '67890',
    ];

    // Admin dapat memperbarui data guru
    $this->actingAs($this->adminUser);
    $response = $this->put('/guru/' . $guru->id, $updateData);
    $response->assertRedirect('/guru');
    $this->assertDatabaseHas('gurus', $updateData);

    // Guru tidak dapat memperbarui data guru
    $this->actingAs($this->guruUser);
    $response = $this->put('/guru/' . $guru->id, $updateData);
    $response->assertStatus(403);


    // Wali Santri tidak dapat memperbarui data guru
    $this->actingAs($this->waliSantriUser);
    $response = $this->put('/guru/' . $guru->id, $updateData);
    $response->assertStatus(403);
    // $this->assertDatabaseMissing('gurus', $updateData);

    // Wali Asrama tidak dapat memperbarui data guru
    $this->actingAs($this->waliAsramaUser);
    $response = $this->put('/guru/' . $guru->id, $updateData);
    $response->assertStatus(403);
    // $this->assertDatabaseMissing('gurus', $updateData);
}

    /** @test */
    public function only_admin_can_delete_guru()
    {
        $guru = Guru::factory()->create();

        // Admin dapat menghapus data guru
        $this->actingAs($this->adminUser);
        $response = $this->delete('/guru/' . $guru->id);
        $response->assertRedirect('/guru');
        $this->assertDatabaseMissing('gurus', ['id' => $guru->id]);

        // Guru tidak dapat menghapus data guru
        $guru = Guru::factory()->create();
        $this->actingAs($this->guruUser);
        $response = $this->delete('/guru/' . $guru->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('gurus', ['id' => $guru->id]);

        // Wali Santri tidak dapat menghapus data guru
        $guru = Guru::factory()->create();
        $this->actingAs($this->waliSantriUser);
        $response = $this->delete('/guru/' . $guru->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('gurus', ['id' => $guru->id]);

        // Wali Asrama tidak dapat menghapus data guru
        $guru = Guru::factory()->create();
        $this->actingAs($this->waliAsramaUser);
        $response = $this->delete('/guru/' . $guru->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('gurus', ['id' => $guru->id]);
    }
}