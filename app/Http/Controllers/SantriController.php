<?php
// app/Http/Controllers/SantriController.php

namespace App\Http\Controllers;

use App\Imports\SantrisImport;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class SantriController extends Controller
{
    public function download()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        Log::info('downloadTemplate method accessed.');

        $filePath = 'templates/santri_template.xlsx';

        if (!Storage::exists($filePath)) {
            Log::error('Template file not found.');
            return response()->view('errors.404', ['message' => 'Template file not found.'], 404);
        }

        return Storage::download($filePath, 'santri_template.xlsx');
    }


    public function upload(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new SantrisImport, $request->file('excel_file'));

            return response()->json([
                'status' => 'success',
                'message' => 'Data Santri berhasil diimport!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error during import: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengimport data. Silakan cek log untuk detailnya.',
            ], 500);
        }
    }
    
    public function index()
    {
        if(! Gate::allows('admin-or-guru')) {
            abort(403);
        }
        $santris = Santri::all();
        return view('santris.index', compact('santris'));
    }

    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('santris.create');
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'nisn' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'nik' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'anak_ke' => 'nullable|string',
            'hobi' => 'nullable|string',
            'nomor_kip' => 'nullable|string',
        ]);

        Santri::create($request->all());

        return redirect()->route('santri.index')
            ->with('success', 'Santri berhasil ditambahkan.');
    }

    // public function show(Santri $santri)
    // {
    //     return view('santris.show', compact('santri'));
    // }

    public function edit(Santri $santri)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('santris.edit', compact('santri'));
    }

    public function update(Request $request, Santri $santri)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string',
            'nisn' => 'nullable|string',
            'no_kk' => 'nullable|string',
            'nik' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'anak_ke' => 'nullable|string',
            'hobi' => 'nullable|string',
            'nomor_kip' => 'nullable|string',
        ]);

        $santri->update($request->all());

        return redirect()->route('santri.index')
            ->with('success', 'Santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $santri->delete();

        return redirect()->route('santri.index')
            ->with('success', 'Santri berhasil dihapus.');
    }
}
