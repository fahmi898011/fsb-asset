@extends('layouts.app')
@section('title', 'Stock Opname')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Stock Opname</h1>
        <p class="text-muted mb-0 small">Audit fisik aset berkala.</p>
    </div>
    <button class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#newAuditModal">
        <i class="fas fa-plus me-2"></i> Mulai Opname Baru
    </button>
</div>

<div class="card">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-4">Judul Opname</th>
                <th>Tanggal Mulai</th>
                <th>Auditor</th>
                <th>Progres</th>
                <th>Status</th>
                <th class="text-end pe-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
            <tr>
                <td class="ps-4 fw-bold">{{ $session->title }}</td>
                <td>{{ \Carbon\Carbon::parse($session->start_date)->format('d M Y') }}</td>
                <td>{{ $session->auditor->name }}</td>
                <td>
                    <span class="badge bg-light text-dark border">{{ $session->results_count }} Item Scanned</span>
                </td>
                <td>
                    @if($session->status == 'open')
                        <span class="badge bg-success rounded-pill">OPEN</span>
                    @else
                        <span class="badge bg-secondary rounded-pill">CLOSED</span>
                    @endif
                </td>
                <td class="text-end pe-4">
                    @if($session->status == 'open')
                        <a href="{{ route('audits.show', $session->id) }}" class="btn btn-sm btn-primary">Lanjut Scan</a>
                    @else
                        <a href="{{ route('audits.report', $session->id) }}" class="btn btn-sm btn-light border">Lihat Laporan</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5">Belum ada sesi opname.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade" id="newAuditModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('audits.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Buka Sesi Opname</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Sesi</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Opname Q1 2025" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Mulai Sesi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection