<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengajuan - {{ $pengajuan->no_pengajuan }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1a3a5f;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .header-table td { vertical-align: middle; }
        .header-table h2 { color: #1a3a5f; margin: 0; text-transform: uppercase; font-size: 18px; }
        .header-table p { color: #666; margin: 5px 0 0 0; font-size: 11px; }
        .logo-header { width: 80px; height: auto; }
        .logo-header1 { width: 90px; height: auto; }

        /* Tata Letak Info (Kiri & Kanan) */
        .info-wrapper {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .info-table {
            border-collapse: collapse;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            color: #555;
            width: 110px; /* Lebar label kiri */
            font-weight: bold;
        }

        .label-right {
            color: #555;
            width: 70px; /* Lebar label kanan */
            font-weight: bold;
        }

        /* Tabel Data Barang */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #1a3a5f; color: #fff; padding: 10px; text-align: left; font-size: 12px; }
        .data-table td { border: 1px solid #e1e1e1; padding: 8px; font-size: 12px; }
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }
        .total-row { background-color: #eef2f7 !important; font-weight: bold; }

        /* Metadata Cetak */
        .print-info {
            margin-top: 15px;
            font-size: 10px;
            color: #777;
            font-style: italic;
        }

        /* Tanda Tangan */
        .approval-block {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
        }

        .date-text {
            text-align: right;
            margin-bottom: 15px;
            padding-right: 40px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            width: 33.3%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-title {
            font-weight: bold;
            margin-bottom: 60px;
            display: block;
        }

        .ttd-name {
            font-weight: bold;
            display: block;
        }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td width="70">
                <img class="logo-header" src="{{ public_path('img/logo-alazhar.png') }}" alt="Logo Sekolah">
            </td>
            <td style="text-align: center;">
                <h2>FORMULIR PENGAJUAN BARANG</h2>
                <p style="margin: 0px;">Sekolah Islam Al-Azhar Pekalongan</p>
                <p style="margin: 0px; font-size: 10px;">Jl. Pelita II, Banyurip Alit, Kec. Pekalongan Sel., Kota Pekalongan</p>
            </td>
            <td width="70" style="text-align: right;">
                <img class="logo-header1" src="{{ public_path('img/sigma.png') }}" alt="Logo Yayasan">
            </td>
        </tr>
    </table>

    <table class="info-wrapper">
        <tr>
            <td width="60%">
                <table class="info-table">
                    <tr>
                        <td class="label">No. Pengajuan</td>
                        <td>: {{ $pengajuan->no_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pemohon</td>
                        <td>: {{ $pengajuan->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenjang</td>
                        <td>: {{ $pengajuan->jenjang->nama_jenjang }}</td>
                    </tr>
                </table>
            </td>
            
            <td width="40%" style="vertical-align: top;">
                <table class="info-table" style="float: right;">
                    <tr>
                        <td class="label-right">Status</td>
                        <td>: <span style="text-transform: uppercase; font-weight: bold; color: #1a3a5f;">{{ $pengajuan->status }}</span></td>
                    </tr>
                    <tr>
                        <td class="label-right">Tanggal</td>
                        <td>: {{ $pengajuan->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Barang</th>
                <th width="10%">Qty</th>
                <th width="20%">Harga</th>
                <th width="20%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuan->details as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $item->nama_barang }}<br>
                        <small style="color: #777;">{{ $item->spesifikasi }}</small>
                    </td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right; padding: 10px;">TOTAL</td>
                <td style="padding: 10px;">Rp {{ number_format($pengajuan->total_biaya, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="print-info">
        Dicetak oleh: {{ Auth::user()->name }} <br>
        Waktu Cetak: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}
    </div>

    <div class="approval-block">
        <div class="date-text">
            Pekalongan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

        </div>

        <table class="ttd-table">
            <tr>
                <td>
                    <span class="ttd-title">Pemohon,</span>
                    <span class="ttd-name"> {{ strtoupper($pengajuan->user->name) }} </span>
                </td>
                <td>
                    <span class="ttd-title">Keuangan,</span>
                    <span class="ttd-name">( ____________________ )</span>
                </td>
                <td>
                    <span class="ttd-title">Mengetahui,</span>
                    <span class="ttd-name">( ____________________ )</span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>