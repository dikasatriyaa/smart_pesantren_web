<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPendidikan;
use App\Models\Kehadiran;
use App\Models\Rombel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class KehadiranController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $kehadirans = Kehadiran::all();
        return view('kehadirans.index', compact('kehadirans'));
    }

    public function create()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $rombels = Rombel::all();
        return view('kehadirans.create', compact('rombels'));
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $tanggal = $request->input('tanggal');

        foreach ($request->input('santris') as $santriKehadiran) {
            Kehadiran::create([
                'santri_id' => $santriKehadiran['santri_id'],
                'status' => $santriKehadiran['status'],
                'masuk' => $santriKehadiran['masuk'],
                'tanggal' => $tanggal,
            ]);
        }

        return redirect('/kehadiran')->with('success', 'Data kehadiran berhasil ditambahkan.');
    }

    public function show(Kehadiran $kehadiran)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        return view('kehadirans.show', compact('kehadiran'));
    }

    public function edit(Kehadiran $kehadiran)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        return view('kehadirans.edit', compact('kehadiran'));
    }

    public function update(Request $request, Kehadiran $kehadiran)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'masuk' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $kehadiran->update($request->all());

        return redirect()->route('kehadiran.index')
            ->with('success', 'Kehadiran updated successfully');
    }

    public function destroy(Kehadiran $kehadiran)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $kehadiran->delete();

        return redirect()->route('kehadiran.index')
            ->with('success', 'Kehadiran deleted successfully');
    }

    public function santrisByRombel($rombelId, Request $request)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $tanggal = $request->query('tanggal');
    
        // Ambil semua kehadiran pada tanggal tertentu
        $kehadiran = Kehadiran::where('tanggal', $tanggal)->pluck('santri_id')->toArray();
    
        // Ambil santri yang terkait dengan rombel dan tidak termasuk dalam kehadiran pada tanggal tersebut
        $santris = AktivitasPendidikan::where('rombel_id', $rombelId)
            ->whereNotIn('santri_id', $kehadiran)
            ->with('santri')
            ->get()
            ->pluck('santri');
    
        return response()->json(['santris' => $santris]);
    }
    
}
