<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => '2']); // Admin

        // Mengatur Gate untuk memungkinkan akses untuk admin
        Gate::define('admin', function ($user) {
            return true;
        });
    }

    /** @test */
    public function admin_can_view_menu_index()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $response->assertViewIs('menus.index');
    }

    /** @test */
    public function admin_can_create_menu()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('menu.create'));

        $response->assertStatus(200);
        $response->assertViewIs('menus.create');
    }

    /** @test */
    public function test_admin_can_store_menu()
    {
        $this->actingAsAdmin();
        Storage::fake('public');
    
        $response = $this->post(route('menu.store'), [
            'name' => 'Test Menu',
            'images' => UploadedFile::fake()->image('test.jpg'),
            'link' => 'https://example.com',
        ]);
    
        $response->assertRedirect(route('menu.index'));
        $response->assertSessionHas('success', 'Menu berhasil ditambahkan.');
    
        $this->assertDatabaseHas('menus', [
            'name' => 'Test Menu',
            'link' => 'https://example.com',
        ]);
    
        // Periksa apakah file baru ada dengan mencari path yang dihasilkan oleh Laravel
        $menu = Menu::where('name', 'Test Menu')->first();
        $imagePath = $menu->images; // Mengambil path gambar dari model
        $this->assertTrue(Storage::disk('public')->exists($imagePath), 'Gambar tidak ditemukan di penyimpanan.');
    }
    

    /** @test */
    public function admin_can_edit_menu()
    {
        $this->actingAsAdmin();
        $menu = Menu::factory()->create();

        $response = $this->get(route('menu.edit', $menu->id));

        $response->assertStatus(200);
        $response->assertViewIs('menus.edit');
        $response->assertViewHas('menu', $menu);
    }

    /** @test */
    public function test_admin_can_update_menu()
    {
        Storage::fake('public');

        // Create a dummy menu with an existing image
        $oldImagePath = 'menu_images/old_image.jpg';
        $menu = Menu::factory()->create([
            'images' => $oldImagePath,
        ]);

        // Create a new dummy image to be uploaded
        $newImage = UploadedFile::fake()->image('new_image.jpg');

        // Perform the update request
        $response = $this->actingAs($this->admin)->put(route('menu.update', $menu->id), [
            'name' => 'Updated Menu',
            'images' => $newImage,
            'link' => 'http://example.com',
        ]);

        // Check if the new image file exists by getting the file path from storage
        $newImagePath = 'menu_images/' . $newImage->hashName();
        $newImageExists = Storage::disk('public')->exists($newImagePath);
        $this->assertTrue($newImageExists, 'New image was not stored in the public disk');

        // Check if the old image file still exists by getting the file path from storage
        $oldImageExists = Storage::disk('public')->exists($oldImagePath);
        $this->assertFalse($oldImageExists, 'Old image was not deleted from the public disk');

        // Assert that the menu was updated in the database
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'Updated Menu',
            'images' => $newImagePath,
            'link' => 'http://example.com',
        ]);

        // Assert the response status and redirect
        $response->assertStatus(302);
        $response->assertRedirect(route('menu.index'));
    }

    private function actingAsAdmin()
    {
        // Membuat user admin dan mengatur sebagai user yang sedang login
        $admin = User::factory()->create();
        $this->actingAs($admin);

        // Mengatur Gate untuk memungkinkan akses untuk admin
        Gate::define('admin', function ($user) use ($admin) {
            return $user->id === $admin->id;
        });
    }
}
