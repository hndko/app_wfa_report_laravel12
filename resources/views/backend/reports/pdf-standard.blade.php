<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan WFA - {{ $report->user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            color: #1e3a8a;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            color: #6b7280;
            font-weight: normal;
        }

        .report-info {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            color: #374151;
        }

        .info-value {
            display: table-cell;
            color: #1f2937;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .section-content {
            background: #fafafa;
            padding: 12px;
            border-radius: 5px;
            white-space: pre-wrap;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN KERJA WORK FROM ANYWHERE</h1>
        <h2>WFA Report System</h2>
    </div>

    <div class="report-info">
        <div class="info-row">
            <span class="info-label">Nama Pegawai</span>
            <span class="info-value">: {{ $report->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">NIP</span>
            <span class="info-value">: {{ $report->user->nip }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jabatan</span>
            <span class="info-value">: {{ $report->user->position }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Unit Kerja</span>
            <span class="info-value">: {{ $report->user->department }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Laporan</span>
            <span class="info-value">: {{ $report->report_date->isoFormat('dddd, D MMMM YYYY') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jam Kerja</span>
            <span class="info-value">: {{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }}
                WIB</span>
        </div>
        <div class="info-row">
            <span class="info-label">Lokasi Kerja</span>
            <span class="info-value">: {{ $report->work_location }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">KEGIATAN</div>
        <div class="section-content">{{ $report->activities }}</div>
    </div>

    @if($report->results)
    <div class="section">
        <div class="section-title">HASIL KERJA</div>
        <div class="section-content">{{ $report->results }}</div>
    </div>
    @endif

    @if($report->notes)
    <div class="section">
        <div class="section-title">CATATAN</div>
        <div class="section-content">{{ $report->notes }}</div>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh WFA Report System</p>
        <p>Tanggal cetak: {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
    </div>
</body>

</html>