<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Barang</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px double #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 10px; color: #666; }
        
        .title { text-align: center; margin-bottom: 20px; }
        .title h4 { margin: 0; text-decoration: underline; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th { background-color: #f2f2f2; padding: 10px; border: 1px solid #000; font-size: 10px; }
        table td { padding: 8px; border: 1px solid #000; vertical-align: top; font-size: 10px; }
        
        .footer { margin-top: 30px; float: right; width: 200px; text-align: center; }
        .footer p { margin-bottom: 60px; }
        
        .page-break { page-break-after: always; }
        .text-center { text-align: center; }
        .badge { padding: 3px 6px; border-radius: 4px; color: white; font-weight: bold; }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #000; }
        .bg-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SISTEM MANAJEMEN INVENTARIS</h2>
        <p>Jl. Contoh Alamat No. 123, Kota Anda | Telp: (021) 123456 | Email: admin@sekolah.sch.id</p>
    </div>

    <div class="title">
        <h4>Laporan Data Inventaris Barang</h4>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">No. Inventaris</th>
                <th width="20%">Nama Barang</th>
                <th width="15%">Kategori</th>
                <th width="10%">Lokasi</th>
                <th width="10%">Tgl Perolehan</th>
                <th width="10%">Kondisi</th>
                <th width="10%">User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center"><strong>{{ $item->no_inventaris }}</strong></td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>{{ $item->gedung->nama_gedung }}</td>
                <td class="text-center">{{ $item->tanggal_perolehan->format('d/m/Y') }}</td>
                <td class="text-center">{{ $item->kondisi }}</td>
                <td class="text-center">{{ $item->user->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,<br>Kepala Bagian Sarpras</p>
        <br><br>
        <strong>( ........................... )</strong>
    </div>
</body>
</html>