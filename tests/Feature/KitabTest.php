<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kitab;
use App\Models\Rombel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KitabControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['role' => '2']);
    }

    public function test_admin_can_access_kitab_index()
    {
        $this->actingAs($this->adminUser);

        $response = $this->get(route('kitab.index'));

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_kitab_index()
    {
        $user = User::factory()->create(['role' => '1']);

        $response = $this->actingAs($user)->get(route('kitab.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_kitab()
    {
        $rombel = Rombel::factory()->create();

        $data = [
            'rombel_id' => $rombel->id,
            'mata_pelajaran' => 'Matematika',
            'nama_kitab' => 'Aljabar',
            'keterangan' => 'Kitab dasar aljabar',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('kitab.store'), $data);

        $response->assertRedirect(route('kitab.index'));

        $this->assertDatabaseHas('kitabs', $data);
    }

    public function test_admin_can_edit_kitab()
    {
        $kitab = Kitab::factory()->create();

        $updateData = [
            'rombel_id' => $kitab->rombel_id,
            'mata_pelajaran' => 'Fisika',
            'nama_kitab' => 'Mekanika',
            'keterangan' => 'Kitab dasar mekanika',
        ];

        $response = $this->actingAs($this->adminUser)->put(route('kitab.update', $kitab->id), $updateData);

        $response->assertRedirect(route('kitab.index'));

        $this->assertDatabaseHas('kitabs', $updateData);
    }

    public function test_admin_can_delete_kitab()
    {
        $kitab = Kitab::factory()->create();

        $response = $this->actingAs($this->adminUser)->delete(route('kitab.destroy', $kitab->id));

        $response->assertRedirect(route('kitab.index'));

        $this->assertDatabaseMissing('kitabs', ['id' => $kitab->id]);
    }
}
