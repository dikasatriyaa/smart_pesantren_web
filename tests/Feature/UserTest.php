<?php

namespace Tests\Feature;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat pengguna uji menggunakan factory
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_index_page()
    {
        // Autentikasi pengguna uji
        $response = $this->actingAs($this->user)->get('/user');

        // Memeriksa status respons
        $response->assertStatus(200);
    }

    /** @test */
    public function test_user_index_page()
    {
        // Autentikasi pengguna uji
        $response = $this->actingAs($this->user)->get('/user');

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function test_create_user_page()
    {
        // Autentikasi pengguna uji
        $response = $this->actingAs($this->user)->get('/user/create');

        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    /** @test */
    public function test_store_user()
    {
        // Autentikasi pengguna uji
        $this->actingAs($this->user);

        $santri = Santri::factory()->create();

        $response = $this->post('/user', [
            'santri_id' => $santri->id,
            'name' => 'Test User',
            'nik' => '123456789',
            'email' => 'test@example.com',
            'phone_number' => '08123456789',
            'role' => 'Admin',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/user');
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function test_edit_user_page()
    {
        // Autentikasi pengguna uji
        $this->actingAs($this->user);

        $user = User::factory()->create();

        $response = $this->get("/user/{$user->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
    }

    /** @test */
    public function test_update_user()
    {
        // Autentikasi pengguna uji
        $this->actingAs($this->user);

        $user = User::factory()->create();

        $response = $this->put("/user/{$user->id}", [
            'santri_id' => $user->santri_id,
            'name' => 'Updated User',
            'nik' => $user->nik,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'role' => $user->role,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect('/user');
        $this->assertDatabaseHas('users', [
            'name' => 'Updated User',
        ]);
    }

    /** @test */
    public function test_delete_user()
    {
        // Autentikasi pengguna uji
        $this->actingAs($this->user);

        $user = User::factory()->create();

        $response = $this->delete("/user/{$user->id}");

        $response->assertRedirect('/user');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_store_user_validation_fails()
{
    // Autentikasi pengguna uji
    $this->actingAs($this->user);

    $response = $this->post('/user', []);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
}

/** @test */
public function test_update_user_validation_fails()
{
    // Autentikasi pengguna uji
    $this->actingAs($this->user);

    $user = User::factory()->create();

    $response = $this->put("/user/{$user->id}", [
        'name' => '',
        'email' => 'invalid-email',
        // Tambahkan field lain yang tidak valid
    ]);

    $response->assertSessionHasErrors(['name', 'email']);
}

/** @test */
public function test_delete_user_not_found()
{
    // Autentikasi pengguna uji
    $this->actingAs($this->user);

    $response = $this->delete("/user/999"); // ID yang tidak ada

    $response->assertStatus(302);
}

/** @test */
public function test_store_user_duplicate_email()
{
    // Autentikasi pengguna uji
    $this->actingAs($this->user);

    $existingUser = User::factory()->create(['email' => 'existing@example.com']);

    $response = $this->post('/user', [
        'name' => 'New User',
        'email' => 'existing@example.com',
        // Isi field lain sesuai kebutuhan
    ]);

    $response->assertSessionHasErrors(['email']);
}




}
