<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Additional setup code
    }

    /** @test */
    public function admin_can_store_news()
    {
        $this->actingAsAdmin();
        Storage::fake('public');

        $response = $this->post(route('news.store'), [
            'title' => 'Test News',
            'images' => UploadedFile::fake()->image('test.jpg'),
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'author' => 'Admin',
        ]);

        $response->assertRedirect(route('news.index'));
        $response->assertSessionHas('success', 'Berita berhasil ditambahkan.');

        $this->assertDatabaseHas('news', [
            'title' => 'Test News',
            'author' => 'Admin',
        ]);

        // Check if image file exists in storage
        $news = News::where('title', 'Test News')->first();
        $imagePath = $news->images;
        $this->assertTrue(Storage::disk('public')->exists($imagePath), 'Gambar tidak ditemukan di penyimpanan.');
    }

    /** @test */
    public function admin_can_update_news()
    {
        $this->actingAsAdmin();
        Storage::fake('public');

        $news = News::factory()->create();

        $response = $this->put(route('news.update', $news->id), [
            'title' => 'Updated Title',
            'images' => UploadedFile::fake()->image('updated.jpg'),
            'body' => 'Updated body content.',
            'author' => 'Admin',
        ]);

        $response->assertRedirect(route('news.index'));
        $response->assertSessionHas('success', 'Berita berhasil diperbarui.');

        // Refresh model instance
        $news->refresh();

        $this->assertEquals('Updated Title', $news->title);
        $this->assertEquals('Admin', $news->author);

        // Check if new image file exists in storage
        $imagePath = $news->images;
        $this->assertTrue(Storage::disk('public')->exists($imagePath), 'Gambar tidak ditemukan di penyimpanan.');
    }

    /** @test */
/** @test */
public function admin_can_delete_news()
{
    // Authenticate as admin
    $this->actingAsAdmin();

    Storage::fake('public');

    // Create a news item
    $news = News::factory()->create();

    // Send delete request
    $response = $this->delete(route('news.destroy', $news->id));

    // Check if delete was successful
    $response->assertRedirect(route('news.index'));
    $response->assertSessionHas('success', 'Berita berhasil dihapus.');

    // Ensure the news item is no longer in the database
    $this->assertDatabaseMissing('news', ['id' => $news->id]);

    // Check if image file is deleted from storage
    $imagePath = $news->images;
    $this->assertFalse(Storage::disk('public')->exists($imagePath), 'Gambar masih ada di penyimpanan setelah dihapus.');
}

protected function actingAsAdmin()
{
    // Create an admin user and authenticate
    $admin = User::factory()->create(['role' => '2']); // Adjust based on your User model and role setup
    $this->actingAs($admin);
}

}

