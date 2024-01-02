<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($logo) => asset('storage/logo/' . $logo),
        );
    }
}
