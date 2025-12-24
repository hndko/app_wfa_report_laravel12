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
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 14px;
            color: #3b82f6;
            font-weight: normal;
        }

        .header h3 {
            font-size: 11px;
            color: #6b7280;
            font-weight: normal;
            margin-top: 5px;
        }

        .report-info {
            background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
        }

        .info-label {
            width: 140px;
            font-weight: bold;
            color: #374151;
        }

        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 8px 12px;
            border-radius: 4px 4px 0 0;
            margin-bottom: 0;
        }

        .section-content {
            background: #fafafa;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 4px 4px;
            white-space: pre-wrap;
            min-height: 40px;
        }

        .section-empty {
            color: #9ca3af;
            font-style: italic;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-submitted {
            background: #fef3c7;
            color: #92400e;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-draft {
            background: #e5e7eb;
            color: #374151;
        }

        .two-column {
            display: table;
            width: 100%;
            margin-bottom: 18px;
        }

        .column {
            display: table-cell;
            width: 48%;
            vertical-align: top;
        }

        .column:first-child {
            padding-right: 2%;
        }

        .column:last-child {
            padding-left: 2%;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
        }

        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin: 60px auto 5px;
        }

        .page-number {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN KERJA WORK FROM ANYWHERE</h1>
        <h2>Format Lengkap</h2>
        <h3>{{ $report->report_date->isoFormat('dddd, D MMMM YYYY') }}</h3>
    </div>

    <div class="report-info">
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Pegawai</td>
                <td>: {{ $report->user->name }}</td>
                <td class="info-label" style="padding-left: 20px;">Tanggal Laporan</td>
                <td>: {{ $report->report_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">NIP</td>
                <td>: {{ $report->user->nip }}</td>
                <td class="info-label" style="padding-left: 20px;">Jam Kerja</td>
                <td>: {{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }} WIB</td>
            </tr>
            <tr>
                <td class="info-label">Jabatan</td>
                <td>: {{ $report->user->position }}</td>
                <td class="info-label" style="padding-left: 20px;">Lokasi Kerja</td>
                <td>: {{ $report->work_location }}</td>
            </tr>
            <tr>
                <td class="info-label">Unit Kerja</td>
                <td>: {{ $report->user->department }}</td>
                <td class="info-label" style="padding-left: 20px;">Status</td>
                <td>:
                    @if($report->status === 'approved')
                    <span class="status-badge status-approved">DISETUJUI</span>
                    @elseif($report->status === 'submitted')
                    <span class="status-badge status-submitted">PENDING</span>
                    @elseif($report->status === 'rejected')
                    <span class="status-badge status-rejected">DITOLAK</span>
                    @else
                    <span class="status-badge status-draft">DRAFT</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- I. LATAR BELAKANG -->
    <div class="section">
        <div class="section-title">I. LATAR BELAKANG</div>
        <div class="section-content">
            Dalam rangka mendukung fleksibilitas kerja dan peningkatan produktivitas pegawai, pelaksanaan Work From
            Anywhere (WFA) dilakukan dengan tetap memperhatikan pencapaian target dan kualitas pekerjaan. Laporan ini
            disusun sebagai bentuk pertanggungjawaban pelaksanaan tugas selama bekerja secara WFA pada tanggal {{
            $report->report_date->isoFormat('D MMMM YYYY') }}.
        </div>
    </div>

    <!-- II. TUJUAN -->
    <div class="section">
        <div class="section-title">II. TUJUAN</div>
        <div class="section-content">
            1. Melaporkan kegiatan kerja yang dilakukan selama WFA
            2. Menyampaikan hasil kerja yang telah dicapai
            3. Mengidentifikasi permasalahan yang dihadapi dan solusi yang diterapkan
            4. Memberikan evaluasi pelaksanaan WFA
        </div>
    </div>

    <!-- III. KEGIATAN -->
    <div class="section">
        <div class="section-title">III. KEGIATAN</div>
        <div class="section-content">{{ $report->activities }}</div>
    </div>

    <!-- IV. REKAPITULASI HASIL -->
    <div class="section">
        <div class="section-title">IV. REKAPITULASI HASIL</div>
        <div class="section-content">
            @if($report->results)
            {{ $report->results }}
            @else
            <span class="section-empty">Tidak ada hasil kerja yang dicatat</span>
            @endif
        </div>
    </div>

    <!-- V. PERMASALAHAN -->
    <div class="section">
        <div class="section-title">V. PERMASALAHAN</div>
        <div class="section-content">
            @if($report->notes)
            {{ $report->notes }}
            @else
            <span class="section-empty">Tidak ada permasalahan yang ditemukan selama pelaksanaan WFA</span>
            @endif
        </div>
    </div>

    <!-- VI. SOLUSI -->
    <div class="section">
        <div class="section-title">VI. SOLUSI</div>
        <div class="section-content">
            @if($report->notes)
            Permasalahan yang dihadapi telah diselesaikan dengan koordinasi melalui media komunikasi daring dan
            penyesuaian jadwal kerja sesuai kebutuhan.
            @else
            <span class="section-empty">Tidak ada solusi yang diperlukan karena tidak ada permasalahan</span>
            @endif
        </div>
    </div>

    <!-- VII. EVALUASI / KESIMPULAN -->
    <div class="section">
        <div class="section-title">VII. EVALUASI / KESIMPULAN</div>
        <div class="section-content">
            Pelaksanaan WFA pada tanggal {{ $report->report_date->isoFormat('D MMMM YYYY') }} berjalan dengan baik.
            Seluruh tugas dan kegiatan yang direncanakan telah dilaksanakan sesuai dengan target yang ditetapkan.
            Produktivitas kerja tetap terjaga meskipun bekerja dari luar kantor.

            {{ $report->status === 'approved' ? 'Laporan ini telah diverifikasi dan disetujui oleh atasan.' : '' }}
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Yang Membuat Laporan,</p>
            <div class="signature-line"></div>
            <p><strong>{{ $report->user->name }}</strong></p>
            <p style="font-size: 10px;">{{ $report->user->position }}</p>
        </div>
        <div class="signature-box">
            @if($report->status === 'approved')
            <p>Mengetahui,</p>
            <div class="signature-line"></div>
            <p><strong>{{ $report->approver ? $report->approver->name : 'Atasan Langsung' }}</strong></p>
            <p style="font-size: 10px;">Supervisor</p>
            @endif
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh WFA Report System</p>
        <p>Tanggal cetak: {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
    </div>
</body>

</html>