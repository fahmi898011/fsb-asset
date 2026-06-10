@extends('layouts.app')
@section('title', 'Data Pegawai')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Pegawai (PIC)</h1>
        <p class="text-muted mb-0 small">Master data karyawan pemegang aset (Teller, CS, Marketing, dll).</p>
    </div>
    <a href="{{ route('employees.create') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="fas fa-user-plus me-2"></i> Tambah Pegawai
    </a>
</div>

<div class="card mb-4">
    <div class="card-body p-1">
        <form action="{{ route('employees.index') }}" method="GET">
            <div class="input-group input-group-flush">
                <span class="input-group-text bg-white border-0 ps-3"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-0" placeholder="Cari nama, NIP, atau jabatan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-white text-primary fw-bold">Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Nama Pegawai</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">NIP</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Jabatan / Divisi</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Aset Dipegang</th>
                    <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td class="ps-4 fw-bold text-dark">{{ $emp->name }}</td>
                    <td class="font-monospace text-muted">{{ $emp->nip ?? '-' }}</td>
                    <td>
                        <div class="fw-bold small">{{ $emp->position }}</div>
                        <div class="text-muted small">{{ $emp->department }}</div>
                    </td>
                    <td>
                        @if($emp->assets_count > 0)
                            <span class="badge bg-primary rounded-pill">{{ $emp->assets_count }} Item</span>
                        @else
                            <span class="badge bg-light text-muted border">0 Item</span>
                        @endif
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-light btn-sm border" title="Edit"><i class="fas fa-edit text-warning"></i></a>
                            <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pegawai ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm border" title="Hapus"><i class="fas fa-trash text-danger"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($employees->hasPages())
    <div class="card-footer bg-white border-top-0 py-3 px-4">
        <div class="d-flex justify-content-end">
            {{ $employees->links() }}
        </div>
    </div>
    @endif
</div>
@endsection