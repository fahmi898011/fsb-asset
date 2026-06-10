@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen User</h1>
        <p class="text-muted mb-0 small">Kelola akses pegawai dan administrator sistem.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="fas fa-user-plus me-2"></i> Tambah User
    </a>
</div>

<div class="card mb-4">
    <div class="card-body p-1">
        <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group input-group-flush">
                <span class="input-group-text bg-white border-0 ps-3"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-0" placeholder="Cari nama atau username..." value="{{ request('search') }}">
            </div>
            <div class="vr my-2"></div>
            <select name="role" class="form-select border-0 w-auto" onchange="this.form.submit()" style="min-width: 150px;">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="ga" {{ request('role') == 'ga' ? 'selected' : '' }}>General Affair</option>
                <option value="auditor" {{ request('role') == 'auditor' ? 'selected' : '' }}>Auditor</option>
            </select>
            <button type="submit" class="d-none">Cari</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">User</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Username</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Role</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Status</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Terdaftar</th>
                    <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3 border" style="width: 40px; height: 40px;">
                                <span class="fw-bold text-secondary">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="font-monospace text-dark">{{ $user->username }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">Administrator</span>
                        @elseif($user->role == 'ga')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">General Affair</span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 text-dark">Auditor</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success rounded-pill">Aktif</span>
                        @else
                            <span class="badge bg-secondary rounded-pill">Nonaktif</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light btn-sm border" title="Edit"><i class="fas fa-edit text-warning"></i></a>
                            
                            @if(auth()->id() != $user->id) {{-- Tidak boleh hapus diri sendiri --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm border" title="Hapus"><i class="fas fa-trash text-danger"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fas fa-users fa-2x mb-3 opacity-25"></i>
                        <p>Tidak ada data user ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white border-top-0 py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection