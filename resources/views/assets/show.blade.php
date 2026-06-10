@extends('layouts.app')

@section('title', 'Detail Aset')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $asset->name }}</h1>
        <div class="text-muted small">
            <i class="fas fa-barcode me-1"></i> {{ $asset->asset_code }} 
            <span class="mx-2">•</span> 
            Terdaftar sejak {{ $asset->created_at->format('d M Y') }}
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('assets.index') }}" class="btn btn-light border bg-white shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
        <a href="{{ route('assets.print-label', $asset->id) }}" target="_blank" class="btn btn-secondary border shadow-sm fw-bold">
            <i class="fas fa-qrcode me-2"></i> Label
        </a>
        <a href="{{ route('maintenances.create', $asset->id) }}" class="btn btn-primary border shadow-sm fw-bold">
            <i class="fas fa-tools me-2"></i> Servis
        </a>
        <a href="{{ route('assets.handover', $asset->id) }}" class="btn btn-primary border shadow-sm fw-bold">
            <i class="fas fa-people-arrows me-2"></i> Handover
        </a>
        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-warning text-white shadow-sm">
            <i class="fas fa-edit me-2"></i> Edit Data
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        @if($asset->image_path)
                            <img src="{{ asset('storage/' . $asset->image_path) }}" class="img-fluid rounded shadow-sm border" alt="Foto Aset">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="height: 200px;">
                                <div class="text-center">
                                    <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                                    <p class="small mb-0">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h5 class="fw-bold text-dark mb-3">Status Terkini</h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="small text-muted text-uppercase fw-bold">Lokasi</label>
                                <div class="fw-bold text-dark"><i class="fas fa-door-open text-primary me-2"></i> {{ $asset->room->name ?? '-' }}</div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted text-uppercase fw-bold">Penanggung Jawab</label>
                                <div class="fw-bold text-dark"><i class="fas fa-user-circle text-primary me-2"></i> {{ $asset->pic->name ?? 'Aset Umum' }}</div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted text-uppercase fw-bold">Kondisi</label>
                                <div>
                                    @if($asset->condition == 'Baik')
                                        <span class="badge bg-success">BAIK</span>
                                    @elseif($asset->condition == 'Rusak Ringan')
                                        <span class="badge bg-warning text-dark">RUSAK RINGAN</span>
                                    @else
                                        <span class="badge bg-danger">RUSAK BERAT</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted text-uppercase fw-bold">Nilai Aset</label>
                                <div class="fw-bold text-dark">Rp {{ number_format($asset->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white border-bottom pt-4 pb-2">
                <h6 class="fw-bold text-dark">Spesifikasi & Dokumen</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted w-25">Kategori</td>
                        <td class="fw-bold">{{ $asset->category->name ?? '-' }} ({{ $asset->category->code ?? '' }})</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Perolehan</td>
                        <td class="fw-bold">{{ \Carbon\Carbon::parse($asset->purchase_date)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keterangan</td>
                        <td>{{ $asset->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dokumen Nota</td>
                        <td>
                            @if($asset->document_path)
                                <a href="{{ asset('storage/' . $asset->document_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-1"></i> Lihat Dokumen
                                </a>
                            @else
                                <span class="text-muted small fst-italic">Tidak ada dokumen diupload.</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white border-bottom pt-4 pb-2">
                <h6 class="fw-bold text-dark">Riwayat Perawatan</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0 table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3 py-2 small text-muted">Tgl</th>
                            <th class="py-2 small text-muted">Info</th>
                            <th class="pe-3 py-2 text-end small text-muted">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($asset->maintenances as $mt)
                        <tr>
                            <td class="ps-3 small border-bottom">{{ \Carbon\Carbon::parse($mt->maintenance_date)->format('d/m/y') }}</td>
                            <td class="small border-bottom">
                                <div class="fw-bold">{{ $mt->type }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ Str::limit($mt->vendor, 15) }}</div>
                            </td>
                            <td class="pe-3 text-end small border-bottom fw-bold">
                                {{ number_format($mt->cost / 1000, 0) }}k
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted small">Belum ada servis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white border-bottom pt-4 pb-2">
                <h6 class="fw-bold text-dark">Riwayat Aset (Audit Trail)</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($asset->histories as $history)
                        <div class="timeline-item pb-4 position-relative border-start ps-4 ms-2" style="border-color: #e2e8f0 !important;">
                            <div class="position-absolute start-0 top-0 translate-middle bg-white border border-2 border-primary rounded-circle" style="width: 12px; height: 12px;"></div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-light text-dark border">{{ $history->action }}</span>
                                <small class="text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($history->created_at)->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 small text-dark">{{ $history->description }}</p>
                            <div class="small text-muted" style="font-size: 11px;">
                                Oleh: <span class="fw-bold">{{ $history->user->name ?? 'System' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center small">Belum ada riwayat tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection