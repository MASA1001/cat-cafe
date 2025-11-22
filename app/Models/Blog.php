<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← これを追加

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title','body','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function cats()
    {
        return $this->belongsToMany(Cat::class)->withtimestamps();
    }
}
