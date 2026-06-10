@extends('layouts.app')

@section('title', 'Pusat Laporan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pusat Laporan</h1>
        <p class="text-muted mb-0 small">Cetak laporan inventaris untuk keperluan audit dan manajemen.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm bg-dark text-white">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-25 text-white rounded p-2 me-3">
                        <i class="fas fa-database fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Semua Data Aset</h6>
                </div>
                <p class="small opacity-75">Cetak seluruh data inventaris tanpa filter (Master Data).</p>
                
                <form action="{{ route('reports.print') }}" method="GET" target="_blank">
                    <input type="hidden" name="type" value="all">
                    <div class="mb-3" style="height: 31px;"></div> 
                    <button type="submit" class="btn btn-light w-100 fw-bold text-dark btn-sm">
                        <i class="fas fa-print me-2"></i> Cetak Master
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-3"> <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                        <i class="fas fa-door-open fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Aset per Ruangan</h6>
                </div>
                <p class="text-muted small">Cetak daftar aset berdasarkan lokasi fisik.</p>
                
                <form action="{{ route('reports.print') }}" method="GET" target="_blank">
                    <input type="hidden" name="type" value="by_room">
                    <div class="mb-3">
                        <select name="room_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">
                        <i class="fas fa-print me-2"></i> Cetak
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                        <i class="fas fa-tags fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Aset per Kategori</h6>
                </div>
                <p class="text-muted small">Daftar aset berdasarkan kelompok barang.</p>
                
                <form action="{{ route('reports.print') }}" method="GET" target="_blank">
                    <input type="hidden" name="type" value="by_category">
                    <div class="mb-3">
                        <select name="category_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-success btn-sm w-100 fw-bold">
                        <i class="fas fa-print me-2"></i> Cetak
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                        <i class="fas fa-user-tie fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Aset per PIC</h6>
                </div>
                <p class="text-muted small">Daftar tanggung jawab aset per pegawai.</p>
                
                <form action="{{ route('reports.print') }}" method="GET" target="_blank">
                    <input type="hidden" name="type" value="by_employee">
                    <div class="mb-3">
                        <select name="employee_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Pegawai --</option>
                            <option value="no_pic" class="fw-bold text-danger">-- Aset Umum (Non-PIC) --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-info text-info btn-sm w-100 fw-bold">
                        <i class="fas fa-print me-2"></i> Cetak
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3">
                        <i class="fas fa-exclamation-triangle fa-lg"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Laporan Kondisi</h6>
                </div>
                <p class="text-muted small">Filter berdasarkan kondisi fisik aset.</p>
                
                <form action="{{ route('reports.print') }}" method="GET" target="_blank">
                    <input type="hidden" name="type" value="by_condition">
                    <div class="mb-3">
                        <select name="condition" class="form-select form-select-sm" required>
                            <option value="Rusak Berat">Rusak Berat</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Baik">Baik</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold">
                        <i class="fas fa-print me-2"></i> Cetak
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection