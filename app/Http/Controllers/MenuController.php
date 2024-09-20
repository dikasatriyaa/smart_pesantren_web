<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Menampilkan daftar menu
    public function index()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    // Menampilkan form untuk membuat menu baru
    public function create()
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('menus.create');
    }

    // Menyimpan menu baru ke database
    public function store(Request $request)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('menu_images', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'images' => $imagePath,
            'link' => $request->link,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit menu
    public function edit(Menu $menu)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        return view('menus.edit', compact('menu'));
    }

    // Memperbarui data menu di database
    public function update(Request $request, Menu $menu)
    {
        if(! Gate::allows('admin')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('images')) {
            // Hapus gambar lama jika ada
            if ($menu->images && Storage::disk('public')->exists($menu->images)) {
                Storage::disk('public')->delete($menu->images);
            }

            $imagePath = $request->file('images')->store('menu_images', 'public');
            $menu->images = $imagePath;
        }

        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }
}
