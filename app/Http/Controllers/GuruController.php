<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $gurus = Guru::where('nip', 'LIKE', '%' . request('search') . '%')->paginate(4);
            return view('guru.index', compact('gurus'));
        }

        $gurus = Guru::paginate(4);

        return view('guru.index', compact('gurus'));
    }

    public function updateMyBiodata(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nip' => 'required|min:6',
            'alamat' => 'required',
            'no_hp' => 'required|min:10',
        ]);

        $id_user = auth()->user()->id;

        $guru = Guru::where('id_user', $id_user)->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/account/profile')->with(['success' => 'Update biodata berhasil!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'nip' => 'required|min:6',
            'alamat' => 'required',
            'no_hp' => 'required|min:10',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->nip),
            'role' => 'guru',
            'status' => 'aktif',
        ]);

        if ($user) {
            $guru = Guru::create([
                'id_user' => $user->id,
                'name' => $request->name,
                'nip' => $request->nip,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            if ($guru) {
                return redirect('/guru')->with(['success' => 'Data guru berhasil ditambahkan! "Password default" : ' . $request->nip]);
            } else {
                return redirect('/guru')->with(['error' => 'Akun guru gagal dibuat!']);
            }
        }

        return redirect('/guru')->with(['error' => 'Akun guru gagal dibuat!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'nip' => 'required|min:6',
            'alamat' => 'required',
            'no_hp' => 'required|min:10',
        ]);

        $guru = Guru::find($id);

        if (!$guru) {
            return redirect('/guru')->with(['error' => 'Guru not found']);
        }

        $guru->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/guru')->with(['success' => 'Guru updated successfully']);
    }

    public function destroy($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return redirect('/guru')->with(['error' => 'Guru not found']);
        }

        $guru->delete();

        $user = User::where('id', $guru->id_user)->delete();


        return redirect('/guru')->with(['success' => 'Guru deleted successfully']);
    }
}
