<?php

namespace App\Http\Controllers;

use App\Models\AuditSession;
use App\Models\AuditResult;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{
    // Daftar Sesi Opname
    public function index()
    {
        $sessions = AuditSession::with('auditor')->withCount('results')->latest()->paginate(10);
        return view('audits.index', compact('sessions'));
    }

    // Buat Sesi Baru
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string']);
        
        AuditSession::create([
            'title' => $request->title,
            'start_date' => now(),
            'user_id' => auth()->id(),
            'status' => 'open'
        ]);

        return redirect()->route('audits.index')->with('success', 'Sesi Opname dimulai.');
    }

    // Halaman Kerja (Scanning Interface)
    public function show($id, Request $request)
    {
        $session = AuditSession::findOrFail($id);
        
        // Logika untuk menampilkan Progres
        // Total Aset Aktif di Sistem
        $totalAssets = Asset::count();
        // Aset yang sudah discan di sesi ini
        $scannedCount = $session->results()->count();
        // Persentase
        $progress = $totalAssets > 0 ? ($scannedCount / $totalAssets) * 100 : 0;

        // Ambil list hasil scan terakhir
        $recentScans = $session->results()->with('asset.room')->latest('scanned_at')->limit(5)->get();

        return view('audits.show', compact('session', 'totalAssets', 'scannedCount', 'progress', 'recentScans'));
    }

    // Proses Scan (AJAX / Form Submit)
    public function scan(Request $request, $id)
    {
        $request->validate(['asset_code' => 'required']);
        $session = AuditSession::findOrFail($id);

        if ($session->status == 'closed') {
            return back()->withErrors(['Sesi ini sudah ditutup.']);
        }

        // Cari Aset
        $asset = Asset::where('asset_code', $request->asset_code)->first();

        if (!$asset) {
            return back()->withErrors(['Kode Aset tidak ditemukan di database!']);
        }

        // Cek apakah sudah discan sebelumnya
        $exists = AuditResult::where('audit_session_id', $id)
                             ->where('asset_id', $asset->id)
                             ->exists();

        if ($exists) {
            return back()->with('warning', 'Aset ini sudah discan sebelumnya.');
        }

        // Simpan Hasil Scan
        AuditResult::create([
            'audit_session_id' => $id,
            'asset_id' => $asset->id,
            'status' => 'match', // Default match, nanti bisa dikembangkan logic pindah ruangan
            'scanned_at' => now()
        ]);

        return back()->with('success', 'Berhasil scan: ' . $asset->name);
    }

    // Tutup Sesi & Lihat Laporan Selisih
    public function report($id)
    {
        $session = AuditSession::with('auditor')->findOrFail($id);
        
        // Cari Aset yang BELUM ada di tabel audit_results (MISSING)
        // Logic: Ambil semua ID aset, kurangi dengan ID yang ada di audit_results
        $scannedAssetIds = $session->results()->pluck('asset_id');
        
        $missingAssets = Asset::whereNotIn('id', $scannedAssetIds)
                              ->with(['room', 'pic'])
                              ->get();
                              
        $scannedCount = $scannedAssetIds->count();
        $totalAssets = Asset::count();

        return view('audits.report', compact('session', 'missingAssets', 'scannedCount', 'totalAssets'));
    }

    // Finalisasi Sesi
    public function close($id)
    {
        $session = AuditSession::findOrFail($id);
        $session->update([
            'status' => 'closed',
            'end_date' => now()
        ]);
        return redirect()->route('audits.report', $id)->with('success', 'Sesi opname ditutup.');
    }

    // Tambahkan method ini di AuditController

    public function searchAjax(Request $request)
    {
        $keyword = $request->get('q');
        
        if (!$keyword) return response()->json([]);

        // Cari aset berdasarkan Nama atau Kode
        $assets = Asset::with(['room', 'pic'])
                    ->where('name', 'like', "%{$keyword}%")
                    ->orWhere('asset_code', 'like', "%{$keyword}%")
                    ->limit(10) // Batasi 10 hasil agar ringan
                    ->get();

        return response()->json($assets);
    }

    // --- TAMBAHAN DI AuditController ---

    // 1. Fitur Buka Kembali Sesi (Jika terlanjur ditutup)
    public function reopen($id)
    {
        $session = AuditSession::findOrFail($id);
        
        // Kembalikan status ke open
        $session->update([
            'status' => 'open',
            'end_date' => null // Kosongkan tanggal selesai
        ]);

        return back()->with('success', 'Sesi berhasil dibuka kembali. Silakan lanjutkan scanning.');
    }

    // 2. Fitur Quick Action: Tandai Ditemukan langsung dari Tabel Laporan
    public function markFound($id, $assetId)
    {
        $session = AuditSession::findOrFail($id);

        if ($session->status == 'closed') {
            return back()->withErrors(['Sesi sudah ditutup. Klik "Buka Kembali" terlebih dahulu.']);
        }

        // Cek apakah sudah ada
        $exists = AuditResult::where('audit_session_id', $id)
                             ->where('asset_id', $assetId)
                             ->exists();

        if ($exists) {
            return back()->with('warning', 'Aset sudah tercatat.');
        }

        AuditResult::create([
            'audit_session_id' => $id,
            'asset_id' => $assetId,
            'status' => 'match',
            'note' => 'Manual verification via Report Page', // Catatan otomatis
            'scanned_at' => now()
        ]);

        return back()->with('success', 'Aset berhasil ditandai sebagai DITEMUKAN.');
    }
}