<?php

namespace App\Http\Controllers;

use App\Models\Epaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpaperController extends Controller
{
    // === BAGIAN ADMIN (Untuk Upload & Hapus) ===

    public function index()
    {
        // Menampilkan daftar koran di halaman Admin
        $epapers = Epaper::latest('edition_date')->paginate(10);
        return view('admin.epapers.index', compact('epapers'));
    }

    public function create()
    {
        // Menampilkan form upload
        return view('admin.epapers.create');
    }

    public function store(Request $request)
    {
        // Proses simpan PDF
        $request->validate([
            'title' => 'required|string|max:255',
            'edition_date' => 'required|date',
            'file' => 'required|mimes:pdf|max:10240', // Max 10MB
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
        // Hapus PDF & Data
        if ($epaper->file) {
            Storage::disk('public')->delete($epaper->file);
        }
        
        $epaper->delete();
        return back()->with('success', 'E-Paper berhasil dihapus.');
    }

    // === BAGIAN FRONTEND (Untuk Download Pengunjung) ===
    
    public function download(Epaper $epaper)
    {
        // Fungsi supaya pengunjung bisa download
        if (! $epaper->file || ! Storage::disk('public')->exists($epaper->file)) {
            abort(404);
        }
        return Storage::disk('public')->download($epaper->file, 'GaungNusra-'.$epaper->edition_date->format('Y-m-d').'.pdf');
    }
}