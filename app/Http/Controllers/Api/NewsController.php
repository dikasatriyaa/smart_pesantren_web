<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Menampilkan daftar berita
    public function index()
    {
        return News::all();
    }

    // Menampilkan berita tertentu berdasarkan id
    public function show(News $news)
    {
        return response()->json($news);
    }

    // Menampilkan form untuk membuat berita baru
    public function create()
    {
        return view('news.create');
    }

    // Menyimpan berita baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('menu_images', 'public');
        }

        News::create([
            'title' => $request->title,
            'images' => $imagePath, // Simpan path relatif dari direktori public
            'body' => $request->body,
            'author' => $request->author,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit berita
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    // Memperbarui data berita di database
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Boleh kosong atau diubah
            'body' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        try {
            if ($request->hasFile('images')) {
                $imageName = time() . '.' . $request->images->extension();
                $request->images->move(public_path('images'), $imageName);
                $news->images = '/images/' . $imageName; // Update path gambar jika ada perubahan
            }

            $news->title = $request->title;
            $news->body = $request->body;
            $news->author = $request->author;
            $news->save();

            return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui berita: ' . $e->getMessage());
        }
    }
}
