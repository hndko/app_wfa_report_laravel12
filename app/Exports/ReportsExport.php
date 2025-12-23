<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Report::with('user:id,name,email,department');

        // Apply filters
        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('report_date', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('report_date', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['month'])) {
            $query->whereRaw('strftime("%Y-%m", report_date) = ?', [$this->filters['month']]);
        }

        return $query->latest('report_date')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama User',
            'Email',
            'Department',
            'Lokasi Kerja',
            'Jam Mulai',
            'Jam Selesai',
            'Kegiatan',
            'Hasil Kerja',
            'Status',
            'Dibuat',
        ];
    }

    public function map($report): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $report->report_date->format('d/m/Y'),
            $report->user->name,
            $report->user->email,
            $report->user->department,
            $report->work_location,
            substr($report->start_time, 0, 5),
            substr($report->end_time, 0, 5),
            $report->activities,
            $report->results,
            strtoupper($report->status),
            $report->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
