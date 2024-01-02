<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('user:id,name,profile_picture', 'jadwal')->get();

        return response()->json([
            'data' => $gurus,
            'success' => true
        ]);
    }

    public function show($id)
    {
        $guru = Guru::with('user')->where('id', $id)->first();

        return response()->json([
            'data' => $guru,
            'success' => true
        ]);
    }
}
