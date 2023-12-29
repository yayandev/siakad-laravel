<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id');
    }

    public function tahun_akademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_tahun_akademik', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id');
    }
}
