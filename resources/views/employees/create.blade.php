@extends('layouts.app')
@section('title', 'Tambah Pegawai')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Pegawai Baru</h1>
        <p class="text-muted mb-0 small">Registrasi data karyawan untuk penanggung jawab aset.</p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark">Form Biodata Pegawai</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Asep Sunandar" value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted text-uppercase fw-bold">NIP (Opsional)</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}">
                            @error('nip') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-12"><hr></div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Jabatan</label>
                            <input type="text" name="position" class="form-control" placeholder="Contoh: Marketing / Teller / CS" value="{{ old('position') }}">
                            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Divisi / Bagian</label>
                            <input type="text" name="department" class="form-control" placeholder="Contoh: Operasional / Bisnis" value="{{ old('department') }}">
                            @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">No. Telepon / HP (Opsional)</label>
                            <input type="text" name="phone" class="form-control" placeholder="08..." value="{{ old('phone') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">NIK</label>
                            <input type="text" name="nik" class="form-control" placeholder="Contoh: 3328..." value="{{ old('nik') }}">
                            @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Contoh: email@gmail.com" value="{{ old('email') }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Alamat</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jl.perintis" value="{{ old('alamat') }}">
                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection