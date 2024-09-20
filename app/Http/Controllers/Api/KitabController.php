<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kitab;
use Illuminate\Http\Request;

class KitabController extends Controller
{
    public function index()
    {
        $kitabs = Kitab::all();
        return response()->json($kitabs);
    }

    public function show(Kitab $kitab)
    {
        return response()->json($kitab);
    }

    public function store(Request $request)
    {
        $kitab = Kitab::create($request->all());
        return response()->json($kitab, 201);
    }

    public function update(Request $request, Kitab $kitab)
    {
        $kitab->update($request->all());
        return response()->json($kitab);
    }

    public function destroy(Kitab $kitab)
    {
        $kitab->delete();
        return response()->json(null, 204);
    }
}
