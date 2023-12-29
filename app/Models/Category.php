<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Posts::class, 'id_category', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
