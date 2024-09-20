<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PelanggaranController extends Controller
{
    // Menampilkan daftar pelanggaran
    public function index()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $pelanggarans = Pelanggaran::with('santri')->get();
        return view('pelanggaran.index', compact('pelanggarans'));
    }

    // Menampilkan form untuk membuat pelanggaran baru
    public function create()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $santris = Santri::all();
        return view('pelanggaran.create', compact('santris'));
    }

    // Menyimpan pelanggaran baru ke database
    public function store(Request $request)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'pelanggaran' => 'required|string|max:255',
            'tindakan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        Pelanggaran::create($request->all());

        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit pelanggaran
    public function edit(Pelanggaran $pelanggaran)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $santris = Santri::all();
        return view('pelanggaran.edit', compact('pelanggaran', 'santris'));
    }

    // Memperbarui data pelanggaran di database
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'pelanggaran' => 'required|string|max:255',
            'tindakan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $pelanggaran->update($request->all());

        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        if (!Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $pelanggaran->delete();

        return redirect()->route('pelanggaran.index')->with('success', 'Pelanggaran berhasil dihapus.');
    }
}
