<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Barang</title>
    <style>
        /* Setup Dasar PDF */
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            font-size: 10px; 
            color: #333; 
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* Header Modern */
        .header-container {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .brand-section {
            width: 50%;
            float: left;
        }
        .info-section {
            width: 50%;
            float: right;
            text-align: right;
            color: #7f8c8d;
            font-size: 9px;
        }
        .clear { clear: both; }

        .company-name {
            color: #2c3e50;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        /* Judul Laporan */
        .report-title {
            text-align: center;
            margin: 20px 0;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
        }
        .report-title h2 {
            margin: 0;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
        }
        .report-title p {
            margin: 5px 0 0;
            color: #7f8c8d;
        }

        /* Tabel Modern */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        /* Zebra Striping & Padding */
        table thead th {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 12px 8px;
            text-align: left;
            text-transform: uppercase;
            font-size: 9px;
            border: none;
        }

        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #ebedef;
            vertical-align: middle;
        }

        table tbody tr:nth-child(even) {
            background-color: #fdfdfe;
        }

        /* Badge Kondisi */
        .badge {
            padding: 4px 8px;
            border-radius: 20px;
            color: white;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            text-transform: uppercase;
        }
        .bg-baik { background-color: #27ae60; }      /* Hijau */
        .bg-rusak { background-color: #e74c3c; }     /* Merah */
        .bg-perbaikan { background-color: #f39c12; } /* Kuning */

        .no-inv {
            font-family: 'Courier', monospace;
            color: #2980b9;
            font-weight: bold;
        }

        /* Tanda Tangan */
        .footer-section {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 70px;
        }
        .signer-name {
            border-bottom: 1px solid #333;
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }

        .page-number:before { content: "Halaman " counter(page); }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="brand-section">
            <h1 class="company-name">INVENTARIS PRO</h1>
            <p style="margin: 5px 0 0; font-size: 10px; color: #34495e;">Smart Asset Management System</p>
        </div>
        <div class="info-section">
            Jl. Contoh Alamat No. 123, Kota Anda<br>
            Telp: (021) 123456 | Email: info@sekolah.sch.id<br>
            Web: www.sekolah.sch.id
        </div>
        <div class="clear"></div>
    </div>

    <div class="report-title">
        <h2>Laporan Data Inventaris Barang</h2>
        <p>Periode: {{ now()->format('F Y') }} | Dicetak pada: {{ now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="18%">No. Inventaris</th>
                <th width="22%">Nama Barang</th>
                <th width="15%">Kategori</th>
                <th width="12%">Lokasi</th>
                <th width="10%">Perolehan</th>
                <th width="10%">Kondisi</th>
                <th width="10%">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $item)
            <tr>
                <td style="text-align: center; color: #95a5a6;">{{ $index + 1 }}</td>
                <td><span class="no-inv">{{ $item->no_inventaris }}</span></td>
                <td>
                    <div style="font-weight: bold;">{{ $item->nama_barang }}</div>
                </td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>{{ $item->gedung->nama_gedung }}</td>
                <td style="text-align: center;">{{ $item->tanggal_perolehan->format('d/m/Y') }}</td>
                <td style="text-align: center;">
                    @php
                        $statusClass = '';
                        $kondisi = strtolower($item->kondisi);
                        if($kondisi == 'baik') $statusClass = 'bg-baik';
                        elseif($kondisi == 'rusak') $statusClass = 'bg-rusak';
                        else $statusClass = 'bg-perbaikan';
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $item->kondisi }}</span>
                </td>
                <td style="text-align: center; color: #7f8c8d;">{{ $item->user->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-section">
        <div class="signature-box">
            <p>{{ now()->format('d F Y') }}<br>Mengetahui,</p>
            <p style="font-weight: bold; margin-bottom: 0;">{{ Auth()->user()->role->nama_role }}</p>
            <div class="signature-space"></div>
            <span class="signer-name">{{ Auth()->user()->name }}</span>
            <small>NIP. 19800101 200501 1 001</small>
        </div>
        <div class="clear"></div>
    </div>

    <div style="position: fixed; bottom: 0; width: 100%; text-align: center; color: #bdc3c7; font-size: 8px;">
        Laporan ini digenerate secara otomatis oleh Sistem Inventaris - <span class="page-number"></span>
    </div>
</body>
</html>