@extends('layouts.app')
@section('title', 'Edit Pegawai')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Pegawai</h1>
        <p class="text-muted mb-0 small">Update data: <strong>{{ $employee->name }}</strong></p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark">Form Edit Pegawai</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip', $employee->nip) }}">
                            @error('nip') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-12"><hr></div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Jabatan</label>
                            <input type="text" name="position" class="form-control" value="{{ old('position', $employee->position) }}">
                            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Divisi / Bagian</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $employee->department) }}">
                            @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">No. Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
                        </div>

                         <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik', $employee->nik) }}">
                            @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $employee->alamat) }}">
                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-12 mt-3">
                             <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeCheck" {{ $employee->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="activeCheck">Status Pegawai Aktif</label>
                            </div>
                            <div class="form-text small">Jika tidak aktif, pegawai tidak akan muncul di pilihan penanggung jawab aset baru.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection