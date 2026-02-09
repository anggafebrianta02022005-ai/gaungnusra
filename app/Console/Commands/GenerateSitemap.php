<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\News;
use App\Models\Category;

class GenerateSitemap extends Command
{
    /**
     * Nama perintah yang akan diketik di terminal.
     * Contoh: php artisan sitemap:generate
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * Deskripsi perintah.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml untuk berita dan kategori yang aktif';

    /**
     * Eksekusi perintah.
     */
    public function handle()
    {
        $this->info('Memulai proses generate sitemap...');

        // Inisialisasi Sitemap
        $sitemap = Sitemap::create();

        // 1. Tambahkan Halaman Utama (Home)
        // PENTING: Gunakan helper url() agar domain terbaca benar dari .env
        $sitemap->add(Url::create(url('/'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY));

        // 2. Tambahkan Halaman Kategori
        $categories = Category::where('is_active', 1)->get();
        
        foreach ($categories as $category) {
            $sitemap->add(Url::create(url("/category/{$category->slug}")) // Pakai url()
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        }
        $this->info("Berhasil menambahkan {$categories->count()} kategori.");

        // 3. Tambahkan Berita (Hanya yang PUBLISHED)
        $newsCount = 0;
        News::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->chunk(100, function ($posts) use ($sitemap, &$newsCount) {
                foreach ($posts as $post) {
                    $sitemap->add(Url::create(url("/news/{$post->slug}")) // Pakai url()
                        ->setLastModificationDate($post->updated_at)
                        ->setPriority(0.6)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
                    
                    $newsCount++;
                }
            });
        
        $this->info("Berhasil menambahkan {$newsCount} berita.");

        // 4. Simpan file fisik ke folder public/
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('SUKSES! Sitemap berhasil dibuat di public/sitemap.xml');
    }
}