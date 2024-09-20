<?php

namespace App\Http\Controllers;

use App\Models\Akademik;
use App\Models\AktivitasPendidikan;
use App\Models\Mapel;
use App\Models\Santri;
use App\Models\Rombel; // Model Rombel, jika ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AkademikController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $akademiks = Akademik::all();
        return view('akademiks.index', compact('akademiks'));
    }

    public function create()
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $mapels = Mapel::all(); // Mendapatkan semua data mata pelajaran
        $rombels = Rombel::all(); // Mendapatkan semua data kelas
        return view('akademiks.create', compact('mapels', 'rombels'));
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $request->validate([
            'mapel_id' => 'required|exists:mapels,id',
            'tahun_pelajaran' => 'required|string',
            'nilai' => 'required|array',
            'santri_id' => 'required|array',
            'nilai.*' => 'required|string',
            'santri_id.*' => 'required|exists:santris,id',
        ]);

        // Looping untuk menyimpan nilai akademik untuk setiap santri yang dipilih
        foreach ($request->santri_id as $key => $santri_id) {
            if (!empty($request->nilai[$key])) {
                Akademik::create([
                    'santri_id' => $santri_id,
                    'mapel_id' => $request->mapel_id,
                    'tahun_pelajaran' => $request->tahun_pelajaran,
                    'nilai' => $request->nilai[$key],
                ]);
            }
        }

        return redirect()->route('akademik.index')
            ->with('success', 'Data akademik berhasil ditambahkan.');
    }

    // public function show(Akademik $akademik)
    // {
    //     return view('akademiks.show', compact('akademik'));
    // }

    public function edit(Akademik $akademik)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        return view('akademiks.edit', compact('akademik'));
    }

    public function update(Request $request, Akademik $akademik)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'mapel_id' => 'required|exists:mapels,id',
            'tahun_pelajaran' => 'required|string',
            'nilai' => 'required|string',
        ]);

        $akademik->update($request->all());

        return redirect()->route('akademik.index')
            ->with('success', 'Akademik record updated successfully');
    }

    public function destroy(Akademik $akademik)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $akademik->delete();

        return redirect()->route('akademik.index')
            ->with('success', 'Akademik record deleted successfully');
    }

    public function getSantris(Request $request)
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $rombel_id = $request->input('rombel_id');
        $mapel_id = $request->input('mapel_id');
        $tahun_pelajaran = $request->input('tahun_pelajaran');
    
        // Mendapatkan santri yang terkait dengan rombel_id dari tabel AktivitasPendidikan
        $santris = AktivitasPendidikan::where('rombel_id', $rombel_id)
            ->with('santri') // Mengaitkan model Santri
            ->get()
            ->pluck('santri'); // Mengambil koleksi santri
    
        // Mengecek apakah santri sudah ada di tabel Akademik dengan mapel_id dan tahun_pelajaran yang sama
        $existingSantris = Akademik::where('mapel_id', $mapel_id)
            ->where('tahun_pelajaran', $tahun_pelajaran)
            ->pluck('santri_id');
    
        // Filter santri yang tidak ada di daftar existingSantris
        $santris = $santris->filter(function ($santri) use ($existingSantris) {
            return !$existingSantris->contains($santri->id);
        });
    
        // Mengembalikan data santri dalam format JSON
        return response()->json($santris);
    }
    
}
