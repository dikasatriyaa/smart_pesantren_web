<?php

namespace Tests\Feature;

use App\Models\AktivitasPendidikan;
use App\Models\User;
use App\Models\Rombel;
use App\Models\Guru;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RombelTest extends TestCase
{
    use RefreshDatabase; // Using RefreshDatabase trait to reset database state

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user with role '2'
        $this->adminUser = User::factory()->create(['role' => '2']);
    }

    public function test_admin_can_access_rombel_index()
    {
        // Acting as the admin user
        $response = $this->actingAs($this->adminUser)->get(route('rombel.index'));

        // Asserting that the response status is 200 (OK)
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_rombel_index()
    {
        // Creating a non-admin user (role 1 for example)
        $user = User::factory()->create(['role' => '1']);

        // Acting as the non-admin user
        $response = $this->actingAs($user)->get(route('rombel.index'));

        // Asserting that the user is redirected with status 403 (Forbidden)
        $response->assertStatus(403);
    }

    public function test_admin_can_create_rombel()
    {
        // Creating a guru for the rombel
        $guru = Guru::factory()->create();

        // Data for creating a new rombel
        $rombelData = [
            'tahun_pelajaran' => '2023/2024',
            'tingkat_kelas' => 'X',
            'nama_rombel' => 'X-1',
            'guru_id' => $guru->id,
        ];

        // Acting as the admin user to post the new rombel data
        $response = $this->actingAs($this->adminUser)->post(route('rombel.store'), $rombelData);

        // Asserting that the rombel is successfully created and redirected to index
        $response->assertRedirect(route('rombel.index'));
        $this->assertDatabaseHas('rombels', $rombelData);
    }

    public function test_admin_can_edit_rombel()
    {
        // Creating a rombel to be edited
        $rombel = Rombel::factory()->create();

        // Data for editing the rombel
        $newRombelData = [
            'tahun_pelajaran' => '2024/2025',
            'tingkat_kelas' => 'XI',
            'nama_rombel' => 'XI-1',
            'guru_id' => $rombel->guru_id, // Keeping the same guru for simplicity
        ];

        // Acting as the admin user to update the rombel
        $response = $this->actingAs($this->adminUser)->put(route('rombel.update', $rombel->id), $newRombelData);

        // Asserting that the rombel is successfully updated and redirected to index
        $response->assertRedirect(route('rombel.index'));
        $this->assertDatabaseHas('rombels', $newRombelData);
    }

    public function test_admin_can_delete_rombel()
    {
        // Creating a rombel to be deleted
        $rombel = Rombel::factory()->create();

        // Acting as the admin user to delete the rombel
        $response = $this->actingAs($this->adminUser)->delete(route('rombel.destroy', $rombel->id));

        // Asserting that the rombel is successfully deleted and redirected to index
        $response->assertRedirect(route('rombel.index'));
        $this->assertDatabaseMissing('rombels', ['id' => $rombel->id]);
    }

    public function test_validation_when_creating_rombel()
    {
        // Acting as the admin user without providing required fields
        $response = $this->actingAs($this->adminUser)->post(route('rombel.store'), []);

        // Asserting that the response status is 302 (Redirect due to validation error)
        $response->assertStatus(302)->assertSessionHasErrors(['tahun_pelajaran', 'tingkat_kelas', 'nama_rombel', 'guru_id']);
    }

    // Clean up rombels after each test
    protected function tearDown(): void
    {
        // Delete all related records first
        AktivitasPendidikan::query()->delete();
        
        // Then delete the rombels
        Rombel::query()->delete();
        
        parent::tearDown();
    }
    
    
}
