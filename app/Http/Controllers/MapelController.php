<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::paginate(4);
        return view('mapel.index', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel' => 'required|min:3'
        ]);

        $mapel = Mapel::create([
            'mapel' => $request->mapel
        ]);

        if ($mapel) {
            return redirect('/mapel')->with(['success' => 'Mapel berhasil ditambahkan']);
        }

        return redirect('/mapel')->with(['failed' => 'Mapel gagal ditambahkan']);
    }

    public function destroy($id)
    {
        $mapel = Mapel::find($id);
        if (!$mapel) {
            return redirect('/mapel')->with(['failed' => 'Mapel tidak ditemukan']);
        }
        $mapel->delete();
        return redirect('/mapel')->with(['success' => 'Mapel berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mapel' => 'required|min:3'
        ]);

        $mapel = Mapel::find($id);

        if (!$mapel) {
            return redirect('/mapel')->with(['failed' => 'Mapel tidak ditemukan']);
        }

        $mapel->update([
            'mapel' => $request->mapel
        ]);

        return redirect('/mapel')->with(['success' => 'Mapel berhasil diupdate']);
    }
}
