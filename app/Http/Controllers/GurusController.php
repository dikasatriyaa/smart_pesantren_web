<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GurusController extends Controller
{
    public function index()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $gurus = Guru::all();
        return view('gurus.index', compact('gurus'));
    }

    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $users = User::where('role',"1")->get();
        return view('gurus.create', compact('users'));
    }

    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'status_pegawai' => 'nullable|string',
            'npk' => 'nullable|string',
            'tmt_pegawai' => 'nullable|string',
            'npwp' => 'nullable|string',
        ]);

        Guru::create($request->all());

        return redirect()->route('guru.index')
            ->with('success', 'Guru record created successfully.');
    }

    public function show(Guru $guru)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $users = User::all();
        return view('gurus.edit', compact('guru', 'users'));
    }

    public function update(Request $request, Guru $guru)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'status_pegawai' => 'nullable|string',
            'npk' => 'nullable|string',
            'tmt_pegawai' => 'nullable|string',
            'npwp' => 'nullable|string',
        ]);

        $guru->update($request->all());

        return redirect()->route('guru.index')
            ->with('success', 'Guru record updated successfully.');
    }

    public function destroy(Guru $guru)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Guru record deleted successfully.');
    }
}
