<?php

namespace App\Http\Controllers;

use App\Models\Kitab;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class KitabController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $kitabs = Kitab::all();
        return view('kitabs.index', compact('kitabs'));
    }

    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $rombels = Rombel::all();
        return view('kitabs.create', compact('rombels'));
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'mata_pelajaran' => 'required|string',
            'nama_kitab' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Kitab::create($request->all());

        return redirect()->route('kitab.index')
            ->with('success', 'Data kitab berhasil ditambahkan.');
    }

    public function show(Kitab $kitab)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('kitabs.show', compact('kitab'));
    }

    public function edit(Kitab $kitab)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $rombels = Rombel::all();
        return view('kitabs.edit', compact('kitab', 'rombels'));
    }

    public function update(Request $request, Kitab $kitab)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'mata_pelajaran' => 'nullable|string',
            'nama_kitab' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $kitab->update($request->all());

        return redirect()->route('kitab.index')
            ->with('success', 'Data kitab berhasil diperbarui.');
    }

    public function destroy(Kitab $kitab)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $kitab->delete();

        return redirect()->route('kitab.index')
            ->with('success', 'Data kitab berhasil dihapus.');
    }
}
