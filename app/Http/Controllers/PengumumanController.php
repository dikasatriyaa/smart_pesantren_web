<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PengumumanController extends Controller
{
    // Menampilkan daftar pengumuman
    public function index()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $pengumumen = Pengumuman::all();
        return view('pengumuman.index', compact('pengumumen'));
    }

    // Menampilkan form untuk membuat pengumuman baru
    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('pengumuman.create');
    }

    // Menyimpan pengumuman baru ke database
    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'pengumuman' => 'required|string|max:255',
            'editor' => 'required|string|max:255',
            'publish' => 'required|boolean',
        ]);

        Pengumuman::create($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit pengumuman
    public function edit(Pengumuman $pengumuman)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('pengumuman.edit', compact('pengumuman'));
    }

    // Memperbarui data pengumuman di database
    public function update(Request $request, Pengumuman $pengumuman)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'pengumuman' => 'required|string|max:255',
            'editor' => 'required|string|max:255',
            'publish' => 'required|boolean',
        ]);

        $pengumuman->update($request->all());

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }
}
