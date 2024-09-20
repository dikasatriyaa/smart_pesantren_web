<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MapelController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $mapels = Mapel::all();
        return view('mapels.index', compact('mapels'));
    }

    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $gurus = Guru::all(); // Assuming 'guru' is the role for teachers
        $rombels = Rombel::all(); // Assuming Rombel model is used
        return view('mapels.create', compact('gurus', 'rombels'));
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'guru_id' => 'required',
            'rombel_id' => 'required|integer',
            'mata_pelajaran' => 'required|string',
        ]);

        Mapel::create($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mapel created successfully.');
    }

    // public function show(Mapel $mapel)
    // {
    //     if(! Gate::allows('admin')) {
    //         abort(403);
    //     }
    //     return view('mapels.show', compact('mapel'));
    // }

    public function edit($id)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $gurus = Guru::all();
        $mapel = Mapel::find($id);
        $rombels = Rombel::all();
        return view('mapels.edit', compact('gurus','mapel','rombels'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'rombel_id' => 'required|integer',
            'mata_pelajaran' => 'nullable|string',
        ]);

        $mapel->update($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mapel updated successfully');
    }

    public function destroy(Mapel $mapel)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $mapel->delete();

        return redirect()->route('mapel.index')
            ->with('success', 'Mapel deleted successfully');
    }
}
