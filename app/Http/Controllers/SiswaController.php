<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('search')) {
            $siswas = Siswa::where('nisn', 'like', '%' . $request->search . '%')->paginate(4);

            return view('siswa.index', compact('siswas'));
        }

        $siswas = Siswa::paginate(4);

        return view('siswa.index', compact('siswas'));
    }


    public function updateMyBiodata(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'nisn' => 'required',
            'nik' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $request->only(['name', 'nisn', 'nik', 'jk', 'tempat_lahir', 'tgl_lahir', 'ayah', 'ibu', 'alamat', 'no_telp']);
        $id = auth()->user()->id;

        $siswa = Siswa::where('id_user', $id)->first();

        if (!$siswa) {
            return redirect('/')->with(['error' => 'Data Siswa Belum Terdaftar']);
        }

        $siswa->update($request->all());

        return redirect('/account/profile')->with(['success' => 'Data Siswa Berhasil Diperbarui!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'nisn' => 'required',
            'nik' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        $request->only(['name', 'nisn', 'nik', 'jk', 'tempat_lahir', 'tgl_lahir', 'ayah', 'ibu', 'alamat', 'no_telp']);

        // generate nis with random number lenght 2

        $year = date('y');
        $month = date('m');
        $day = date('d');
        $nis = $year . $month . $day . rand(10, 99);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($nis),
            'status' => 'aktif',
        ]);

        if ($user) {
            $siswa = Siswa::create([
                'name' => $request->name,
                'id_user' => $user->id,
                'nis' => $nis,
                'nisn' => $request->nisn,
                'nik' => $request->nik,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'ayah' => $request->ayah,
                'ibu' => $request->ibu,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);

            if ($siswa) {
                return redirect('/siswa')->with(['success' => 'Data Siswa Berhasil Ditambahkan, "Password default adalah nis siswa (' . $nis . ')!"']);
            }
        }

        return redirect('/siswa')->with(['error' => 'Data Siswa Gagal Ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'nisn' => 'required|unique:siswas,nisn,' . $id,
            'nis' => 'required|unique:siswas,nis,' . $id,
            'nik' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);

        $request->only(['name', 'nisn', 'nis', 'nik', 'jk', 'tempat_lahir', 'tgl_lahir', 'ayah', 'ibu', 'alamat', 'no_telp']);

        $siswa = Siswa::find($id);

        if (!$siswa) {
            return redirect('/siswa')->with(['error' => 'Data Siswa Belum Terdaftar']);
        }

        $siswa->update($request->all());

        return redirect('/siswa')->with(['success' => 'Data Siswa Berhasil Diperbarui!']);
    }

    public function destroy($id)
    {

        $siswa = Siswa::find($id);

        if (!$siswa) {
            return redirect('/siswa')->with(['error' => 'Data Siswa Belum Terdaftar']);
        }

        $siswa->delete();

        $user = User::find($siswa->id_user)->delete();

        if (!$user) {
            return redirect('/siswa')->with(['error' => 'Data Siswa Gagal Dihapus']);
        }

        return redirect('/siswa')->with(['success' => 'Data Siswa Berhasil Dihapus!']);
    }

    public function siswaKelas()
    {
        $id = auth()->user()->id;

        $siswa = Siswa::where('id_user', $id)->with('kelas')->first();

        return view('account.siswa.kelas', compact('siswa'));
    }
}
