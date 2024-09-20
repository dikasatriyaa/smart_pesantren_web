<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        return Pengumuman::all()->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengumuman' => 'required|string',
            'editor' => 'required|string',
            'publish' => 'required|string',
        ]);

        return Pengumuman::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $request->validate([
            'pengumuman' => 'required|string',
            'editor' => 'required|string',
            'publish' => 'required|string',
        ]);

        $pengumuman->update($request->all());

        return $pengumuman;
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return response()->json(['message' => 'Pengumuman deleted successfully']);
    }
}
