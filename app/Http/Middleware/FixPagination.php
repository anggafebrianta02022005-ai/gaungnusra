<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixPagination
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada parameter "?page=" di URL
        if ($request->has('page')) {
            $page = $request->query('page');

            // KRITERIA REDIRECT (Tangkap Penjahat SEO):
            // 1. ?page= (Kosong/Null)
            // 2. ?page=1 (Ini duplikat Home, harus dibuang)
            // 3. ?page=0 atau ?page=-5 (Angka di bawah 1)
            // 4. ?page=abc (Bukan angka)
            if (
                $page === null || 
                $page === '' || 
                $page == '1' || 
                (is_numeric($page) && (int)$page < 1) || 
                !is_numeric($page)
            ) {
                // AKSI: Redirect 301 Permanen ke URL bersih
                // fullUrlWithQuery(['page' => null]) otomatis membuang parameter 'page' saja
                // Parameter lain (misal ?search=ayam) akan tetap aman
                return redirect()->to($request->fullUrlWithQuery(['page' => null]), 301);
            }
        }

        return $next($request);
    }
}