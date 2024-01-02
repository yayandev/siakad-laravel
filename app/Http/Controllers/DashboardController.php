<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Brick\Math\BigNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DashboardController extends Controller
{
    public function index()
    {
        // $sekolah = Sekolah::find(1);
        if (auth()->user()->role === 'admin') {
            $users = User::count();
            $siswa = Siswa::count();
            $guru = Guru::count();
            $pendaftar = 0;
            return view('dashboard', compact('users', 'siswa', 'guru', 'pendaftar'));
        } else if (auth()->user()->role === 'siswa') {
            $siswa = Siswa::where('id_user', auth()->user()->id)->first();

            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            $hari_ini = date('w') == 0 ? $hari[6] : $hari[date('w') - 1];

            $jadwals = Jadwal::with('mapel', 'guru', 'kelas')->where('id_kelas', $siswa->id_kelas)->where('hari', $hari_ini)->get();
            return view('dashboard', compact('jadwals', 'hari_ini'));
        } else if (auth()->user()->role === 'guru') {
            $guru = Guru::where('id_user', auth()->user()->id)->first();

            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            $hari_ini = date('w') == 0 ? $hari[6] : $hari[date('w') - 1];

            $jadwals = Jadwal::with('mapel', 'kelas')->where('id_guru', $guru->id)->where('hari', $hari_ini)->get();
            return view('dashboard', compact('jadwals', 'hari_ini'));
        }

        return view('dashboard');
    }
}
