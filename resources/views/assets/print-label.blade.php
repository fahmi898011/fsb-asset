<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Label Aset - {{ $asset->asset_code }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
        }

        .label-container {
            width: 8cm;
            height: 3.5cm;
            background: white;
            border: 1px solid #000;
            padding: 5px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .qr-area {
            flex: 0 0 35%;
            text-align: center;
        }
        
        .info-area {
            flex: 1;
            padding-left: 10px;
            font-size: 9px;
            line-height: 1.3;
        }

        .company-name {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 8px;
            margin-bottom: 5px;
        }

        .asset-code {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }

        .asset-name {
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap; 
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 3.5cm;
        }

        .no-print-bar {
            background: #fff; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
        }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: 600; font-size: 14px;}
        .btn-primary { background: #2563eb; color: white; border: none; cursor: pointer;}
        .btn-secondary { background: #e2e8f0; color: #333; border: 1px solid #cbd5e1;}

        @media print {
            body { padding: 0; background: white; }
            .no-print-bar { display: none !important; }
            .label-container {
                border: none;
                margin: 0 auto;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <div>
            <strong>Preview Label</strong>
            <div style="font-size: 12px; color: #666;">Pastikan ukuran kertas printer sesuai.</div>
        </div>
        <div>
            <a href="javascript:window.close()" class="btn btn-secondary" style="margin-right: 10px;">Tutup</a>
            <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Label</button>
        </div>
    </div>

    <div class="label-container">
        <div class="qr-area">
            {!! QrCode::size(70)->generate($qrData) !!}
        </div>
        
        <div class="info-area">
            <div class="company-name">INVENTARIS BPRS-AMT</div>
            <div class="asset-code">{{ $asset->asset_code }}</div>
            <div class="asset-name">{{ Str::limit($asset->name, 25) }}</div>
            
            <div><small>Lokasi: {{ Str::limit($asset->room->name ?? '-', 30) }}</small></div>
            
            <div><small>Tgl: {{ $asset->purchase_date ? date('d/m/Y', strtotime($asset->purchase_date)) : '-' }}</small></div>
        </div>
    </div>

</body>
</html>