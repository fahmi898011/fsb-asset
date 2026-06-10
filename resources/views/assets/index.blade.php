@extends('layouts.app')

@section('title', 'Data Inventaris')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Inventaris</h1>
        <p class="text-muted mb-0 small">Kelola seluruh aset tetap dan inventaris kantor.</p>
    </div>
    <a href="{{ route('assets.create') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i> Tambah Baru
    </a>
</div>

<div class="card mb-4">
    <div class="card-body p-1">
        <form action="{{ route('assets.index') }}" method="GET" class="d-flex gap-2">
            <div class="input-group input-group-flush">
                <span class="input-group-text bg-white border-0 ps-3"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-0" placeholder="Cari berdasarkan nama aset atau kode..." value="{{ request('search') }}">
            </div>
            <div class="vr my-2"></div>
            <select name="room_id" class="form-select border-0 w-auto" style="min-width: 200px;" onchange="this.form.submit()">
                <option value="">Semua Lokasi</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="d-none">Filter</button> </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Detail Aset</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Kategori</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Lokasi</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">Status/Kondisi</th>
                    <th class="py-3 text-uppercase text-muted small fw-bold">PIC</th>
                    <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets as $asset)
                <tr>
                    <td class="ps-4">
                        <div class="fw-bold text-dark">{{ $asset->name }}</div>
                        <div class="text-muted small font-monospace">{{ $asset->asset_code }}</div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $asset->category->name ?? '-' }}</span>
                    </td>
                    <td>
                        <div class="text-dark small"><i class="fas fa-map-marker-alt text-muted me-1"></i> {{ $roomName = $asset->room->name ?? '-' }}</div>
                    </td>
                    <td>
                        @php
                            $statusClass = match($asset->condition) {
                                'Baik' => 'success',
                                'Rusak Ringan' => 'warning',
                                'Rusak Berat' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <div class="d-flex align-items-center">
                            <span class="dot bg-{{ $statusClass }} me-2" style="width: 8px; height: 8px; border-radius: 50%;"></span>
                            <span class="small text-{{ $statusClass }} fw-bold">{{ $asset->condition }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="small">{{ $asset->pic->name ?? '-' }}</div>
                    </td>
                    
                    <td class="pe-4 text-end text-nowrap">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-light border shadow-sm" title="Lihat Detail">
                                <i class="fas fa-eye text-info"></i>
                            </a>

                            <a href="{{ route('assets.print-label', $asset->id) }}" target="_blank" class="btn btn-sm btn-light border shadow-sm" title="Cetak QR Code">
                                <i class="fas fa-qrcode text-dark"></i>
                            </a>

                            <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-light border shadow-sm" title="Edit Data">
                                <i class="fas fa-edit text-warning"></i>
                            </a>

                            <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border shadow-sm" title="Hapus Aset">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted mb-2"><i class="fas fa-inbox fa-2x opacity-25"></i></div>
                        <p class="text-muted mb-0">Tidak ada data aset ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($assets->hasPages())
    <div class="card-footer bg-white border-top-0 py-3 px-4">
        <div class="d-flex justify-content-end">
            {{ $assets->links() }}
        </div>
    </div>
    @endif
</div>
@endsection