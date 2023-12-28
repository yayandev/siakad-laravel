<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:4|required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required',
        ]);


        $hashPassword = bcrypt($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashPassword
        ]);

        if ($user) {

            // buat nis 8 digit dengan perpaduan tahun bulan dan tanggal pendaftaran serta angka random

            $year = date('y');
            $month = date('m');
            $day = date('d');
            $nis = $year . $month . $day . $user->id;

            $siswa = Siswa::create([
                'name' => $request->name,
                'id_user' => $user->id,
                'nis' => $nis
            ]);

            if (!$siswa) {
                return redirect('/register')->with(['error' => 'Something went wrong']);
            }

            auth()->login($user);
            return redirect('/');
        } else {
            return redirect('/register')->with(['error' => 'Something went wrong']);
        }
    }
}
