<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $mapels = Mapel::all();
        return response()->json($mapels);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'rombel_id' => 'required|integer',
            'mata_pelajaran' => 'required|string|max:255',
        ]);

        $mapel = Mapel::create($request->all());
        return response()->json($mapel, 201);
    }

    // Display the specified resource
    public function show(Mapel $mapel)
    {
        return response()->json($mapel);
    }

    // Update the specified resource in storage
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'guru_id' => 'sometimes|required|exists:gurus,id',
            'rombel_id' => 'sometimes|required|integer',
            'mata_pelajaran' => 'sometimes|required|string|max:255',
        ]);

        $mapel->update($request->all());
        return response()->json($mapel);
    }

    // Remove the specified resource from storage
    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return response()->json(null, 204);
    }
}
