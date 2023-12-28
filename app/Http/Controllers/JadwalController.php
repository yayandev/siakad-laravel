<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::paginate(4);

        $guru = Guru::all();
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('jadwal.index', compact('jadwals', 'guru', 'kelas', 'mapels', 'hari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mapel' => 'required',
            'id_guru' => 'required',
            'id_kelas' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'hari' => 'required',
        ]);

        // Check if the start time is before the end time
        if ($request->jam_mulai >= $request->jam_selesai) {
            return redirect('/jadwal')->with(['error' => 'Jam mulai harus sebelum jam selesai']);
        }

        // Check if the given combination of id_mapel, id_guru, id_kelas, jam_mulai, jam_selesai, and hari already exists
        $existingSchedules = Jadwal::where([
            'id_kelas' => $request->id_kelas,
            'hari' => $request->hari,
        ])->get();

        foreach ($existingSchedules as $existingSchedule) {
            // Check for time overlap
            if (
                ($request->jam_mulai >= $existingSchedule->jam_mulai && $request->jam_mulai < $existingSchedule->jam_selesai) ||
                ($request->jam_selesai > $existingSchedule->jam_mulai && $request->jam_selesai <= $existingSchedule->jam_selesai)
            ) {
                return redirect('/jadwal')->with(['error' => 'Jadwal tumpang tindih dengan jadwal lain']);
            }
        }

        // If all validations pass, proceed to store the data
        Jadwal::create([
            'id_mapel' => $request->id_mapel,
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'hari' => $request->hari,
        ]);

        return redirect('/jadwal')->with(['success' => 'Jadwal berhasil disimpan']);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);
        if (!$jadwal) {
            return redirect('/jadwal')->with(['error' => 'Jadwal tidak ditemukan']);
        }
        $jadwal->delete();
        return redirect('/jadwal')->with(['success' => 'Jadwal berhasil dihapus']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_mapel' => 'required',
            'id_guru' => 'required',
            'id_kelas' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'hari' => 'required',
        ]);

        // Check if the start time is before the end time
        if ($request->jam_mulai >= $request->jam_selesai) {
            return redirect('/jadwal')->with(['error' => 'Jam mulai harus sebelum jam selesai']);
        }

        // Check if the given combination of id_mapel, id_guru, id_kelas, jam_mulai, jam_selesai, and hari already exists
        $existingSchedules = Jadwal::where([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'hari' => $request->hari,
        ])->where('id', '!=', $id) // Exclude the current schedule being updated
            ->get();

        foreach ($existingSchedules as $existingSchedule) {
            // Check for time overlap
            if (
                ($request->jam_mulai >= $existingSchedule->jam_mulai && $request->jam_mulai < $existingSchedule->jam_selesai) ||
                ($request->jam_selesai > $existingSchedule->jam_mulai && $request->jam_selesai <= $existingSchedule->jam_selesai)
            ) {
                return redirect('/jadwal')->with(['error' => 'Jadwal tumpang tindih dengan jadwal lain']);
            }
        }

        // If all validations pass, update the data
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return redirect('/jadwal')->with(['error' => 'Jadwal tidak ditemukan']);
        }

        $jadwal->update([
            'id_mapel' => $request->id_mapel,
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'hari' => $request->hari,
        ]);

        return redirect('/jadwal')->with(['success' => 'Jadwal berhasil diperbarui']);
    }

    public function jadwalSiswa(Request $request)
    {
        $id = auth()->user()->id;

        $siswa = Siswa::where('id_user', $id)->with('kelas')->first();

        if (auth()->user()->status !== 'aktif') {
            return redirect('/')->with(['error' => 'Akun kamu belum aktif, silahkan hubungi admin']);
        }

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        if ($request->has('filter') && $request->filter != '') {
            $jadwals = Jadwal::with('mapel', 'guru', 'kelas')->where('id_kelas', $siswa->id_kelas)->where('hari', $request->filter)->get();
            return view('jadwal.siswa', compact('jadwals', 'siswa', 'hari'));
        }

        $jadwals = Jadwal::with('mapel', 'guru', 'kelas')->where('id_kelas', $siswa->id_kelas)->get();

        return view('jadwal.siswa', compact('jadwals', 'siswa', 'hari'));
    }

    public function jadwalGuru(Request $request)
    {
        $id = auth()->user()->id;

        $guru = Guru::where('id_user', $id)->first();

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];


        if (auth()->user()->status !== 'aktif') {
            return redirect('/')->with(['error' => 'Akun kamu belum aktif, silahkan hubungi admin']);
        }

        if ($request->has('filter') && $request->filter != '') {
            $jadwals = Jadwal::with('mapel', 'kelas')->where('id_guru', $guru->id)->where('hari', $request->filter)->get();
            return view('jadwal.guru', compact('jadwals', 'hari'));
        }

        $jadwals = Jadwal::with('mapel', 'kelas')->where('id_guru', $guru->id)->get();

        return view('jadwal.guru', compact('jadwals', 'hari'));
    }
}
