@extends('layouts.app')

@section('title', 'Tambah Aset')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Registrasi Aset Baru</h1>
        <p class="text-muted mb-0 small">Pastikan data fisik sesuai sebelum input.</p>
    </div>
    <a href="{{ route('assets.index') }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

@if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">Gagal Menyimpan Data!</h5>
                    <ul class="mb-0 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold mb-0 text-dark">Informasi Aset</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kode Aset</label>
                            
                            <div class="input-group">
                                <input type="text" 
                                       id="asset_code_input"
                                       name="asset_code" 
                                       class="form-control fw-bold text-primary @error('asset_code') is-invalid @enderror" 
                                       value="{{ old('asset_code', $newCode) }}" 
                                       placeholder="Auto Generate / Manual">
                                
                                <button class="btn btn-light border" type="button" onclick="resetCode()" title="Generate Ulang Kode">
                                    <i class="fas fa-sync-alt text-muted"></i>
                                </button>
                            </div>
                            
                            @error('asset_code') <small class="text-danger">{{ $message }}</small> @enderror
                            <div class="form-text small">Kode otomatis terisi, namun bisa diedit manual.</div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Barang</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: MacBook Pro M2">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kategori</label>
                            <select name="category_id" class="form-select">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kondisi Fisik</label>
                            <select name="condition" class="form-select">
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Deskripsi / Spesifikasi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Warna, No Seri, Spesifikasi detail...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold mb-0 text-dark">Nilai & Dokumen</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Tanggal Perolehan</label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Harga Perolehan (IDR)</label>
                            <input type="number" name="price" class="form-control" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Foto Barang</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nota / BAST</label>
                            <input type="file" name="document" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h6 class="fw-bold mb-0 text-dark">Penempatan & PIC</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted text-uppercase fw-bold">Lokasi Ruangan</label>
                        <select name="room_id" class="form-select" size="15">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id') <small class="text-danger">{{ $message }}</small> @enderror
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
                        <i class="fas fa-save me-2"></i> Simpan Aset
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function resetCode() {
        // Mengembalikan nilai ke kode otomatis dari server
        document.getElementById('asset_code_input').value = "{{ $newCode }}";
    }
</script>
@endpush