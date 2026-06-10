<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter Role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Form Tambah User
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Simpan User Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:users,username',
            'role'      => 'required|in:admin,ga,auditor',
            'password'  => 'required|string|min:6|confirmed', // butuh field password_confirmation
        ]);

        User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email, // Opsional
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => 1,
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Form Edit User
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update Data User
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:users,username,' . $user->id,
            'role'      => 'required|in:admin,ga,auditor',
            'password'  => 'nullable|string|min:6|confirmed', // Nullable: jika kosong berarti tidak ganti password
        ]);

        $data = [
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ];

        // Jika password diisi, update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user diperbarui.');
    }

    /**
     * Hapus User (Hati-hati dengan Foreign Key)
     */
    public function destroy(User $user)
    {
        // Cek apakah user ini pernah melakukan transaksi aset (punya history)
        // Kita asumsikan relasi 'assets' adalah barang yang dia pegang
        // Tapi kita juga harus cek di tabel 'asset_histories' (user_id) apakah dia pernah input data
        
        // Cek 1: Sedang pegang aset?
        if ($user->assets()->count() > 0) {
            return back()->withErrors(['Gagal: User ini masih menjadi Penanggung Jawab aset. Pindahkan asetnya dulu.']);
        }

        // Jika aman, hapus
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika gagal karena FK constraint (misal ada di history log)
            return back()->withErrors(['Gagal: User ini tercatat dalam sejarah audit (Log). Silakan nonaktifkan akunnya saja (jangan dihapus).']);
        }
    }
}