<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengajuan - {{ $pengajuan->no_pengajuan }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 13px; color: #333; line-height: 1.6; }
        
        /* Header Modern */
        .header { text-align: left; border-bottom: 3px solid #1a3a5f; padding-bottom: 10px; margin-bottom: 25px; }
        .header h2 { color: #1a3a5f; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .header p { color: #666; margin: 5px 0 0 0; font-size: 11px; }

        /* Informasi Pengajuan */
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { padding: 4px 0; }
        .label { color: #555; width: 120px; font-weight: bold; }

        /* Tabel Data */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #1a3a5f; color: #fff; padding: 10px; text-align: left; font-size: 12px; }
        .data-table td { border: 1px solid #e1e1e1; padding: 8px; font-size: 12px; }
        .data-table tr:nth-child(even) { background-color: #f9f9f9; }
        
        /* Footer/Total */
        .total-row { background-color: #eef2f7 !important; font-weight: bold; }
        
        /* TTD Section */
        .date-container { text-align: right; margin-top: 40px; margin-bottom: 10px; }
        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .ttd-table td { width: 33.3%; text-align: center; vertical-align: top; padding-top: 20px; }
        .signature-space { height: 80px; }
        .name-line { font-weight: bold; text-decoration: underline; }
        .logo {
    float: left;
    width: 60px; /* Sesuaikan ukuran logo */
    height: auto;
    margin-right: 15px;
}
    </style>
</head>
<body>
    <div class="header d-flex gap-2">
        <img class="logo" src="{{ public_path('img/logo-alazhar.png') }}" alt="">
        <div class="">
            <h2>FORMULIR PENGAJUAN BARANG</h2>
            <p>Nomor: {{ $pengajuan->no_pengajuan }} | Tanggal: {{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</p>
        </div>
    </div>

    <table class="info-table">
        <tr><td class="label">Pemohon</td><td>: {{ $pengajuan->user->name }}</td></tr>
        <tr><td class="label">Jenjang</td><td>: {{ $pengajuan->jenjang->nama_jenjang }}</td></tr>
        <tr><td class="label">Status</td><td>: {{ $pengajuan->status }}</td></tr>
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
            @foreach($pengajuan->details as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_barang }}<br><small style="color: #777;">{{ $item->spesifikasi }}</small></td>
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

    <div class="date-container">
        Pekalongan, {{ date('d F Y') }}
    </div>

    <table class="ttd-table">
        <tr>
            <td>
                <p>Pemohon,</p>
                <div class="signature-space"></div>
                <p class="name-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </td>
            <td>
                <p>Keuangan,</p>
                <div class="signature-space"></div>
                <p class="name-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </td>
            <td>
                <p>Bendahara,</p>
                <div class="signature-space"></div>
                <p class="name-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </td>
        </tr>
    </table>
</body>
</html>