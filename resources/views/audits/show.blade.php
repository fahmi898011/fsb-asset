@extends('layouts.app')
@section('title', 'Proses Opname')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $session->title }}</h1>
        <p class="text-muted mb-0 small">Scan barcode aset untuk menandai keberadaan.</p>
    </div>
    <form action="{{ route('audits.close', $session->id) }}" method="POST" onsubmit="return confirm('Tutup sesi ini? Anda tidak bisa scan lagi setelah ini.')">
        @csrf
        <button class="btn btn-danger shadow-sm fw-bold"><i class="fas fa-lock me-2"></i> Tutup Sesi & Lihat Hasil</button>
    </form>
</div>

<div class="card mb-4 border-0 shadow-sm bg-primary text-white">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-bold">Progres Pengerjaan</span>
            <span class="fw-bold">{{ number_format($progress, 1) }}%</span>
        </div>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progress }}%"></div>
        </div>
        <div class="mt-2 small opacity-75">
            Sudah discan: <strong>{{ $scannedCount }}</strong> dari <strong>{{ $totalAssets }}</strong> total aset.
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white pt-4 pb-0 border-0">
                <h6 class="fw-bold"><i class="fas fa-barcode me-2"></i> Input / Scan Barcode</h6>
            </div>
            <div class="card-body p-4">
                
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="fas fa-check-circle me-2 fa-lg"></i> 
                        <div>{{ session('success') }}</div>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="fas fa-times-circle me-2 fa-lg"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="{{ route('audits.scan', $session->id) }}" method="POST" autocomplete="off" id="scanForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Mode Scanner (Barcode)</label>
                        <input type="text" id="mainInput" name="asset_code" class="form-control form-control-lg fw-bold text-center" placeholder="Scan barcode di sini..." autofocus>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">
                            <i class="fas fa-check me-2"></i> CEK ASET
                        </button>
                        
                        <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-toggle="modal" data-bs-target="#manualSearchModal">
                            <i class="fas fa-search me-2"></i> Cari Manual / Tanpa Barcode
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white pt-4 pb-0 border-0">
                <h6 class="fw-bold">Baru Saja Discan</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <tbody>
                        @forelse($recentScans as $scan)
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="fw-bold">{{ $scan->asset->asset_code }}</span>
                            </td>
                            <td>{{ Str::limit($scan->asset->name, 20) }}</td>
                            <td class="text-muted small text-end pe-4">
                                {{ \Carbon\Carbon::parse($scan->scanned_at)->format('H:i:s') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-muted py-5">Belum ada aktivitas scan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="modal fade" id="manualSearchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Cari Aset Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                    <input type="text" id="manualSearchInput" class="form-control" placeholder="Ketik nama barang (Min. 3 huruf)...">
                </div>

                <div id="searchResults" class="list-group list-group-flush border rounded overflow-auto" style="max-height: 300px; display: none;">
                    </div>
                
                <div id="searchLoading" class="text-center py-3" style="display: none;">
                    <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                    <span class="ms-2 small text-muted">Mencari data...</span>
                </div>

                <div id="searchEmpty" class="text-center py-4 text-muted small" style="display: none;">
                    <i class="fas fa-box-open mb-2"></i><br>
                    Data tidak ditemukan.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('manualSearchInput');
        const resultsContainer = document.getElementById('searchResults');
        const loading = document.getElementById('searchLoading');
        const emptyState = document.getElementById('searchEmpty');
        const mainInput = document.getElementById('mainInput');
        const scanForm = document.getElementById('scanForm');
        let timeout = null;

        // Saat modal dibuka, otomatis fokus ke input search
        const myModal = document.getElementById('manualSearchModal');
        myModal.addEventListener('shown.bs.modal', function () {
            searchInput.focus();
        });

        // Event listener saat mengetik
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;

            // Reset tampilan
            resultsContainer.style.display = 'none';
            emptyState.style.display = 'none';
            
            if (query.length < 3) return; // Minimal 3 huruf baru cari

            loading.style.display = 'block';

            // Delay pencarian (debounce) agar tidak spam server
            timeout = setTimeout(() => {
                fetch(`{{ route('audits.search-ajax') }}?q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        loading.style.display = 'none';
                        resultsContainer.innerHTML = ''; // Kosongkan hasil lama

                        if (data.length > 0) {
                            resultsContainer.style.display = 'block';
                            
                            data.forEach(asset => {
                                // Buat elemen item list
                                const item = document.createElement('button');
                                item.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3';
                                item.type = 'button';
                                
                                // Isi konten item
                                item.innerHTML = `
                                    <div>
                                        <div class="fw-bold text-dark">${asset.name}</div>
                                        <div class="small text-muted font-monospace">${asset.asset_code}</div>
                                        <div class="badge bg-light text-dark border mt-1">
                                            <i class="fas fa-map-marker-alt me-1"></i> ${asset.room ? asset.room.name : '-'}
                                        </div>
                                    </div>
                                    <div class="text-primary fw-bold small">
                                        PILIH <i class="fas fa-chevron-right ms-1"></i>
                                    </div>
                                `;

                                // Saat item dipilih
                                item.addEventListener('click', function() {
                                    // 1. Masukkan kode aset ke input utama di belakang layar
                                    mainInput.value = asset.asset_code;
                                    
                                    // 2. Submit form utama seolah-olah baru discan
                                    scanForm.submit();
                                });

                                resultsContainer.appendChild(item);
                            });
                        } else {
                            emptyState.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loading.style.display = 'none';
                    });
            }, 500); // Tunggu 500ms setelah selesai mengetik
        });
    });
</script>