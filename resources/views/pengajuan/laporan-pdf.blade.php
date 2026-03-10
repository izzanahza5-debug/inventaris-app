<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Pengajuan Barang</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px; /* Dikecilkan sedikit agar muat banyak kolom */
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1a3a5f;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header-table td { vertical-align: middle; }
        .header-table h2 { color: #1a3a5f; margin: 0; text-transform: uppercase; font-size: 18px; }
        .header-table p { color: #666; margin: 5px 0 0 0; font-size: 11px; }
        .logo-header { width: 80px; height: auto; }
        .logo-header1 { width: 90px; height: auto; }

        /* Info Filter (Pengganti Info Pengajuan) */
        .filter-info {
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .filter-info td { padding: 2px 5px 2px 0; }
        .label { font-weight: bold; width: 100px; color: #555; }

        /* Tabel Data Barang */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #1a3a5f; color: #fff; padding: 10px; text-align: left; font-size: 11px; border: 1px solid #1a3a5f; }
        .data-table td { border: 1px solid #e1e1e1; padding: 6px 8px; font-size: 11px; vertical-align: top;}
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }
        .text-center { text-align: center; }

        /* Status Badge */
        .status-text { font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .text-pending { color: #d97706; }
        .text-disetujui { color: #059669; }
        .text-ditolak { color: #dc2626; }
        .text-selesai { color: #2563eb; }

        /* Metadata Cetak */
        .print-info {
            margin-top: 15px;
            font-size: 10px;
            color: #777;
            font-style: italic;
            float: left;
        }

        /* Tanda Tangan (1 Kolom di Kanan) */
        .approval-block {
            margin-top: 30px;
            width: 250px;
            float: right;
            page-break-inside: avoid;
            text-align: center;
        }

        .date-text {
            margin-bottom: 15px;
        }

        .ttd-title {
            font-weight: bold;
            margin-bottom: 60px;
            display: block;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
            display: block;
        }
        
        .clear { clear: both; }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td width="70">
                <img class="logo-header" src="{{ public_path('img/logo-alazhar.png') }}" alt="Logo Sekolah">
            </td>
            <td style="text-align: center;">
                <h2>LAPORAN DATA PENGAJUAN BARANG</h2>
                <p style="margin: 0px;">Sekolah Islam Al-Azhar Pekalongan</p>
                <p style="margin: 0px; font-size: 10px;">Jl. Pelita II, Banyurip Alit, Kec. Pekalongan Sel., Kota Pekalongan</p>
            </td>
            <td width="70" style="text-align: right;">
                <img class="logo-header1" src="{{ public_path('img/sigma.png') }}" alt="Logo Yayasan">
            </td>
        </tr>
    </table>

    <table class="filter-info">
        <tr>
            <td class="label">Periode Tanggal</td>
            <td>: {{ $filterInfo['tgl_mulai'] }} s/d {{ $filterInfo['tgl_selesai'] }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%" class="text-center">No</th>
                <th width="15%">No. Pengajuan</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pemohon</th>
                <th width="22%">Nama Barang</th>
                <th width="5%" class="text-center">Qty</th>
                <th width="15%">Harga Satuan</th>
                <th width="15%" class="text-center justify-content-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($data as $pengajuan)
                @php 
                    $detailCount = $pengajuan->details->count(); 
                    // Menentukan warna status
                    $statusClass = 'text-' . strtolower($pengajuan->status);
                @endphp
                
                @foreach ($pengajuan->details as $index => $item)
                    <tr>
                        @if ($index == 0)
                            <td rowspan="{{ $detailCount }}" class="text-center">{{ $no++ }}</td>
                            <td rowspan="{{ $detailCount }}"><strong style="color: #1a3a5f;">{{ $pengajuan->no_pengajuan }}</strong></td>
                            <td rowspan="{{ $detailCount }}">{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                            <td rowspan="{{ $detailCount }}">{{ $pengajuan->user->name }}</td>
                        @endif
                        
                        <td>{{ $item->nama_barang }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        
                        @if ($index == 0)
                            <td rowspan="{{ $detailCount }}" class="text-center">
                                <span class="status-text {{ $statusClass }}">{{ $pengajuan->status }}</span>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px;">Tidak ada data pengajuan pada rentang filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        <div class="print-info">
            Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB
        </div>

        <div class="approval-block">
            <div class="date-text">
                Pekalongan, {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
            </div>
            <span class="ttd-title">Dicetak Oleh,</span>
            <span class="ttd-name">{{ Auth::user()->name }}</span>
        </div>
        
        <div class="clear"></div>
    </div>
</body>

</html>