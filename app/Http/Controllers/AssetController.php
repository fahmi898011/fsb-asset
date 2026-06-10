<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\AssetHistory;
use App\Models\User; // Tambahan
use App\Models\Employee; // Import model
// Model lain (Asset, Room, Category) sudah ada sebelumnya

class AssetController extends Controller
{
    /**
     * Menampilkan daftar aset
     */
    public function index(Request $request)
    {
        // Query Dasar dengan Eager Loading (biar hemat query DB)
        $query = Asset::with(['category', 'room', 'pic']);

        // Filter sederhana (jika ada input search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%");
            });
        }

        // Filter Ruangan
        if ($request->has('room_id') && $request->room_id != '') {
            $query->where('room_id', $request->room_id);
        }

        // Ambil data (paginate 10 per halaman)
        $assets = $query->latest()->paginate(10);
        
        // Ambil data ruangan untuk dropdown filter
        $rooms = Room::all();

        return view('assets.index', compact('assets', 'rooms'));
    }

    // Method lainnya (create, store, dll) kita isi di tahap selanjutnya
    public function create()
    {
        $categories = Category::all();
        $rooms = Room::all();
        $employees = Employee::where('is_active', 1)->get();

        // --- LOGIC AUTO NUMBER ---
        // 1. Ambil tahun saat ini (misal 2024)
        $year = date('Y');
        
        // 2. Cari kode aset terakhir yang dibuat di tahun ini
        $lastAsset = Asset::where('asset_code', 'like', 'INV-'.$year.'-%')
                          ->orderBy('id', 'desc')
                          ->first();

        if ($lastAsset) {
            // Jika ada, ambil 5 digit terakhir (nomor urut)
            // Contoh: INV-2024-00001 -> ambil 00001
            $lastNumber = (int)substr($lastAsset->asset_code, -5);
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada data tahun ini, mulai dari 1
            $newNumber = 1;
        }

        // 3. Format ulang menjadi 5 digit (00001)
        $newCode = 'INV-' . $year . '-' . sprintf("%05d", $newNumber);
        // -------------------------

        // Kirim $newCode ke view
        return view('assets.create', compact('categories', 'rooms', 'employees', 'newCode'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input yang Ketat
        $request->validate([
            'asset_code'    => 'required|unique:assets,asset_code|max:50',
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'room_id'       => 'required|exists:rooms,id',
            'employee_id'   => 'nullable|exists:employees,id',
            'purchase_date' => 'required|date',
            'price'         => 'required|numeric|min:0',
            'condition'     => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'document'      => 'nullable|mimes:pdf,jpg|max:5120', // Max 5MB
        ]);

        // Gunakan DB Transaction agar Aman (Atomic)
        DB::transaction(function () use ($request) {
            
            // 2. Handle Upload File
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('assets/images', 'public');
            }

            $documentPath = null;
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('assets/documents', 'public');
            }

            // 3. Simpan Data Aset
            $asset = Asset::create([
                'asset_code'    => $request->asset_code,
                'name'          => $request->name,
                'category_id'   => $request->category_id,
                'room_id'       => $request->room_id,
                'employee_id'   => $request->employee_id,
                'condition'     => $request->condition,
                'purchase_date' => $request->purchase_date,
                'price'         => $request->price,
                'status'        => 'active',
                'description'   => $request->description,
                'image_path'    => $imagePath,
                'document_path' => $documentPath,
            ]);

            // 4. Catat Audit Trail (Histori Awal)
            AssetHistory::create([
                'asset_id'    => $asset->id,
                'user_id'     => auth()->id(), // Siapa yang input (Admin/GA)
                'action'      => 'CREATE',
                'description' => 'Mendaftarkan aset baru ke dalam sistem.',
            ]);
        });

        // 5. Redirect dengan pesan sukses
        return redirect()->route('assets.index')->with('success', 'Aset berhasil didaftarkan.');
    }
    
    public function show($id)
    {
        // Ambil aset beserta relasi history urut dari yang paling baru
        $asset = Asset::with(['category', 'room', 'pic', 'histories.user'])
                      ->findOrFail($id);

        return view('assets.show', compact('asset'));
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $categories = Category::all();
        $rooms = Room::all();
        $employees = Employee::where('is_active', 1)->get();

        return view('assets.edit', compact('asset', 'categories', 'rooms', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            // PENTING: Tambahkan .$asset->id di parameter ketiga rule unique
            // Format: unique:nama_tabel,nama_kolom,id_yang_diabaikan
            'asset_code'    => 'required|max:50|unique:assets,asset_code,' . $asset->id,
            
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'room_id'       => 'required|exists:rooms,id',
            'employee_id'   => 'nullable|exists:employees,id',
            'condition'     => 'required',
            'price'         => 'required|numeric',
            'purchase_date' => 'required|date',
            'image'         => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $asset) {
            
            // 1. Cek Image (Sama seperti sebelumnya)
            if ($request->hasFile('image')) {
                if ($asset->image_path && Storage::disk('public')->exists($asset->image_path)) {
                    Storage::disk('public')->delete($asset->image_path);
                }
                $imagePath = $request->file('image')->store('assets/images', 'public');
                $asset->image_path = $imagePath;
            }

            // 2. Deteksi Perubahan untuk Audit Log
            $changes = [];
            
            // Cek Mutasi Ruangan
            if ($asset->room_id != $request->room_id) {
                $oldRoom = $asset->room->name; // Nama ruangan lama (sebelum diupdate relasinya)
                // Kita simpan flag mutasi, nanti deskripsinya kita buat di bawah
                $changes[] = "MUTATION"; 
            }

            // Cek Perubahan Kode Aset (PENTING)
            if ($asset->asset_code != $request->asset_code) {
                // Jika user mengubah kode aset manual
                $changes[] = "CODE_CHANGE";
            }

            // 3. Update Data Aset
            // Simpan room_id lama dulu buat deskripsi log jika perlu
            $oldRoomName = $asset->room->name; 

            $asset->update([
                'asset_code'    => $request->asset_code, // Kode baru disimpan
                'name'          => $request->name,
                'category_id'   => $request->category_id,
                'room_id'       => $request->room_id,
                'employee_id'   => $request->employee_id,
                'condition'     => $request->condition,
                'price'         => $request->price,
                'purchase_date' => $request->purchase_date,
                'description'   => $request->description,
                // image_path sudah dihandle di atas
            ]);

            // 4. Catat Log Histori (Logic Lebih Cerdas)
            $action = 'UPDATE';
            $desc = 'Memperbarui detail data aset.';

            if (in_array("MUTATION", $changes)) {
                $action = 'MUTATION';
                // Ambil nama ruangan baru (karena $asset->room sekarang sudah menunjuk ke yg baru)
                // Kita perlu refresh model atau ambil manual, tapi karena eager load mungkin masih cache, 
                // paling aman ambil nama ruangan baru via query simple atau relasi refresh
                $asset->refresh(); 
                $newRoomName = $asset->room->name;
                $desc = "Memindahkan aset dari $oldRoomName ke $newRoomName.";
            } 
            elseif (in_array("CODE_CHANGE", $changes)) {
                $desc = "Mengubah Kode Aset (Koreksi) menjadi: " . $request->asset_code;
            }

            AssetHistory::create([
                'asset_id'    => $asset->id,
                'user_id'     => auth()->id(),
                'action'      => $action,
                'description' => $desc
            ]);
        });

        return redirect()->route('assets.show', $id)->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        DB::transaction(function () use ($asset) {
            // Catat log dulu sebelum dihapus (agar masih bisa diakses relationnya)
            AssetHistory::create([
                'asset_id'    => $asset->id,
                'user_id'     => auth()->id(),
                'action'      => 'DELETE',
                'description' => 'Menghapus aset dari daftar aktif (Soft Delete).',
            ]);

            $asset->delete(); // Soft Delete
        });

        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }

    public function printLabel($id)
    {
        $asset = Asset::with(['category', 'room'])->findOrFail($id);

        // Data yang akan dimasukkan ke dalam QR Code.
        // Idealnya adalah URL yang mengarah ke halaman detail aset tersebut.
        // Saat discan pakai HP, akan langsung membuka SIASTERA.
        $qrData = route('assets.show', $asset->id);

        // Kita gunakan view khusus yang tanpa layout master
        return view('assets.print-label', compact('asset', 'qrData'));
    }

    public function handover($id)
    {
        $asset = Asset::with(['pic', 'room'])->findOrFail($id);
        
        // Ambil semua pegawai KECUALI yang sedang memegang aset ini saat ini
        $employees = \App\Models\Employee::where('is_active', 1)
                        ->where('id', '!=', $asset->employee_id)
                        ->orderBy('name')
                        ->get();

        return view('assets.handover', compact('asset', 'employees'));
    }

    /**
     * Proses Simpan Handover
     */
    public function processHandover(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'employee_id' => 'nullable|exists:employees,id', // Nullable = kembali ke aset umum
            'description' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $asset) {
            // 1. Ambil Nama Lama dan Baru untuk Log
            $oldPicName = $asset->pic ? $asset->pic->name : 'Aset Umum (Tanpa PIC)';
            
            // Cek PIC Baru
            $newEmployee = null;
            $newPicName = 'Aset Umum (Tanpa PIC)';
            
            if ($request->employee_id) {
                $newEmployee = \App\Models\Employee::find($request->employee_id);
                $newPicName = $newEmployee->name;
            }

            // 2. Update Aset
            $asset->update([
                'employee_id' => $request->employee_id
            ]);

            // 3. Catat Histori yang Jelas
            AssetHistory::create([
                'asset_id'    => $asset->id,
                'user_id'     => auth()->id(), // Admin yang memproses
                'action'      => 'HANDOVER',
                'description' => "Serah terima aset dari: [{$oldPicName}] ke: [{$newPicName}]. " . 
                                 ($request->description ? "Catatan: {$request->description}" : "")
            ]);
        });

        return redirect()->route('assets.show', $id)->with('success', 'Peralihan penanggung jawab berhasil diproses.');
    }
}