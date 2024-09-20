<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Santri;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    // Method to get all violations for a specific student
    public function index(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);
        
        $pelanggarans = Pelanggaran::where('santri_id', $santri->id)
                                   ->orderBy('tanggal', 'desc')
                                   ->get();
                                   
        return response()->json($pelanggarans);
    }

    // Method to get a specific violation
    public function show(Santri $santri, Pelanggaran $pelanggaran)
    {
        $this->authorizeSantriAccess($santri);
        
        if ($pelanggaran->santri_id != $santri->id) {
            abort(403, 'Unauthorized');
        }
        
        return response()->json($pelanggaran);
    }

    // Method to store a new violation
    public function store(Request $request, Santri $santri)
    {
        $this->authorizeSantriAccess($santri);

        $request->validate([
            'pelanggaran' => 'required|string|max:255',
            'tindakan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $pelanggaran = Pelanggaran::create([
            'santri_id' => $santri->id,
            'pelanggaran' => $request->pelanggaran,
            'tindakan' => $request->tindakan,
            'tanggal' => $request->tanggal,
        ]);

        return response()->json($pelanggaran, 201);
    }

    // Method to update a specific violation
    public function update(Request $request, Santri $santri, Pelanggaran $pelanggaran)
    {
        $this->authorizeSantriAccess($santri);

        if ($pelanggaran->santri_id != $santri->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'pelanggaran' => 'required|string|max:255',
            'tindakan' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        $pelanggaran->update($request->all());

        return response()->json($pelanggaran);
    }

    // Method to delete a specific violation
    public function destroy(Santri $santri, Pelanggaran $pelanggaran)
    {
        $this->authorizeSantriAccess($santri);

        if ($pelanggaran->santri_id != $santri->id) {
            abort(403, 'Unauthorized');
        }

        $pelanggaran->delete();

        return response()->json(['message' => 'Pelanggaran deleted successfully']);
    }

    // Method to authorize the access for a specific student
    private function authorizeSantriAccess(Santri $santri)
    {
        if (auth()->user()->santri_id != $santri->id) {
            abort(403, 'Unauthorized');
        }
    }
}
