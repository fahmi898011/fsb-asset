@extends('layouts.app')
@section('title', 'Laporan Hasil Opname')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan: {{ $session->title }}</h1>
        <p class="text-muted mb-0 small">
            Status: 
            @if($session->status == 'open')
                <span class="badge bg-success">SEDANG BERJALAN (OPEN)</span>
            @else
                <span class="badge bg-secondary">DITUTUP (CLOSED)</span>
            @endif
        </p>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('audits.index') }}" class="btn btn-light border bg-white shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        @if($session->status == 'open')
            <a href="{{ route('audits.show', $session->id) }}" class="btn btn-primary shadow-sm fw-bold">
                <i class="fas fa-barcode me-2"></i> Lanjut Scan
            </a>
        @else
            <form action="{{ route('audits.reopen', $session->id) }}" method="POST" onsubmit="return confirm('Buka kembali sesi ini untuk melanjutkan proses audit?')">
                @csrf
                <button type="submit" class="btn btn-warning text-dark shadow-sm fw-bold">
                    <i class="fas fa-lock-open me-2"></i> Buka Kembali Sesi
                </button>
            </form>
        @endif
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-start border-4 border-success p-3">
            <h6 class="text-uppercase text-muted fw-bold small">Aset Ditemukan</h6>
            <h2 class="fw-bold text-success mb-0">{{ $scannedCount }} <small class="fs-6 text-muted">Unit</small></h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-start border-4 border-danger p-3">
            <h6 class="text-uppercase text-muted fw-bold small">Selisih / Belum Ditemukan</h6>
            <h2 class="fw-bold text-danger mb-0">{{ $totalAssets - $scannedCount }} <small class="fs-6 text-muted">Unit</small></h2>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Daftar Aset Belum Discan (Missing List)</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Kode Aset</th>
                    <th>Nama Barang</th>
                    <th>Lokasi Sistem</th>
                    <th>Penanggung Jawab</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($missingAssets as $asset)
                <tr>
                    <td class="ps-4 fw-bold text-danger">{{ $asset->asset_code }}</td>
                    <td>{{ $asset->name }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $asset->room->name ?? '-' }}</span></td>
                    <td>{{ $asset->pic->name ?? '-' }}</td>
                    <td class="text-end pe-4">
                        @if($session->status == 'open')
                            <form action="{{ route('audits.mark-found', ['id' => $session->id, 'assetId' => $asset->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success fw-bold" title="Tandai aset ini ditemukan secara manual">
                                    <i class="fas fa-check me-1"></i> Ada
                                </button>
                            </form>
                        @else
                            <span class="text-muted small fs-italic">Sesi Tertutup</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-success">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h5 class="fw-bold">Luar Biasa!</h5>
                        <p>Tidak ada selisih. Semua aset telah ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection