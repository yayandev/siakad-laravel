<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $walis = Guru::all();
        $siswa = Siswa::where('id_kelas', null)->get();

        if ($request->has('search')) {
            $kelas = Kelas::where('nama', 'LIKE', '%' . $request->search . '%')->paginate(4);

            return view('kelas.index', compact('kelas', 'walis', 'siswa'));
        }
        $kelas = Kelas::paginate(4);
        return view('kelas.index', compact('kelas', 'walis', 'siswa'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:kelas',
            'id_wali' => 'required',
        ]);

        $kelas = Kelas::create([
            'name' => $request->name,
            'code' => $request->code,
            'id_wali' => $request->id_wali
        ]);

        if ($kelas) {
            return redirect('/kelas')->with(['success' => 'Berhasil menambahkan kelas!']);
        }

        return redirect('/kelas')->with(['error' => 'Gagal menambahkan kelas!']);
    }

    public function destroy($id)
    {
        $kelas = Kelas::with('siswa')->find($id);

        if ($kelas->siswa->count() > 0) {
            foreach ($kelas->siswa as $siswa) {
                $siswa->update([
                    'id_kelas' => null
                ]);
            }
        }

        if (!$kelas) {
            return redirect('/kelas')->with(['error' => 'Kelas tidak ditemukan!']);
        }

        $kelas->delete();
        return redirect('/kelas')->with(['success' => 'Berhasil menghapus kelas!']);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'id_wali' => 'required',
        ]);

        $kelas = Kelas::find($id);

        if (!$kelas) {
            return redirect('/kelas')->with(['error' => 'Kelas tidak ditemukan!']);
        }

        $kelas->update([
            'name' => $request->name,
            'code' => $request->code,
            'id_wali' => $request->id_wali
        ]);

        return redirect('/kelas')->with(['success' => 'Berhasil mengupdate kelas!']);
    }

    public function addSiswa(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required',
            'id_kelas' => 'required',
        ]);

        $siswa = Siswa::find($request->id_siswa);

        if (!$siswa) {
            return redirect('/kelas')->with(['error' => 'Siswa tidak ditemukan!']);
        }

        $siswa->update([
            'id_kelas' => $request->id_kelas
        ]);

        return redirect('/kelas')->with(['success' => 'Berhasil menambahkan siswa ke kelas!']);
    }

    public function deleteSiswa($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return redirect('/kelas')->with(['error' => 'Siswa tidak ditemukan!']);
        }

        $siswa->update([
            'id_kelas' => null
        ]);

        return redirect('/kelas')->with(['success' => 'Berhasil menghapus siswa dari kelas!']);
    }
}
