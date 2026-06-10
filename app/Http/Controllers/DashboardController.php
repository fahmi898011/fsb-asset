<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Room; // <--- JANGAN LUPA IMPORT MODEL ROOM
use App\Models\AssetHistory;
use App\Models\AuditSession;

class DashboardController extends Controller
{
    public function index()
    {
        // ... kode statistik sebelumnya (totalAssets, totalValue, dll) ...
        $totalAssets = Asset::count();
        $totalValue = Asset::sum('price');
        $goodAssets = Asset::where('condition', 'Baik')->count();
        $brokenAssets = Asset::where('condition', '!=', 'Baik')->count();
        $activeAudit = AuditSession::where('status', 'open')->first();

        // Data Kategori (Top 5)
        $categories = Category::withCount('assets')
                        ->orderBy('assets_count', 'desc')
                        ->get();

        // --- TAMBAHAN BARU: DATA LOKASI (TOP 5) ---
        $rooms = Room::withCount('assets')
                    ->orderBy('assets_count', 'desc')
                    ->get();
        // ------------------------------------------

        // Histori Aktivitas
        $recentActivities = AssetHistory::with(['user', 'asset']) // Pastikan relasi aman
                            ->latest()
                            ->limit(6)
                            ->get();

        return view('dashboard.index', compact(
            'totalAssets', 
            'totalValue', 
            'goodAssets', 
            'brokenAssets', 
            'categories', 
            'rooms', // <--- KIRIM VARIABEL ROOMS KE VIEW
            'recentActivities',
            'activeAudit'
        ));
    }
}