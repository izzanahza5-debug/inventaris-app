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
            width: 80mm;
            height: 20mm;
            float: left;
            margin: 1.5mm; /* Memberi jarak antar label untuk pemotongan */
            border: 0.1pt solid #e0e0e0; /* Garis tipis untuk panduan potong */
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            border-radius: 2mm; /* Membuat sudut sedikit melengkung (modern) */
        }

        /* Bagian Kiri: Area QR Code */
        .qr-section {
            width: 20mm;
            height: 20mm;
            position: absolute;
            left: 0;
            top: 0;
            background-color: #f8f9fa; /* Background abu sangat muda */
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 0.5pt solid #eee;
        }

        .qr-section img {
            width: 16mm;
            height: 16mm;
            margin: 2mm;
        }

        /* Bagian Kanan: Informasi Teks */
        .info-section {
            margin-left: 21mm;
            padding: 1.5mm 2.5mm;
        }

        /* Baris Atas: Logo & Nama Sekolah */
        .header-info {
            height: 4mm;
            margin-bottom: 0.5mm;
        }

        .school-logo {
            height: 3.5mm;
            vertical-align: middle;
            margin-right: 1mm;
        }

        .school-name {
            font-size: 6.5pt;
            font-weight: 700;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
        }

        /* Baris Tengah: Nomor Inventaris (Highlight Utama) */
        .inv-number {
            font-size: 11pt;
            font-weight: 800;
            color: #000;
            margin: 0;
            line-height: 1.1;
            letter-spacing: -0.2pt;
        }

        /* Baris Bawah: Nama Barang & Keterangan Tambahan */
        .item-details {
            margin-top: 1mm;
            border-top: 0.3pt solid #4e73df; /* Garis aksen biru kecil */
            padding-top: 0.5mm;
        }

        .item-name {
            font-size: 6.5pt;
            font-weight: 500;
            color: #666;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
        }

        .footer-tag {
            font-size: 5pt;
            font-weight: bold;
            color: #4e73df;
            text-transform: uppercase;
        }

        /* Clearfix untuk grid */
        .clear { clear: both; }
    </style>
</head>
<body>

    @foreach($barangs as $index => $barang)
        <div class="label-wrapper">
            <div class="qr-section">
                <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::format('svg')->size(100)->margin(0)->generate(route('barang.show-public', $barang->nama_barang))) !!}" > 
            </div>

            <div class="info-section">
                <div class="header-info">
                    {{-- Placeholder Logo (Aktifkan jika file sudah ada) --}}
                    {{-- <img src="{{ public_path('img/logo-sekolah.png') }}" class="school-logo"> --}}
                    <span class="school-name">SMK NEGERI INDONESIA</span>
                </div>

                <div class="inv-number">
                    {{ $barang->no_inventaris }}
                </div>

                <div class="item-details">
                    <span class="footer-tag">ASSET:</span>
                    <p class="item-name">{{ strtoupper($barang->nama_barang) }}</p>
                </div>
            </div>
        </div>

        {{-- Logika agar setiap 2 label, baris berganti (untuk kerapian float) --}}
        @if(($index + 1) % 2 == 0)
            <div class="clear"></div>
        @endif
    @endforeach

</body>
</html>