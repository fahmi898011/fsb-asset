<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        
        .footer { margin-top: 50px; width: 100%; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 200px; }
        .signature .line { border-bottom: 1px solid #000; margin-top: 60px; }

        /* Tombol Cetak (Hilang saat diprint) */
        .no-print { margin-bottom: 20px; text-align: right; }
        .btn { background: #333; color: #fff; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn">Cetak Dokumen (PDF)</button>
    </div>

    <div class="header">
        <h2>PT. Fan Sukses Bersama</h2>
        <p>Jl. Proklamasi No.47, RT.11/RW.2, Pegangsaan, Kec. Menteng, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10320</p>
        <p>Telp: 0811-1000-8008 | Email: Halo@bgn.go.id</p>
    </div>

    <h3 style="text-align: center; margin-bottom: 20px;">{{ $title }}</h3>
    <p>Tanggal Cetak: {{ date('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Kode Aset</th>
                <th style="width: 30%">Nama Barang</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 15%">Ruangan</th>
                <th style="width: 10%">Kondisi</th>
                <th style="width: 10%">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $index => $item)
            <tr>
                <td style="text-align: center">{{ $index + 1 }}</td>
                <td>{{ $item->asset_code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->room->name ?? '-' }}</td>
                <td>{{ $item->condition }}</td>
                <td>{{ \Carbon\Carbon::parse($item->purchase_date)->year }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data aset ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,</p>
            <p><strong>Kepala Bagian Umum</strong></p>
            <div class="line"></div>
        </div>
        <div class="signature">
            <p>Dibuat Oleh,</p>
            <p><strong>Staf Inventaris</strong></p>
            <div class="line"></div>
            <p>{{ Auth::user()->name }}</p>
        </div>
    </div>

</body>
</html>