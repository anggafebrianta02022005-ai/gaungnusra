<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasFactory;

    // 1. Kolom yang diizinkan untuk diisi (Mass Assignment)
   protected $fillable = [
    'news_code',
    'title',
    'slug',
    'subtitle',
    'content',
    'image',
    'image_caption', // <--- INI "SURAT IZIN MASUK"-NYA
    'thumbnail',
    'author_id',
    'status',
    'published_at',
    'pin_order',
    // ...
];

    // 2. Konversi Tipe Data Otomatis
    protected $casts = [
        'published_at' => 'datetime', // Agar bisa diformat ($news->published_at->format('d M Y'))
        'pin_order' => 'integer',     // Memastikan urutan pin dianggap angka
    ];

    // 3. LOGIKA OTOMATIS (Solusi Error 'journalist_code' & 'user_id')
    // Fungsi ini dijalankan tepat SEBELUM data disimpan ke database.
    protected static function booted(): void
    {
        static::creating(function (News $news) {
            // A. Jika User ID kosong, isi dengan ID user yang sedang login
            if (empty($news->user_id)) {
                $news->user_id = auth()->id();
            }

            // B. Jika Kode Jurnalis kosong, ambil dari Nama User Login (Huruf Besar)
            // Contoh: "Angga" menjadi "ANGGA"
            if (empty($news->journalist_code)) {
                $news->journalist_code = strtoupper(auth()->user()->name ?? 'ADM');
            }
        });
    }

    // 4. Relasi ke Tabel Users (Penulis)
    // Satu Berita dimiliki oleh Satu User
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 5. Relasi ke Tabel Categories
    // Satu Berita bisa punya Banyak Kategori (Many-to-Many)
    // Pivot table: 'category_news'
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_news', 'news_id', 'category_id');
    }
}