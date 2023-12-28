<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function show($id)
    {
        $siswa = Siswa::with('user')->where('id', $id)->first();

        return response()->json([
            'data' => $siswa
        ]);
    }

    public function index()
    {
        $siswa = Siswa::paginate(4);
        return response()->json([
            'data' => $siswa
        ]);
    }
}
