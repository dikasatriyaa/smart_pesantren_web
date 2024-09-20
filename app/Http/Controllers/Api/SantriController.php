<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Kehadiran;
use App\Models\Kesehatan;
use App\Models\Akademik;
use App\Models\Hafalan;
use App\Models\Kitab;
use App\Models\Menu;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function show(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);
        return response()->json($santri);
    }

    public function kehadiran(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);

        // Ambil tanggal saat ini
        $today = now()->format('Y-m-d');

        // Ambil data kehadiran berdasarkan santri_id dan tanggal saat ini
        $kehadiran = Kehadiran::where('santri_id', $santri->id)
                              ->whereDate('tanggal', $today)
                              ->first();

        return response()->json($kehadiran);
    }

    public function semuaKehadiran(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);

        // Ambil semua data kehadiran berdasarkan santri_id dan urutkan berdasarkan tanggal dari terbaru ke terlama
        $kehadiran = Kehadiran::where('santri_id', $santri->id)
                              ->orderBy('tanggal', 'desc')
                              ->get();

        return response()->json($kehadiran);
    }

    public function kesehatan(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);
        return response()->json($santri->kesehatans);
    }

    public function akademik(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);
        $akademiks = $santri->akademiks()->with('mapel.guru.user')->get();

        return response()->json($akademiks);
    }

    public function hafalan(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);
        return response()->json($santri->hafalans);
    }

    public function kitab(Santri $santri)
    {
        $this->authorizeSantriAccess($santri);
        return response()->json($santri->kitabs);
    }

    public function menu()
    {
        $menu = Menu::all();
        return response()->json($menu);
    }

    private function authorizeSantriAccess(Santri $santri)
    {
        if (auth()->user()->santri_id != $santri->id) {
            abort(403, 'Unauthorized');
        }
    }
}
