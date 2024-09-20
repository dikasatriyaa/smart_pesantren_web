<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPendidikan;
use App\Models\Rombel;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AktivitasPendidikanController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $aktivitas = AktivitasPendidikan::all();
        return view('aktivitas.index', compact('aktivitas'));
    }

    public function create()
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $santris = Santri::all();
        $rombels = Rombel::all(); // Mendapatkan semua data rombel
        return view('aktivitas.create', compact('santris', 'rombels'));
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'rombel_id' => 'required|integer',
            'tahun_pelajaran' => 'required|string',
        ]);

        AktivitasPendidikan::create($request->all());

        return redirect()->route('aktivitas.index')
            ->with('success', 'Aktivitas pendidikan created successfully.');
    }

    // public function show(AktivitasPendidikan $aktivitas)
    // {
    //     return view('aktivitas.show', compact('aktivitas'));
    // }

    public function edit(AktivitasPendidikan $aktivitas)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $santris = Santri::all();
        $rombels = Rombel::all();
        return view('aktivitas.edit', compact('aktivitas', 'santris', 'rombels'));
    }

    public function update(Request $request, AktivitasPendidikan $aktivitas)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'rombel_id' => 'required|integer',
            'tahun_pelajaran' => 'required|string',
        ]);

        $aktivitas->update($request->all());

        return redirect()->route('aktivitas.index')
            ->with('success', 'Aktivitas pendidikan updated successfully');
    }

    public function destroy(AktivitasPendidikan $aktivitas)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')
            ->with('success', 'Aktivitas pendidikan deleted successfully');
    }
}
