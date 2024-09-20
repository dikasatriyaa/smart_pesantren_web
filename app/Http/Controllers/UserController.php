<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $santris = Santri::all();
        return view('users.create', compact('santris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'nullable|exists:santris,id',
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        try {
            User::create([
                'santri_id' => $request->santri_id,
                'name' => $request->name,
                'nik' => $request->nik,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        } catch (\Exception $e) {
            return redirect('/user')->with('error', 'Gagal menambahkan user. Silakan coba lagi.');
        }
    
        return redirect('/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $santris = Santri::all();
        return view('users.edit', compact('user', 'santris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'santri_id' => 'nullable|exists:santris,id',
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        try {
            $user = User::findOrFail($id);
            $user->santri_id = $request->santri_id;
            $user->name = $request->name;
            $user->nik = $request->nik;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->role = $request->role;
    
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            $user->save();
        } catch (\Exception $e) {
            return redirect('/user/' . $id . '/edit')->with('error', 'Gagal memperbarui user. Silakan coba lagi.');
        }
    
        return redirect('/user')->with('success', 'User berhasil diperbarui.');
    }
    public function logOut() {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
    
            return redirect('/user')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/user')->with('error', 'Gagal menghapus user. Silakan coba lagi.');
        }
    }
}
