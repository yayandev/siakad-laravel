<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    public function changeLogo()
    {
        $sekolah = Sekolah::find(1);
        return view('sekolah.logo', compact('sekolah'));
    }

    public function profileSekolah()
    {
        $sekolah = Sekolah::find(1);
        return view('sekolah.profile', compact('sekolah'));
    }

    public function storeLogo(Request $request)
    {

        $request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $sekolah = Sekolah::find(1);

        $olgLogo = $sekolah->logo;

        if (basename($olgLogo) !== 'default.png') {
            Storage::delete('public/logo/' . basename($olgLogo));
        }


        $file = $request->file('file');

        $file->storeAs('public/logo', $file->hashName());

        $sekolah->logo = $file->hashName();

        $sekolah->save();

        return redirect('/sekolah/logo')->with(['success' => 'Logo sekolah updated successfully!']);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'visi' => 'required|min:3',
            'misi' => 'required|min:3',
            'alamat' => 'required|min:3',
            'bio' => 'required|min:3',
            'email' => 'required|email',
            'no_telp' => 'required',
        ]);

        $sekolah = Sekolah::find(1);

        $sekolah->update($request->all());

        return redirect('/sekolah/profile')->with(['success' => 'Profile sekolah updated successfully!']);
    }
}
