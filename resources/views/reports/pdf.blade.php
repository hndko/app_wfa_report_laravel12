<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan WFA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-draft {
            background: #ccc;
        }

        .badge-submitted {
            background: #ffc107;
        }

        .badge-approved {
            background: #4caf50;
            color: white;
        }

        .badge-rejected {
            background: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Laporan WFA Report System</h1>

    <p><strong>Tanggal Export:</strong> {{ date('d F Y H:i') }}</p>
    @if(!empty($filters))
    <p><strong>Filter:</strong>
        @if(!empty($filters['date_from'])) Dari {{ $filters['date_from'] }} @endif
        @if(!empty($filters['date_to'])) s/d {{ $filters['date_to'] }} @endif
        @if(!empty($filters['status'])) Status: {{ strtoupper($filters['status']) }} @endif
    </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Department</th>
                <th>Lokasi</th>
                <th>Jam</th>
                <th>Kegiatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $report->report_date->format('d/m/Y') }}</td>
                <td>{{ $report->user->name }}</td>
                <td>{{ $report->user->department }}</td>
                <td>{{ $report->work_location }}</td>
                <td>{{ substr($report->start_time, 0, 5) }} - {{ substr($report->end_time, 0, 5) }}</td>
                <td>{{ \Str::limit($report->activities, 100) }}</td>
                <td>
                    <span class="badge badge-{{ $report->status }}">
                        {{ strtoupper($report->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;">
        <strong>Total: {{ $reports->count() }} laporan</strong>
    </p>
</body>

</html>