<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'type',      // Jenis: image_only / with_link
        'link',      // URL jika ada link
        'position',  // Posisi iklan
        'is_active', // Status aktif
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}