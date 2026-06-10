@extends('layouts.app')

@section('title', 'Edit Aset')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Data Aset</h1>
        <p class="text-muted mb-0 small">Perbarui informasi aset: <strong>{{ $asset->asset_code }}</strong></p>
    </div>
    <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-times me-1"></i> Batal
    </a>
</div>

<form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold mb-0">Informasi Utama</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kode Aset</label>
                            
                            <input type="text" 
                                   name="asset_code" 
                                   class="form-control fw-bold text-dark bg-light" 
                                   value="{{ old('asset_code', $asset->asset_code) }}">
                            
                            @error('asset_code') <small class="text-danger">{{ $message }}</small> @enderror
                            
                            <div class="form-text text-danger small">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Hati-hati! Mengubah kode ini akan membuat Label QR Code fisik menjadi tidak valid.
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Barang</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $asset->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kategori</label>
                            <select name="category_id" class="form-select">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $asset->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kondisi</label>
                            <select name="condition" class="form-select">
                                <option value="Baik" {{ $asset->condition == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ $asset->condition == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ $asset->condition == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $asset->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold mb-0">Update Nilai & Gambar</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Tanggal Beli</label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', $asset->purchase_date) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Harga (IDR)</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $asset->price) }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Ganti Foto (Opsional)</label>
                            <div class="d-flex align-items-center gap-3">
                                @if($asset->image_path)
                                    <img src="{{ asset('storage/' . $asset->image_path) }}" width="50" class="rounded border">
                                @endif
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-text small">Biarkan kosong jika tidak ingin mengganti foto.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold mb-0">Mutasi / Pemindahan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted text-uppercase fw-bold">Lokasi Ruangan</label>
                        <select name="room_id" class="form-select bg-light border-primary">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ $asset->room_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text text-primary small"><i class="fas fa-info-circle"></i> Mengubah ruangan akan tercatat sebagai "Mutasi" di riwayat.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penanggung Jawab (PIC)</label>
                        <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror">
                            <option value="">-- Aset Umum (Tanpa PIC) --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('employee_id', $asset->employee_id ?? '') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} - {{ $emp->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection