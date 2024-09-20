<?php

namespace Tests\Feature;

use App\Models\Kehadiran;
use App\Models\Rombel;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KehadiranControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat user dengan role admin
        $this->adminUser = User::factory()->create(['role' => '2']);
    }

    /** @test */
    public function admin_can_access_kehadiran_index()
    {
        $response = $this->actingAs($this->adminUser)->get(route('kehadiran.index'));

        $response->assertStatus(200);
    }

/** @test */
public function admin_can_create_kehadiran()
{
    // Membuat data rombel dan santri jika belum ada
    $rombel = Rombel::factory()->create();
    $santri = Santri::factory()->create();

    // Data untuk pembuatan kehadiran baru
    $data = [
        'santris' => [
            [
                'santri_id' => $santri->id,
                'status' => 'Hadir',
                'masuk' => '07:00',
            ],
        ],
        'tanggal' => now()->format('Y-m-d'),
    ];

    // Mengirimkan request POST untuk menyimpan kehadiran baru
    $response = $this->actingAs($this->adminUser)->post(route('kehadiran.store'), $data);

    // Memastikan redirect ke halaman index
    $response->assertRedirect(route('kehadiran.index'));

    // Memeriksa bahwa data kehadiran berhasil ditambahkan ke dalam database
    $this->assertDatabaseHas('kehadirans', [
        'santri_id' => $santri->id,
        'status' => 'Hadir',
        'masuk' => '07:00',
        'tanggal' => $data['tanggal'],
    ]);
}



    /** @test */
    public function admin_can_edit_kehadiran()
    {
        // Membuat kehadiran baru untuk diuji edit
        $kehadiran = Kehadiran::factory()->create();

        // Data baru untuk update kehadiran
        $newData = [
            'santri_id' => $kehadiran->santri_id,
            'status' => 'Tidak Hadir',
            'masuk' => '07:00',
            'tanggal' => $kehadiran->tanggal,
        ];

        // Mengirimkan request PUT untuk update kehadiran
        $response = $this->actingAs($this->adminUser)->put(route('kehadiran.update', $kehadiran->id), $newData);

        // Memastikan redirect ke halaman index
        $response->assertRedirect(route('kehadiran.index'));

        // Memeriksa bahwa data kehadiran berhasil diupdate di dalam database
        $this->assertDatabaseHas('kehadirans', [
            'id' => $kehadiran->id,
            'status' => 'Tidak Hadir',
        ]);
    }

    /** @test */
    public function admin_can_delete_kehadiran()
    {
        // Membuat kehadiran baru untuk diuji delete
        $kehadiran = Kehadiran::factory()->create();

        // Mengirimkan request DELETE untuk menghapus kehadiran
        $response = $this->actingAs($this->adminUser)->delete(route('kehadiran.destroy', $kehadiran->id));

        // Memastikan redirect ke halaman index
        $response->assertRedirect(route('kehadiran.index'));

        // Memeriksa bahwa data kehadiran telah dihapus dari database
        $this->assertDatabaseMissing('kehadirans', [
            'id' => $kehadiran->id,
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_kehadiran_index()
    {
        // Membuat user dengan role non-admin
        $user = User::factory()->create(['role' => '1']); // Contoh user dengan role guru

        // Mengirimkan request GET ke route kehadiran.index
        $response = $this->actingAs($user)->get(route('kehadiran.index'));

        // Memastikan user di-redirect ke halaman 403 (Forbidden)
        $response->assertStatus(403);
    }
}

