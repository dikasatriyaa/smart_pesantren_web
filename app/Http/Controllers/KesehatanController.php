<?php

namespace App\Http\Controllers;

use App\Models\Kesehatan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class KesehatanController extends Controller
{
    // ... methods lain ...

    // Menampilkan daftar data kesehatan
    public function index()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $kesehatans = Kesehatan::all();
        return view('kesehatans.index', compact('kesehatans'));
    }

    // Menampilkan form untuk menambah data kesehatan
    public function create()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $santris = Santri::all();
        return view('kesehatans.create', compact('santris'));
    }

    // Menyimpan data kesehatan baru
    public function store(Request $request)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'dokter' => 'nullable|string',
            'obat_dikonsumsi' => 'nullable|string',
            'obat_dokter' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date',
        ]);

        Kesehatan::create($request->all());

        return redirect()->route('kesehatan.index')
            ->with('success', 'Kesehatan record created successfully.');
    }

    // Menampilkan data kesehatan tertentu
    // public function show(Kesehatan $kesehatan)
    // {
    //     return view('kesehatans.show', compact('kesehatan'));
    // }

    // Menampilkan form untuk mengedit data kesehatan
    public function edit(Kesehatan $kesehatan)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $santris = Santri::all();
        return view('kesehatans.edit', compact('kesehatan', 'santris'));
    }

    // Mengupdate data kesehatan yang sudah ada
    public function update(Request $request, Kesehatan $kesehatan)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'dokter' => 'nullable|string',
            'obat_dikonsumsi' => 'nullable|string',
            'obat_dokter' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date',
        ]);

        $kesehatan->update($request->all());

        return redirect()->route('kesehatan.index')
            ->with('success', 'Kesehatan record updated successfully');
    }

    // Menghapus data kesehatan
    public function destroy(Kesehatan $kesehatan)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $kesehatan->delete();

        return redirect()->route('kesehatan.index')
            ->with('success', 'Kesehatan record deleted successfully');
    }

    // Mengupdate waktu keluar saat sembuh
    public function sembuh($id)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $kesehatan = Kesehatan::find($id);
        if ($kesehatan) {
            $kesehatan->tanggal_keluar = now();
            $kesehatan->save();
            return response()->json(['success' => 'Kesehatan updated successfully']);
        } else {
            return response()->json(['error' => 'Kesehatan not found'], 404);
        }
    }
}
