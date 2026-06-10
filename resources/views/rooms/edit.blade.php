@extends('layouts.app')
@section('title', 'Edit Ruangan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Ruangan</h1>
        <p class="text-muted mb-0 small">Perbarui data lokasi: <strong>{{ $room->name }}</strong></p>
    </div>
    <a href="{{ route('rooms.index') }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark">Form Edit Ruangan</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-bold">Kode Ruangan</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code', $room->code) }}" maxlength="10">
                            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Ruangan</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Lokasi (Lantai/Gedung)</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $room->location) }}">
                            @error('location') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Keterangan</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $room->description) }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('rooms.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection