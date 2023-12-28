<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_mapel', 'id');
    }
}
