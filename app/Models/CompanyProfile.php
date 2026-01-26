<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'logo',
        'email',
        'phone',
        'website',
        'facebook',
        'instagram',
    ];
}