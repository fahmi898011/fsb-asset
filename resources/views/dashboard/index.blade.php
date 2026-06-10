@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Dashboard Overview</h1>
        <p class="text-muted mb-0 small">Ringkasan status inventaris & aktivitas terbaru.</p>
    </div>
    <div class="text-end">
        <span class="badge bg-light text-dark border px-3 py-2">
            <i class="far fa-calendar-alt me-2"></i> {{ date('d F Y') }}
        </span>
    </div>
</div>

@if($activeAudit)
<div class="alert alert-primary border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
    <div class="bg-white p-2 rounded-circle text-primary me-3">
        <i class="fas fa-clipboard-check fa-lg"></i>
    </div>
    <div class="flex-grow-1">
        <h6 class="fw-bold mb-0">Sedang Berlangsung: {{ $activeAudit->title }}</h6>
        <div class="small opacity-75">Sesi opname masih berstatus <strong>OPEN</strong>. Segera selesaikan scanning aset.</div>
    </div>
    <a href="{{ route('audits.show', $activeAudit->id) }}" class="btn btn-sm btn-light text-primary fw-bold">Lanjut Scan <i class="fas fa-arrow-right ms-1"></i></a>
</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                        <i class="fas fa-cubes fa-lg"></i>
                    </div>
                    <span class="text-uppercase text-muted small fw-bold">Total Aset</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalAssets) }} <small class="text-muted fs-6">Unit</small></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                        <i class="fas fa-money-bill-wave fa-lg"></i>
                    </div>
                    <span class="text-uppercase text-muted small fw-bold">Total Nilai Aset</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.4rem;">Rp {{ number_format($totalValue / 1000000, 1, ',', '.') }} <small class="text-muted fs-6">Juta</small></h3>
                <div class="small text-muted mt-1">Akumulasi harga perolehan</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-2 me-3">
                        <i class="fas fa-tools fa-lg"></i>
                    </div>
                    <span class="text-uppercase text-muted small fw-bold">Perlu Perbaikan</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ $brokenAssets }} <small class="text-muted fs-6">Unit</small></h3>
                <div class="small text-danger mt-1 fw-bold">
                    {{ $totalAssets > 0 ? round(($brokenAssets / $totalAssets) * 100, 1) : 0 }}% dari total aset
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-info bg-opacity-10 text-info rounded p-2 me-3">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <span class="text-uppercase text-muted small fw-bold">Kondisi Prima</span>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ $goodAssets }} <small class="text-muted fs-6">Unit</small></h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    
    <div class="col-lg-7">
        
        <div class="card border-0 shadow-sm mb-4"> <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-pie me-2 text-primary"></i> Komposisi Aset per Kategori</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-0">
                        <thead class="text-muted small text-uppercase bg-light">
                            <tr>
                                <th class="ps-3 rounded-start">Kategori</th>
                                <th>Jumlah</th>
                                <th class="rounded-end">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                            @php 
                                $percent = $totalAssets > 0 ? ($cat->assets_count / $totalAssets) * 100 : 0;
                            @endphp
                            <tr>
                                <td class="text-dark fw-bold text-muted"><small>{{ $cat->name }}</small></td>
                                <td>{{ $cat->assets_count }} Item</td>
                                <td style="width: 40%">
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="ms-2 small text-muted">{{ round($percent, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3 border-top pt-3">
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat Semua Kategori</a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-map-marker-alt me-2 text-danger"></i> Komposisi Aset per Lokasi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover align-middle mb-0">
                        <thead class="text-muted small text-uppercase bg-light">
                            <tr>
                                <th class="ps-3 rounded-start">Ruangan</th>
                                <th>Jumlah</th>
                                <th class="rounded-end">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            @php 
                                $percentRoom = $totalAssets > 0 ? ($room->assets_count / $totalAssets) * 100 : 0;
                            @endphp
                            <tr>
                                <td class="text-dark fw-bold text-muted"><small>{{ $room->name }}</small></td>
                                <td>{{ $room->assets_count }} Item</td>
                                <td style="width: 40%">
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-danger" style="width: {{ $percentRoom }}%"></div>
                                        </div>
                                        <span class="ms-2 small text-muted">{{ round($percentRoom, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3 border-top pt-3">
                    <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-light text-danger fw-bold">Lihat Semua Ruangan</a>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2 text-warning"></i> Aktivitas Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentActivities as $log)
                        <div class="list-group-item px-0 border-bottom-0 pb-3">
                            <div class="d-flex">
                                <div class="me-3 mt-1">
                                    @if($log->action == 'CREATE')
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-plus small"></i></div>
                                    @elseif($log->action == 'UPDATE' || $log->action == 'MAINTENANCE')
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-edit small"></i></div>
                                    @elseif($log->action == 'DELETE')
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-trash small"></i></div>
                                    @elseif($log->action == 'HANDOVER' || $log->action == 'MUTATION')
                                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-exchange-alt small"></i></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="small text-muted mb-1">
                                        <span class="fw-bold text-dark">{{ $log->user->name ?? 'System' }}</span> 
                                        <span class="mx-1">•</span> 
                                        {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                    </div>
                                    <p class="mb-0 small text-dark" style="line-height: 1.4;">
                                        {{ Str::limit($log->description, 60) }}
                                        <br>
                                        <span class="badge bg-light text-secondary border mt-1">{{ $log->asset->asset_code ?? 'Item Dihapus' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection