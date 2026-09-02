<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi - {{ $surat->nomor_surat }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logokemenag.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f1f5f9; color: #0f172a; padding: 24px; font-size: 13px; line-height: 1.4; }
        
        .no-print-bar {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .btn-print {
            background: #10b981;
            color: #fff;
            border: none;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-print:hover { background: #059669; }
        .btn-back {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-back:hover { color: #0f172a; }

        /* Sheet Container */
        .sheet {
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 32px 40px;
            border: 2px solid #0f172a;
            border-radius: 4px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* Kop Surat */
        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding-bottom: 12px;
            border-bottom: 3px double #000;
            margin-bottom: 16px;
            text-align: center;
        }
        .kop img { width: 70px; height: 70px; object-fit: contain; }
        .kop-text h2 { font-size: 15px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #000; line-height: 1.2; }
        .kop-text h3 { font-size: 14px; font-weight: 700; text-transform: uppercase; color: #000; line-height: 1.2; margin-top: 2px; }
        .kop-text p { font-size: 11px; color: #334155; margin-top: 3px; }

        .title-doc {
            text-align: center;
            font-size: 15px;
            font-weight: 800;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 14px;
        }

        /* Table info */
        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        table.info-table td {
            padding: 6px 8px;
            font-size: 12px;
            vertical-align: top;
            border: 1px solid #000;
        }
        table.info-table td.label {
            font-weight: 600;
            background: #f8fafc;
            width: 22%;
        }

        /* Section Boxes */
        .section-box {
            border: 1px solid #000;
            margin-bottom: 12px;
        }
        .section-header {
            background: #f1f5f9;
            font-weight: 700;
            font-size: 11.5px;
            padding: 5px 10px;
            border-bottom: 1px solid #000;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .section-body {
            padding: 10px 12px;
        }

        /* Grid Checkbox */
        .grid-check {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px 16px;
            font-size: 12px;
        }
        .check-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .box-check {
            width: 14px;
            height: 14px;
            border: 1.5px solid #000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 900;
            flex-shrink: 0;
        }
        .box-check.checked {
            background: #000;
            color: #fff;
        }

        .catatan-content {
            min-height: 70px;
            font-size: 12.5px;
            white-space: pre-line;
            padding: 4px;
        }

        /* Tanda Tangan */
        .ttd-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding: 0 16px;
        }
        .ttd-box {
            text-align: center;
            font-size: 12px;
            width: 240px;
        }
        .ttd-space { height: 60px; }

        @media print {
            body { background: #fff; padding: 0; }
            .no-print-bar { display: none !important; }
            .sheet {
                border: 2px solid #000;
                box-shadow: none;
                max-width: 100%;
                margin: 0;
                padding: 16px 20px;
            }
        }
    </style>
</head>
<body>

    {{-- No-print toolbar --}}
    <div class="no-print-bar">
        <a href="{{ route('suratmasuk.show', $surat->id) }}" class="btn-back">
            <span class="material-icons" style="font-size:18px;">arrow_back</span>
            Kembali ke Detail Surat
        </a>
        <div style="display:flex;align-items:center;gap:12px;">
            <button onclick="window.print()" class="btn-print">
                <span class="material-icons" style="font-size:18px;">print</span>
                Cetak Lembar Disposisi
            </button>
        </div>
    </div>

    {{-- Printable Sheet --}}
    <div class="sheet">
        
        {{-- Kop Surat --}}
        <div class="kop">
            <img src="{{ asset('logokemenag.png') }}" alt="Logo Kemenag">
            <div class="kop-text">
                <h2>Kementerian Agama Republik Indonesia</h2>
                <h3>Kantor Kementerian Agama Kota Surakarta</h3>
                <p>Jl. Ki Mangunsarkoro No. 8, Banjarsari, Kota Surakarta, Jawa Tengah 57137</p>
            </div>
        </div>

        <div class="title-doc">LEMBAR DISPOSISI</div>

        {{-- Table Metadata Surat --}}
        <table class="info-table">
            <tr>
                <td class="label">Surat Dari</td>
                <td style="width:30%;">{{ $surat->pengirim }}</td>
                <td class="label">Diterima Tanggal</td>
                <td style="width:25%;">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Surat</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td class="label">No. Agenda / Id</td>
                <td>SM-{{ str_pad($surat->id, 4, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Surat</td>
                <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</td>
                <td class="label">Sifat Surat</td>
                <td>
                    <strong>{{ $surat->sifat_surat ?? 'Biasa' }}</strong>
                </td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td colspan="3"><strong>{{ $surat->perihal }}</strong></td>
            </tr>
        </table>

        @php
            $latestDisposisi = $surat->disposisis->first();
            $targetUnit = $latestDisposisi->tujuan_seksi ?? $surat->tujuan_surat;
            $petunjukUtama = $latestDisposisi->petunjuk_disposisi ?? $surat->petunjuk;
            $catatanPimpinan = $latestDisposisi->catatan_disposisi ?? $surat->isi_disposisi;

            $units = [
                'Kasubbag Tata Usaha',
                'Seksi Pendidikan Madrasah (Penma)',
                'Seksi Bimbingan Masyarakat Islam (Bimas)',
                'Seksi Penyelenggaraan Haji & Umrah (PHU)',
                'Seksi Pendidikan Agama & Keagamaan Islam (PAKIS)',
                'Penyelenggara Zakat dan Wakaf (Zawa)',
                'Kelompok Kerja Pengawas (Pokjawas)',
                'Staf Pelaksana / Fungsional',
            ];

            $instruksiList = [
                'Tindak lanjuti segera',
                'Pelajari / Buat telaahan',
                'Siapkan bahan / konsep jawaban',
                'Hadiri / Wakili pimpinan',
                'Koordinasikan dengan seksi terkait',
                'Untuk diketahui / dipedomani',
                'Simpan / Arsipkan',
                'Jadwalkan / Agendakan',
            ];
        @endphp

        {{-- Diteruskan Kepada --}}
        <div class="section-box">
            <div class="section-header">I. Diteruskan Kepada Yth:</div>
            <div class="section-body">
                <div class="grid-check">
                    @foreach($units as $unit)
                        @php
                            $isTarget = str_contains(strtolower($targetUnit), strtolower(explode('(', $unit)[0]));
                        @endphp
                        <div class="check-item">
                            <span class="box-check {{ $isTarget ? 'checked' : '' }}">{!! $isTarget ? '&#10003;' : '' !!}</span>
                            <span>{{ $unit }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Petunjuk / Instruksi --}}
        <div class="section-box">
            <div class="section-header">II. Petunjuk / Instruksi Pimpinan:</div>
            <div class="section-body">
                <div class="grid-check">
                    @foreach($instruksiList as $ins)
                        @php
                            $isIns = str_contains(strtolower($petunjukUtama), strtolower(explode('/', $ins)[0]));
                        @endphp
                        <div class="check-item">
                            <span class="box-check {{ $isIns ? 'checked' : '' }}">{!! $isIns ? '&#10003;' : '' !!}</span>
                            <span>{{ $ins }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Catatan Khusus --}}
        <div class="section-box">
            <div class="section-header">III. Catatan Khusus Pimpinan / Kasubbag:</div>
            <div class="section-body">
                <div class="catatan-content">
                    {{ $catatanPimpinan ?: '(Tidak ada catatan tambahan. Mohon diproses sesuai petunjuk instruksi di atas.)' }}
                </div>
            </div>
        </div>

        {{-- Tanda Tangan / Paraf --}}
        <div class="ttd-row">
            <div class="ttd-box">
                <p>Penerima Disposisi,</p>
                <div class="ttd-space"></div>
                <p>( ..................................................... )</p>
                <p style="font-size:11px;color:#64748b;">NIP. -</p>
            </div>
            <div class="ttd-box">
                <p>Surakarta, {{ now()->translatedFormat('d F Y') ?? now()->format('d F Y') }}</p>
                <p style="font-weight:600;">{{ $latestDisposisi->pemberi_disposisi ?? 'Kepala Kantor Kementerian Agama' }}</p>
                <div class="ttd-space"></div>
                <p style="font-weight:700;text-decoration:underline;">( ..................................................... )</p>
                <p style="font-size:11px;color:#64748b;">NIP. -</p>
            </div>
        </div>

    </div>

</body>
</html>
