<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← これを追加

class Cat extends Model
{
    use HasFactory;
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}
