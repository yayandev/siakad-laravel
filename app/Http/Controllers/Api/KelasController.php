<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::paginate(4);

        return response()->json([
            'data' => $kelas,
            'success' => true
        ]);
    }

    public function show($id)
    {
        $kelas = Kelas::where('id', $id)->with('walikelas', 'siswa')->first();

        return response()->json([
            'data' => $kelas,
        ]);
    }
}
