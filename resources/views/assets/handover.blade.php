@extends('layouts.app')
@section('title', 'Handover Aset')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Serah Terima Aset (Handover)</h1>
        <p class="text-muted mb-0 small">Proses perpindahan tanggung jawab penggunaan aset.</p>
    </div>
    <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                
                <div class="alert alert-light border d-flex align-items-center mb-4">
                    <i class="fas fa-box fa-2x text-primary me-3"></i>
                    <div>
                        <div class="fw-bold text-dark">{{ $asset->name }}</div>
                        <div class="text-muted small font-monospace">{{ $asset->asset_code }}</div>
                    </div>
                </div>

                <form action="{{ route('assets.process-handover', $asset->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3">Penanggung Jawab Lama</h6>
                            <div class="p-3 border rounded bg-light">
                                <i class="fas fa-user-circle fa-3x text-secondary mb-2"></i>
                                <h5 class="fw-bold text-dark mb-0">{{ $asset->pic->name ?? 'Aset Umum' }}</h5>
                                <small class="text-muted">{{ $asset->pic->position ?? '-' }}</small>
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <i class="fas fa-arrow-right fa-2x text-primary d-none d-md-block"></i>
                            <i class="fas fa-arrow-down fa-2x text-primary d-block d-md-none"></i>
                        </div>

                        <div class="col-md-5 text-center">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3">Penanggung Jawab Baru</h6>
                            <div class="p-3 border rounded bg-white shadow-sm">
                                <i class="fas fa-user-check fa-3x text-success mb-2"></i>
                                <div class="mb-2">
                                    <select name="employee_id" class="form-select form-select-sm text-center fw-bold border-success text-success">
                                        <option value="">-- Kembalikan ke Aset Umum --</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}">
                                                {{ $emp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <small class="text-muted">Pilih pegawai penerima</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <label class="form-label small fw-bold text-muted text-uppercase">Catatan / Alasan Perpindahan</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Contoh: Mutasi pegawai ke kantor cabang lain..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fas fa-exchange-alt me-2"></i> Proses Handover
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection