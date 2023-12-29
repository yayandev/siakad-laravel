<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('storage/posts/' . basename($value)),
        );
    }
}
