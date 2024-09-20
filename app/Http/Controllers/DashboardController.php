<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPendidikan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        if(! Gate::allows('all')) {
            abort(403);
        }
        $data = [
            'santri' => AktivitasPendidikan::latest()->take(5)->get(),
            'count' => Santri::count(),
            'putra' => Santri::where('jenis_kelamin', 'Laki-laki')->count(),
            'putri' => Santri::where('jenis_kelamin', 'Perempuan')->count(),
        ];
    
        return view('page.home', $data);
    }
}
