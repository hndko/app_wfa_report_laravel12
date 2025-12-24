<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Lengkap WFA - {{ $report->user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            padding: 25px 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #1e3a8a;
        }

        .header h1 {
            font-size: 16px;
            color: #1e3a8a;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .header h2 {
            font-size: 13px;
            color: #3b82f6;
            font-weight: normal;
            margin-bottom: 3px;
        }

        .header .date {
            font-size: 11px;
            color: #6b7280;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info-table .label {
            width: 120px;
            font-weight: bold;
            color: #475569;
        }

        .info-table .separator {
            width: 10px;
        }

        .info-table .value {
            color: #1e293b;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-header {
            background: #1e3a8a;
            color: #fff;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 0;
        }

        .section-body {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-top: none;
            padding: 10px 12px;
            min-height: 30px;
        }

        .section-body p {
            margin: 0;
            text-align: justify;
        }

        .section-body .empty {
            color: #94a3b8;
            font-style: italic;
        }

        .signature-area {
            margin-top: 35px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }

        .signature-table .sig-title {
            font-size: 11px;
            margin-bottom: 50px;
        }

        .signature-table .sig-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 0 auto 5px;
        }

        .signature-table .sig-name {
            font-weight: bold;
            font-size: 11px;
        }

        .signature-table .sig-position {
            font-size: 10px;
            color: #64748b;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <h1>LAPORAN KERJA WORK FROM ANYWHERE</h1>
        <h2>Format Lengkap</h2>
        <div class="date">{{ $report->report_date->isoFormat('dddd, D MMMM YYYY') }}</div>
    </div>

    <!-- INFO PEGAWAI -->
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="label">Nama Pegawai</td>
                <td class="separator">:</td>
                <td class="value">{{ $report->user->name }}</td>
                <td class="label" style="padding-left: 30px;">Tanggal</td>
                <td class="separator">:</td>
                <td class="value">{{ $report->report_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="separator">:</td>
                <td class="value">{{ $report->user->nip }}</td>
                <td class="label" style="padding-left: 30px;">Jam Kerja</td>
                <td class="separator">:</td>
                <td class="value">{{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }} WIB
                </td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td class="value">{{ $report->user->position }}</td>
                <td class="label" style="padding-left: 30px;">Lokasi</td>
                <td class="separator">:</td>
                <td class="value">{{ $report->work_location }}</td>
            </tr>
            <tr>
                <td class="label">Unit Kerja</td>
                <td class="separator">:</td>
                <td class="value">{{ $report->user->department }}</td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>

    <!-- I. LATAR BELAKANG -->
    <div class="section">
        <div class="section-header">I. LATAR BELAKANG</div>
        <div class="section-body">
            <p>Dalam rangka mendukung fleksibilitas kerja dan peningkatan produktivitas pegawai, pelaksanaan Work From
                Anywhere (WFA) dilakukan dengan tetap memperhatikan pencapaian target dan kualitas pekerjaan. Laporan
                ini disusun sebagai bentuk pertanggungjawaban pelaksanaan tugas selama bekerja secara WFA pada tanggal
                {{ $report->report_date->isoFormat('D MMMM YYYY') }}.</p>
        </div>
    </div>

    <!-- II. TUJUAN -->
    <div class="section">
        <div class="section-header">II. TUJUAN</div>
        <div class="section-body">
            <p>1. Melaporkan kegiatan kerja yang dilakukan selama WFA<br>
                2. Menyampaikan hasil kerja yang telah dicapai<br>
                3. Mengidentifikasi permasalahan yang dihadapi dan solusi yang diterapkan<br>
                4. Memberikan evaluasi pelaksanaan WFA</p>
        </div>
    </div>

    <!-- III. KEGIATAN -->
    <div class="section">
        <div class="section-header">III. KEGIATAN</div>
        <div class="section-body">
            <p>{{ $report->activities }}</p>
        </div>
    </div>

    <!-- IV. REKAPITULASI HASIL -->
    <div class="section">
        <div class="section-header">IV. REKAPITULASI HASIL</div>
        <div class="section-body">
            @if($report->results)
            <p>{{ $report->results }}</p>
            @else
            <p class="empty">Tidak ada hasil kerja yang dicatat</p>
            @endif
        </div>
    </div>

    <!-- V. PERMASALAHAN -->
    <div class="section">
        <div class="section-header">V. PERMASALAHAN</div>
        <div class="section-body">
            @if($report->notes)
            <p>{{ $report->notes }}</p>
            @else
            <p class="empty">Tidak ada permasalahan yang ditemukan selama pelaksanaan WFA</p>
            @endif
        </div>
    </div>

    <!-- VI. SOLUSI -->
    <div class="section">
        <div class="section-header">VI. SOLUSI</div>
        <div class="section-body">
            @if($report->notes)
            <p>Permasalahan yang dihadapi telah diselesaikan dengan koordinasi melalui media komunikasi daring dan
                penyesuaian jadwal kerja sesuai kebutuhan.</p>
            @else
            <p class="empty">Tidak ada solusi yang diperlukan karena tidak ada permasalahan</p>
            @endif
        </div>
    </div>

    <!-- VII. EVALUASI / KESIMPULAN -->
    <div class="section">
        <div class="section-header">VII. EVALUASI / KESIMPULAN</div>
        <div class="section-body">
            <p>Pelaksanaan WFA pada tanggal {{ $report->report_date->isoFormat('D MMMM YYYY') }} berjalan dengan baik.
                Seluruh tugas dan kegiatan yang direncanakan telah dilaksanakan sesuai dengan target yang ditetapkan.
                Produktivitas kerja tetap terjaga meskipun bekerja dari luar kantor.</p>
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <div class="signature-area">
        <table class="signature-table">
            <tr>
                <td>
                    <div class="sig-title">Yang Membuat Laporan,</div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $report->user->name }}</div>
                    <div class="sig-position">{{ $report->user->position }}</div>
                </td>
                <td>
                    <div class="sig-title">Mengetahui,</div>
                    <div class="sig-line"></div>
                    <div class="sig-name">{{ $report->approver ? $report->approver->name :
                        '.............................' }}</div>
                    <div class="sig-position">Atasan Langsung</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh WFA Report System &bull; Tanggal cetak: {{ now()->isoFormat('D MMMM
        YYYY, HH:mm') }} WIB
    </div>
</body>

</html>