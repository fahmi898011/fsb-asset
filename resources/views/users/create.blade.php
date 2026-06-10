@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah User Baru</h1>
        <p class="text-muted mb-0 small">Daftarkan pegawai atau administrator baru.</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark">Form Registrasi User</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="tanpa spasi" value="{{ old('username') }}">
                            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Role Akses</label>
                            <select name="role" class="form-select">
                                <option value="ga">General Affair (GA)</option>
                                <option value="admin">Administrator</option>
                                <option value="auditor">Auditor (Read Only)</option>
                            </select>
                            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Email (Opsional)</label>
                            <input type="email" name="email" class="form-control" placeholder="user@bprs.co.id" value="{{ old('email') }}">
                        </div>

                        <div class="col-12"><hr></div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="alert alert-info d-flex align-items-center mt-4 small">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>User baru otomatis berstatus <strong>AKTIF</strong> saat dibuat.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection