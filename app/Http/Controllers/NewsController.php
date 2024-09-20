<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // Menampilkan daftar berita
    public function index()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $news = News::all();
        return view('news.index', compact('news'));
    }

    // Menampilkan form untuk membuat berita baru
    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('news.create');
    }

    // Menyimpan berita baru ke database
    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'required|image|max:2048', // Validasi untuk tipe dan ukuran gambar
            'body' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        $imagePath = $this->storeImage($request);

        News::create([
            'title' => $request->title,
            'images' => $imagePath,
            'body' => $request->body,
            'author' => $request->author,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit berita
    public function edit(News $news)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('news.edit', compact('news'));
    }

    // Memperbarui data berita di database
    public function update(Request $request, News $news)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'sometimes|image|max:2048',
            'body' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        $data = $request->all();

        if ($request->hasFile('images')) {
            // Hapus gambar lama
            if ($news->images) {
                Storage::disk('public')->delete($news->images);
            }
            $data['images'] = $this->storeImage($request);
        }

        $news->update($data);

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    // Menghapus berita dari database
    public function destroy(News $news)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        // Hapus gambar terkait
        if ($news->images) {
            Storage::disk('public')->delete($news->images);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }

    // Metode untuk menyimpan gambar
    private function storeImage($request)
    {
        if ($request->hasFile('images')) {
            return $request->file('images')->store('menu_images', 'public');
        }
        return null;
    }
}
