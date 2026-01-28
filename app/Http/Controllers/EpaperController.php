<?php

namespace App\Http\Controllers;

use App\Models\Epaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpaperController extends Controller
{
    // === BAGIAN ADMIN (Dibiarkan saja atau bisa dihapus jika 100% pakai Filament) ===
    // Karena Mas pakai Filament, bagian index/create/store di bawah ini sebenarnya
    // tidak terpakai lagi, tapi saya biarkan dulu biar tidak error kalau ada sisa route lama.

    public function index()
    {
        $epapers = Epaper::latest('edition_date')->paginate(10);
        return view('admin.epapers.index', compact('epapers'));
    }

    public function create()
    {
        return view('admin.epapers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'edition_date' => 'required|date',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        $path = $request->file('file')->store('epapers', 'public');

        Epaper::create([
            'title' => $request->title,
            'edition_date' => $request->edition_date,
            'file' => $path,
        ]);

        return redirect()->route('epapers.index')->with('success', 'E-Paper berhasil diupload!');
    }

    public function destroy(Epaper $epaper)
    {
        if ($epaper->file) {
            Storage::disk('public')->delete($epaper->file);
        }
        
        $epaper->delete();
        return back()->with('success', 'E-Paper berhasil dihapus.');
    }

    // === BAGIAN FRONTEND (DOWNLOAD PENGUNJUNG) ===
    
    // 1. Download Edisi Tertentu (Berdasarkan ID)
    public function download(Epaper $epaper)
    {
        if (! $epaper->file || ! Storage::disk('public')->exists($epaper->file)) {
            abort(404);
        }
        // Nama file saat didownload: "Koran-GaungNusra-2026-01-28.pdf"
        return Storage::disk('public')->download($epaper->file, 'Koran-GaungNusra-'.$epaper->edition_date->format('Y-m-d').'.pdf');
    }

    // 2. Download Edisi TERBARU (Otomatis) - INI YANG BARU DITAMBAHKAN
    public function downloadLatest()
    {
        // Cari koran yang tanggalnya paling baru DAN statusnya aktif
        $latest = Epaper::where('is_active', true)->latest('edition_date')->first();

        // Cek apakah datanya ada & filenya eksis di penyimpanan
        if (!$latest || !$latest->file || !Storage::disk('public')->exists($latest->file)) {
            // Kalau belum ada koran sama sekali, kembalikan user ke halaman sebelumnya
            return back()->with('error', 'Mohon maaf, E-Paper edisi hari ini belum tersedia.');
        }

        // Kalau ada, langsung download otomatis
        return Storage::disk('public')->download($latest->file, 'Koran-GaungNusra-Terbaru.pdf');
    }
}