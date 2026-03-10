<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cetak Label Inventaris - {{ date('d/m/Y') }}</title>
    <style>
        /* Pengaturan Kertas A4 */
        @page { 
            margin: 10mm; 
        }
        
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #fff;
        }

        /* Container utama label */
        .label-wrapper {
            width: 85mm;
            height: 25mm; /* Sedikit ditinggikan agar proporsional */
            float: left;
            margin: 2mm 3mm; /* Jarak antar label */
            border: 1px solid #1a3a5f; /* Border warna tema */
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            border-radius: 3px;
        }

        /* Bagian Kiri: Area QR Code (Blocking Warna) */
        .qr-section {
            width: 25mm;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background-color: #1a3a5f; /* Warna biru gelap / Navy */
            display: table; /* Trik vertikal align untuk PDF */
            text-align: center;
        }

        .qr-container {
            display: table-cell;
            vertical-align: middle;
            padding: 2.5mm;
        }

        .qr-container img {
            width: 18mm;
            height: 18mm;
            background-color: #fff; /* Memberi frame putih pada QR */
            padding: 1mm;
            border-radius: 2px;
        }

        /* Bagian Kanan: Informasi Teks */
        .info-section {
            margin-left: 25mm; /* Sesuaikan dengan lebar qr-section */
            height: 100%;
            position: relative;
        }

        /* Header Label (Blok Abu-abu Terang) */
        .header-info {
            background-color: #f1f5f9;
            height: 6mm;
            padding: 1mm 2mm;
            border-bottom: 1px solid #e2e8f0;
            align-items: center;
        }

        .school-name {
            font-size: 7pt;
            font-weight: bold;
            color: #1a3a5f;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
            display: block;
            margin-top: 0.5mm;
        }

        /* Konten Utama (Nomor & Nama Barang) */
        .content-info {
            padding: 2mm 2.5mm;
        }

        .inv-label {
            font-size: 5pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 0.5mm;
            display: block;
        }

        .inv-number {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            line-height: 1;
            font-family: 'Courier', monospace; /* Font monospace agar nomor terlihat tegas */
        }

        .item-name {
            font-size: 7.5pt;
            font-weight: bold;
            color: #334155;
            margin: 1.5mm 0 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis; /* Menambahkan '...' jika teks terlalu panjang */
        }

        /* Pita Status/Tahun di Kanan Bawah */
        .year-tag {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #1a3a5f; /* Warna merah aksen */
            color: white;
            font-size: 5pt;
            font-weight: bold;
            padding: 1mm 2mm;
            border-top-left-radius: 3px;
        }

        .clear { clear: both; }
    </style>
</head>
<body>

    @foreach($barangs as $index => $barang)
        <div class="label-wrapper">
            <div class="qr-section">
                <div class="qr-container">
                    <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::format('svg')->size(100)->margin(0)->generate(route('barang.show-public', $barang->nama_barang))) !!}" > 
                </div>
            </div>

            <div class="info-section">
                <div class="header-info">
                    {{-- <img src="{{ public_path('img/logo-alazhar.png') }}" style="height: 100%" alt=""> --}}
                    <span class="school-name">Sekolah Islam Al-Azhar Pekalongan</span>
                </div>

                <div class="content-info">
                    <span class="inv-label">No. Inventaris</span>
                    <div class="inv-number">{{ $barang->no_inventaris }}</div>
                    <div class="item-name">{{ strtoupper($barang->nama_barang) }}</div>
                </div>

                <div class="year-tag">
                    {{ $barang->tanggal_perolehan ? $barang->tanggal_perolehan->format('Y') : date('Y') }}
                </div>
            </div>
        </div>

        @if(($index + 1) % 2 == 0)
            <div class="clear"></div>
        @endif
    @endforeach

</body>
</html>