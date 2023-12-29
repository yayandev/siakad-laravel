<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $tahun_akademiks = TahunAkademik::where('tahun_akademik', 'like', '%' . $request->search . '%')->paginate(4);
            return view('tahun_akademik.index', compact('tahun_akademiks'));
        }
        $tahun_akademiks = TahunAkademik::paginate(4);
        return view('tahun_akademik.index', compact('tahun_akademiks'));
    }

    public function destroy($id)
    {
        $tahun_akademik = TahunAkademik::find($id);

        if (!$tahun_akademik) {
            return redirect('/tahun_akademik')->with(['error' => 'Tahun Akademik Tidak Ditemukan']);
        }

        $tahun_akademik->delete();

        return redirect('/tahun_akademik')->with(['success' => 'Tahun Akademik Berhasil Di Hapus']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik' => 'required|unique:tahun_akademiks',
        ]);

        // create code unik & random

        $code = 'TA' . random_int(1000, 9999);

        if (TahunAkademik::where('code', $code)->exists()) {
            $code = 'TA' . random_int(1000, 9999);
        }

        $tahun_akademik = TahunAkademik::create([
            'tahun_akademik' => $request->tahun_akademik,
            'code' => $code
        ]);

        if (!$tahun_akademik) {
            return redirect('/tahun_akademik')->with(['error' => 'Tahun Akademik Gagal Di Simpan']);
        }

        return redirect('/tahun_akademik')->with(['success' => 'Tahun Akademik Berhasil Di Simpan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik' => 'required',
        ]);

        $tahun_akademik = TahunAkademik::find($id);

        if (!$tahun_akademik) {
            return redirect('/tahun_akademik')->with(['error' => 'Tahun Akademik Tidak Ditemukan']);
        }

        $tahun_akademik->update([
            'tahun_akademik' => $request->tahun_akademik,
        ]);

        return redirect('/tahun_akademik')->with(['success' => 'Tahun Akademik Berhasil Di Update']);
    }
}
