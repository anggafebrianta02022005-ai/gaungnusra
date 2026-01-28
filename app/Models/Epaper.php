<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epaper extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',           
        'edition_date',
        'is_active',
    ];

    protected $casts = [
        'edition_date' => 'date',
        'is_active' => 'boolean',
    ];
}