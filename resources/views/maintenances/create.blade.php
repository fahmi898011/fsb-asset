@extends('layouts.app')
@section('title', 'Catat Perawatan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Catat Perawatan / Servis</h1>
        <p class="text-muted mb-0 small">Aset: <strong>{{ $asset->name }}</strong> ({{ $asset->asset_code }})</p>
    </div>
    <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('maintenances.store', $asset->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">Detail Pengerjaan</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Tanggal Pengerjaan</label>
                            <input type="date" name="maintenance_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Jenis Perawatan</label>
                            <select name="type" class="form-select">
                                <option value="Perbaikan (Servis)">Perbaikan (Servis)</option>
                                <option value="Pemeliharaan Rutin">Pemeliharaan Rutin</option>
                                <option value="Penggantian Sparepart">Penggantian Sparepart</option>
                                <option value="Upgrade">Upgrade Spesifikasi</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Deskripsi / Keluhan</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Contoh: Ganti LCD Monitor yang bergaris..."></textarea>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">Biaya & Vendor</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Total Biaya (Rp)</label>
                            <input type="number" name="cost" class="form-control" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Vendor / Bengkel</label>
                            <input type="text" name="vendor" class="form-control" placeholder="Nama Toko/Teknisi">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Upload Nota/Kuitansi</label>
                            <input type="file" name="invoice" class="form-control">
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">Update Status Aset</h6>
                    <div class="alert alert-info small">
                        Apakah perawatan ini mengubah kondisi aset? (Misal: dari Rusak menjadi Baik)
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted text-uppercase fw-bold">Kondisi Akhir</label>
                        <select name="update_condition" class="form-select border-info">
                            <option value="">-- Tidak Ubah Kondisi --</option>
                            <option value="Baik">Sudah Baik / Normal</option>
                            <option value="Rusak Ringan">Masih Rusak Ringan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Data Perawatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection