<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('guru', 'mapel', 'kelas')->get();
        return response()->json([
            'data' => $jadwals,
            'success' => true
        ]);
    }

    public function show(Jadwal $jadwal)
    {
        $jadwal->load('guru', 'mapel', 'kelas');
        return response()->json([
            'data' => $jadwal,
            'success' => true
        ]);
    }
}
