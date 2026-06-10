<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Room;
use App\Models\Category;
use App\Models\Employee; // <--- JANGAN LUPA IMPORT INI

class ReportController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        // Tambahkan data pegawai urut abjad
        $employees = Employee::where('is_active', 1)->orderBy('name')->get(); 
        
        return view('reports.index', compact('rooms', 'categories', 'employees'));
    }

    public function print(Request $request)
    {
        // Query Dasar dengan relasi lengkap
        $query = Asset::with(['category', 'room', 'pic']);
        $title = 'Laporan Seluruh Aset';

        switch ($request->type) {
            // --- TAMBAHAN BARU: SEMUA ASET ---
            case 'all':
                $title = 'Laporan Master Seluruh Aset (All Data)';
                break;
            case 'by_room':
                if ($request->room_id) {
                    $query->where('room_id', $request->room_id);
                    $roomName = Room::find($request->room_id)->name ?? '-';
                    $title = 'Laporan Aset Ruangan: ' . $roomName;
                }
                break;

            case 'by_category':
                if ($request->category_id) {
                    $query->where('category_id', $request->category_id);
                    $catName = Category::find($request->category_id)->name ?? '-';
                    $title = 'Laporan Aset Kategori: ' . $catName;
                }
                break;

            case 'by_condition':
                if ($request->condition) {
                    $query->where('condition', $request->condition);
                    $title = 'Laporan Aset Kondisi: ' . $request->condition;
                }
                break;

            // === LOGIKA BARU: PER PEGAWAI ===
            case 'by_employee':
                if ($request->employee_id == 'no_pic') {
                    // Filter Aset Umum (Tanpa Penanggung Jawab)
                    $query->whereNull('employee_id');
                    $title = 'Laporan Aset Umum (Tanpa PIC)';
                } 
                elseif ($request->employee_id) {
                    // Filter Pegawai Tertentu
                    $query->where('employee_id', $request->employee_id);
                    $emp = Employee::find($request->employee_id);
                    $title = 'Laporan Aset PIC: ' . ($emp->name ?? '-');
                }
                break;
        }

        $assets = $query->get();

        return view('reports.print', compact('assets', 'title'));
    }
}