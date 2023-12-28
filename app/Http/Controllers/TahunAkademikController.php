<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index(Request $request)
    {
        $semesters = Semester::all();
        if ($request->has('search')) {
            $tahun_akademiks = TahunAkademik::where('tahun_akademik', 'like', '%' . $request->search . '%')->paginate(4);
            return view('tahun_akademik.index', compact('tahun_akademiks', 'semesters'));
        }
        $tahun_akademiks = TahunAkademik::paginate(4);
        return view('tahun_akademik.index', compact('tahun_akademiks', 'semesters'));
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
            'tahun_akademik' => 'required',
            'id_semester' => 'required',
        ]);

        $tahun_akademiks = TahunAkademik::where('id_semester', $request->id_semester)->where('tahun_akademik', $request->tahun_akademik)->first();

        if ($tahun_akademiks) {
            return redirect('/tahun_akademik')->with(['error' => 'Tahun Akademik Sudah Ada']);
        }

        $tahun_akademik = TahunAkademik::create([
            'tahun_akademik' => $request->tahun_akademik,
            'id_semester' => $request->id_semester
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
            'id_semester' => 'required',
        ]);

        $tahun_akademik = TahunAkademik::find($id);

        if (!$tahun_akademik) {
            return redirect('/tahun_akademik')->with(['error' => 'Tahun Akademik Tidak Ditemukan']);
        }

        $tahun_akademik->update([
            'tahun_akademik' => $request->tahun_akademik,
            'id_semester' => $request->id_semester
        ]);

        return redirect('/tahun_akademik')->with(['success' => 'Tahun Akademik Berhasil Di Update']);
    }
}
