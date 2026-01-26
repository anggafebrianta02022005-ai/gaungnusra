<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    // Relasi ke Berita juga JAMAK
    public function news()
    {
        return $this->belongsToMany(News::class, 'category_news');
    }
}