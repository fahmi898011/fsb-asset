@extends('layouts.app')
@section('title', 'Master Ruangan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Master Ruangan</h1>
        <p class="text-muted mb-0 small">Lokasi fisik penyimpanan aset (Gedung/Lantai).</p>
    </div>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i> Tambah Baru
    </a>
</div>

<div class="card mb-4">
    <div class="card-body p-1">
        <form action="{{ route('rooms.index') }}" method="GET">
            <div class="input-group input-group-flush">
                <span class="input-group-text bg-white border-0 ps-3"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-0" placeholder="Cari kode, nama ruangan, atau lokasi..." value="{{ request('search') }}">
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
                    <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Kode</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Nama Ruangan</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Lokasi</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Aset Tersimpan</th>
                    <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td class="ps-4">
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">{{ $room->code }}</span>
                    </td>
                    <td class="fw-bold text-dark">{{ $room->name }}</td>
                    <td class="text-muted small"><i class="fas fa-map-pin me-1"></i> {{ $room->location }}</td>
                    <td>
                        <span class="badge bg-light text-dark border rounded-pill">{{ $room->assets_count }} Item</span>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="btn-group">
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-light btn-sm border" title="Edit"><i class="fas fa-edit text-warning"></i></a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus ruangan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm border" title="Hapus"><i class="fas fa-trash text-danger"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fas fa-door-closed fa-2x mb-3 opacity-25"></i>
                        <p>Tidak ada data ruangan ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rooms->hasPages())
    <div class="card-footer bg-white border-top-0 py-3 px-4">
        <div class="d-flex justify-content-end">
            {{ $rooms->links() }}
        </div>
    </div>
    @endif
</div>
@endsection