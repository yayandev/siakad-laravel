<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Mapel;
use App\Models\Semester;
use App\Models\Siswa;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::paginate(5);
        $siswa = Siswa::all();
        $tahun_akademik = TahunAkademik::all();
        $semester = Semester::all();
        $mapel = Mapel::all();

        return view('absensi.index', compact('absensi', 'siswa', 'tahun_akademik', 'semester', 'mapel'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'id_mapel' => 'required',
            'id_tahun_akademik' => 'required',
            'id_semester' => 'required'
        ]);

        $validation = Absensi::where('id_siswa', $request->id_siswa)->where('id_mapel', $request->id_mapel)->where('id_tahun_akademik', $request->id_tahun_akademik)->where('id_semester', $request->id_semester)->first();

        if ($validation) {
            return redirect('/absensi')->with(['error' => 'Absensi sudah diinput!']);
        }

        $newAbsensi = Absensi::create([
            'id_siswa' => $request->id_siswa,
            'id_mapel' => $request->id_mapel,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'id_semester' => $request->id_semester,
            'hadir' => $request->hadir,
            'sakit' => $request->sakit,
            'alpa' => $request->alpa,
            'ijin' => $request->ijin,
        ]);

        if ($newAbsensi) {
            return redirect('/absensi')->with(['success' => 'Absensi berhasil ditambahkan!']);
        } else {
            return redirect('/absensi')->with(['error' => 'Absensi gagal ditambahkan!']);
        }
    }

    public function destroy($id)
    {
        $absensi = Absensi::find($id);
        if (!$absensi) {
            return redirect('/absensi')->with(['error' => 'Absensi tidak ditemukan!']);
        }
        $absensi->delete();
        return redirect('/absensi')->with(['success' => 'Absensi berhasil dihapus!']);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'id_siswa' => 'required',
            'id_mapel' => 'required',
            'id_tahun_akademik' => 'required',
            'id_semester' => 'required',
            'hadir' => 'required',
            'sakit' => 'required',
            'alpa' => 'required',
            'ijin' => 'required',
        ]);

        $absensi = Absensi::find($id);

        if (!$absensi) {
            return redirect('/absensi')->with(['error' => 'Absensi tidak ditemukan!']);
        }

        $absensi->update([
            'id_siswa' => $request->id_siswa,
            'id_mapel' => $request->id_mapel,
            'id_tahun_akademik' => $request->id_tahun_akademik,
            'id_semester' => $request->id_semester,
            'hadir' => $request->hadir,
            'sakit' => $request->sakit,
            'alpa' => $request->alpa,
            'ijin' => $request->ijin,
        ]);

        return redirect('/absensi')->with(['success' => 'Absensi berhasil diupdate!']);
    }
}
