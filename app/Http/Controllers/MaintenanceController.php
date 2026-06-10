<?php

namespace App\Models; // Pastikan namespace benar di file aslinya (biasanya otomatis)
// Koreksi: namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    // Menampilkan Form Input Maintenance untuk Aset tertentu
    public function create($assetId)
    {
        $asset = Asset::findOrFail($assetId);
        return view('maintenances.create', compact('asset'));
    }

    // Proses Simpan
    public function store(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);

        $request->validate([
            'maintenance_date' => 'required|date',
            'type' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'description' => 'required|string',
            'vendor' => 'nullable|string',
            'invoice' => 'nullable|image|max:2048', // Bukti bayar
            'update_condition' => 'nullable|string' // Opsional: Ubah kondisi aset setelah servis
        ]);

        DB::transaction(function () use ($request, $asset) {
            
            // 1. Upload Nota (Jika ada)
            $invoicePath = null;
            if ($request->hasFile('invoice')) {
                $invoicePath = $request->file('invoice')->store('maintenance_invoices', 'public');
            }

            // 2. Simpan Data Maintenance
            AssetMaintenance::create([
                'asset_id' => $asset->id,
                'user_id' => auth()->id(),
                'maintenance_date' => $request->maintenance_date,
                'type' => $request->type,
                'cost' => $request->cost,
                'vendor' => $request->vendor,
                'description' => $request->description,
                'invoice_path' => $invoicePath,
            ]);

            // 3. Update Kondisi Aset (Jika dipilih)
            // Misal: Dari "Rusak Ringan" -> "Baik" setelah diservis
            if ($request->update_condition) {
                $asset->update(['condition' => $request->update_condition]);
            }

            // 4. Catat di Log Histori Utama (Agar muncul di timeline)
            AssetHistory::create([
                'asset_id' => $asset->id,
                'user_id' => auth()->id(),
                'action' => 'MAINTENANCE',
                'description' => "Melakukan perawatan: {$request->type}. Biaya: Rp " . number_format($request->cost)
            ]);
        });

        return redirect()->route('assets.show', $asset->id)->with('success', 'Data perawatan berhasil dicatat.');
    }
}