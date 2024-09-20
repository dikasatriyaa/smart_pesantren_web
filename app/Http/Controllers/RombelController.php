<?php
// app/Http/Controllers/RombelController.php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RombelController extends Controller
{
    public function index()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('login')->withErrors('Unauthorized access. Please login with admin privileges.');
        }
        $rombels = Rombel::with('guru')->get();
        return view('rombels.index', compact('rombels'));
    }

    public function create()
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('login')->withErrors('Unauthorized access. Please login with admin privileges.');
        }
        $gurus = Guru::all();
        return view('rombels.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('login')->withErrors('Unauthorized access. Please login with admin privileges.');
        }
        $validatedData = $request->validate([
            'tahun_pelajaran' => 'required',
            'tingkat_kelas' => 'required',
            'nama_rombel' => 'required',
            'guru_id' => 'required',
        ]);

        Rombel::create($validatedData);

        return redirect()->route('rombel.index')->with('success', 'Rombel created successfully.');
    }

    public function edit($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('login')->withErrors('Unauthorized access. Please login with admin privileges.');
        }
        $rombel = Rombel::find($id);
        if (!$rombel) {
            return redirect()->route('rombel.index')->withErrors('Rombel not found.');
        }
        $gurus = Guru::all();
        return view('rombels.edit', compact('rombel', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('login')->withErrors('Unauthorized access. Please login with admin privileges.');
        }
        $validatedData = $request->validate([
            'tahun_pelajaran' => 'required',
            'tingkat_kelas' => 'required',
            'nama_rombel' => 'required',
            'guru_id' => 'required',
        ]);

        $rombel = Rombel::find($id);
        if (!$rombel) {
            return redirect()->route('rombel.index')->withErrors('Rombel not found.');
        }
        $rombel->update($validatedData);

        return redirect()->route('rombel.index')->with('success', 'Rombel updated successfully.');
    }

    public function destroy($id)
    {
        if (!Gate::allows('admin')) {
            return redirect()->route('login')->withErrors('Unauthorized access. Please login with admin privileges.');
        }
        $rombel = Rombel::find($id);
        if (!$rombel) {
            return redirect()->route('rombel.index')->withErrors('Rombel not found.');
        }
        $rombel->delete();

        return redirect()->route('rombel.index')->with('success', 'Rombel deleted successfully.');
    }
}
