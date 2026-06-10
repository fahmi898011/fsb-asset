@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit User</h1>
        <p class="text-muted mb-0 small">Perbarui data akun: <strong>{{ $user->username }}</strong></p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-light border bg-white shadow-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark">Form Edit Data</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
                            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Role Akses</label>
                            <select name="role" class="form-select">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="ga" {{ $user->role == 'ga' ? 'selected' : '' }}>General Affair (GA)</option>
                                <option value="auditor" {{ $user->role == 'auditor' ? 'selected' : '' }}>Auditor</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Status Akun</label>
                            <select name="is_active" class="form-select {{ $user->is_active ? 'border-success text-success fw-bold' : 'border-danger text-danger fw-bold' }}">
                                <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>AKTIF - Bisa Login</option>
                                <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>NONAKTIF - Diblokir</option>
                            </select>
                            <div class="form-text small">Jika user resign, pilih Nonaktif (jangan dihapus agar data audit aman).</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small text-muted text-uppercase fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="col-12"><hr></div>

                        <div class="col-md-12">
                            <div class="alert alert-warning small mb-3">
                                <i class="fas fa-key me-2"></i> 
                                Kosongkan kolom password jika tidak ingin mengubah/reset password user ini.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="***">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="***">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection