<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Hafalan;
use App\Models\Rombel;
use App\Models\Santri;
use App\Models\AktivitasPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HafalanController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $hafalans = Hafalan::all();
        return view('hafalans.index', compact('hafalans'));
    }

    public function create()
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $rombel = Rombel::all(); // Mendapatkan semua kelas
        $gurus = Guru::all();
        return view('hafalans.create', compact('rombel', 'gurus'));
    }

    public function getSantri(Request $request)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $rombel_id = $request->input('rombel_id');
    
        if (!$rombel_id) {
            return response()->json([], 400); // Bad Request jika rombel_id tidak ada
        }
    
        $santris = AktivitasPendidikan::where('rombel_id', $rombel_id)
            ->with('santri')
            ->get()
            ->pluck('santri');
    
        return response()->json($santris);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
    
        // Validasi input dari request
        $request->validate([
            'santri_id.*' => 'required|exists:santris,id',
            'guru_id' => 'required|exists:gurus,id',
            'juz.*' => 'required|string',
            'progres.*' => 'nullable|string',
            'catatan.*' => 'nullable|string',
        ]);
    
        try {
            // Looping untuk menyimpan data hafalan untuk setiap santri
            foreach ($request->santri_id as $key => $santri_id) {
                Hafalan::create([
                    'santri_id' => $santri_id,
                    'guru_id' => $request->guru_id,
                    'juz' => $request->juz[$key] ?? null, // Menggunakan null jika tidak ada nilai
                    'progres' => $request->progres[$key] ?? null, // Menggunakan null jika tidak ada nilai
                    'catatan' => $request->catatan[$key] ?? null, // Menggunakan null jika tidak ada nilai
                ]);
            }
    
            // Redirect dengan pesan sukses jika semua data berhasil ditambahkan
            return redirect()->route('hafalan.index')
                ->with('success', 'Data hafalan berhasil ditambahkan.');
    
        } catch (\Exception $e) {
            // Mengarahkan kembali dengan pesan error jika terjadi pengecualian
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput(); // Menyimpan input yang telah diisi sebelumnya
        }
    }
    

    // public function show(Hafalan $hafalan)
    // {
    //     if(! Gate::allows('admin-or-wali-asrama')) {
    //         abort(403);
    //     }
    //     return view('hafalans.show', compact('hafalan'));
    // }

    public function edit(Hafalan $hafalan)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        return view('hafalans.edit', compact('hafalan'));
    }

    public function update(Request $request, Hafalan $hafalan)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'guru_id' => 'required|exists:gurus,id',
            'juz' => 'nullable|string',
            'progres' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $hafalan->update($request->all());

        return redirect()->route('hafalan.index')
            ->with('success', 'Hafalan updated successfully');
    }

    public function destroy(Hafalan $hafalan)
    {
        if(! Gate::allows('admin-or-wali-asrama')) {
            abort(403);
        }
        $hafalan->delete();

        return redirect()->route('hafalan.index')
            ->with('success', 'Hafalan deleted successfully');
    }
}
