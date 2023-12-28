<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas', 'id');
    }

    public function walikelas()
    {
        return $this->belongsTo(Guru::class, 'id_wali', 'id');
    }
}
