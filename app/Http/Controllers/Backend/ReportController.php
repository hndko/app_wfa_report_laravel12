<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display all reports for superadmin with filters
     * NOTE: Superadmin only, with user, date, status filters
     */
    public function index(Request $request)
    {
        $query = Report::with('user:id,name,email,department');

        // FILTER: By user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // FILTER: By status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER: By date range
        if ($request->filled('date_from')) {
            $query->whereDate('report_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('report_date', '<=', $request->date_to);
        }

        // FILTER: By month
        if ($request->filled('month')) {
            $query->whereRaw('DATE_FORMAT(report_date, "%Y-%m") = ?', [$request->month]);
        }

        // Get users list for filter
        $users = User::where('role', 'user')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'department']);

        $data = [
            'page_title' => 'Semua Laporan',
            'reports' => $query->latest('report_date')->paginate(15)->withQueryString(),
            'users' => $users,
            'filters' => $request->only(['user_id', 'status', 'date_from', 'date_to', 'month']),
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.reports.index', $data);
    }

    /**
     * Display user's own reports
     * NOTE: User role only, with filters
     */
    public function myReports(Request $request)
    {
        $query = Report::where('user_id', auth()->id())
            ->withCount('attachments');

        // FILTER: By status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER: By month
        if ($request->filled('month')) {
            $query->whereRaw('DATE_FORMAT(report_date, "%Y-%m") = ?', [$request->month]);
        }

        $data = [
            'page_title' => 'Laporan Saya',
            'reports' => $query->latest('report_date')->paginate(15)->withQueryString(),
            'filters' => $request->only(['status', 'month']),
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.reports.my-index', $data);
    }

    /**
     * Show report details for superadmin
     * NOTE: Superadmin only, with user and attachments
     */
    public function show($id)
    {
        $report = Report::with(['user', 'approver', 'attachments'])
            ->findOrFail($id);

        $data = [
            'page_title' => 'Detail Laporan',
            'report' => $report,
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.reports.show', $data);
    }

    /**
     * Show user's own report details
     * NOTE: User role only, own reports
     */
    public function showMyReport($id)
    {
        $report = Report::with('attachments')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $data = [
            'page_title' => 'Detail Laporan',
            'report' => $report,
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.reports.my-show', $data);
    }

    /**
     * Show create report form
     * NOTE: User role only
     */
    public function create()
    {
        $data = [
            'page_title' => 'Buat Laporan Baru',
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.reports.create', $data);
    }

    /**
     * Store new report with attachments
     * NOTE: User role only, uses Storage for files
     * If approval is disabled, auto-approve on submit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'work_location' => 'required|string|max:255',
            'activities' => 'required|string',
            'results' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,submitted',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Check if approval is enabled
        $approvalEnabled = Setting::isApprovalEnabled();

        // If submitting and approval is disabled, auto-approve
        if ($validated['status'] === 'submitted' && !$approvalEnabled) {
            $validated['status'] = 'approved';
            $validated['approved_at'] = Carbon::now();
        }

        // Create report
        $validated['user_id'] = auth()->id();
        $report = Report::create($validated);

        // HANDLE FILE UPLOADS using Storage
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    // Store file to storage/app/reports
                    $path = $file->store('reports', 'public');

                    // Check if file exists
                    if (Storage::disk('public')->exists($path)) {
                        ReportAttachment::create([
                            'report_id' => $report->id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'file_type' => $file->getClientMimeType(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }
        }

        // Build success message based on status
        if ($validated['status'] === 'approved') {
            $message = 'Laporan berhasil dibuat!';
        } elseif ($validated['status'] === 'submitted') {
            $message = 'Laporan berhasil dibuat dan menunggu approval!';
        } else {
            $message = 'Laporan berhasil disimpan sebagai draft!';
        }

        return redirect()
            ->route('my.reports.index')
            ->with('success', $message);
    }

    /**
     * Show edit report form
     * NOTE: User role only, can edit draft/rejected only
     */
    public function edit($id)
    {
        $report = Report::with('attachments')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['draft', 'rejected'])
            ->firstOrFail();

        $data = [
            'page_title' => 'Edit Laporan',
            'report' => $report,
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.reports.edit', $data);
    }

    /**
     * Update report with new attachments
     * NOTE: User role only, can update draft/rejected only
     * If approval is disabled, auto-approve on submit
     */
    public function update(Request $request, $id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['draft', 'rejected'])
            ->firstOrFail();

        $validated = $request->validate([
            'report_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'work_location' => 'required|string|max:255',
            'activities' => 'required|string',
            'results' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,submitted',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Check if approval is enabled
        $approvalEnabled = Setting::isApprovalEnabled();

        // If submitting and approval is disabled, auto-approve
        if ($validated['status'] === 'submitted' && !$approvalEnabled) {
            $validated['status'] = 'approved';
            $validated['approved_at'] = Carbon::now();
            $validated['rejection_reason'] = null;
        }

        $report->update($validated);

        // HANDLE NEW FILE UPLOADS using Storage
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('reports', 'public');

                    if (Storage::disk('public')->exists($path)) {
                        ReportAttachment::create([
                            'report_id' => $report->id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'file_type' => $file->getClientMimeType(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }
        }

        // Build success message based on status
        if ($validated['status'] === 'approved') {
            $message = 'Laporan berhasil diupdate!';
        } elseif ($validated['status'] === 'submitted') {
            $message = 'Laporan berhasil diupdate dan menunggu approval!';
        } else {
            $message = 'Laporan berhasil diupdate!';
        }

        return redirect()
            ->route('my.reports.index')
            ->with('success', $message);
    }

    /**
     * Delete report
     * NOTE: User role only, can delete draft only
     */
    public function destroy($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->firstOrFail();

        // Delete all attachments from storage
        foreach ($report->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        $report->delete();

        return redirect()
            ->route('my.reports.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Submit draft report
     * NOTE: User role only, change draft to submitted
     * If approval is disabled, auto-approve
     */
    public function submit($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->firstOrFail();

        // Check if approval is enabled
        $approvalEnabled = Setting::isApprovalEnabled();

        if ($approvalEnabled) {
            $report->update(['status' => 'submitted']);
            $message = 'Laporan berhasil disubmit dan menunggu approval!';
        } else {
            $report->update([
                'status' => 'approved',
                'approved_at' => Carbon::now(),
            ]);
            $message = 'Laporan berhasil disubmit!';
        }

        return redirect()
            ->route('my.reports.index')
            ->with('success', $message);
    }

    /**
     * Delete attachment
     * NOTE: User role only, from own reports
     */
    public function deleteAttachment($id)
    {
        $attachment = ReportAttachment::whereHas('report', function ($q) {
            $q->where('user_id', auth()->id())
                ->whereIn('status', ['draft', 'rejected']);
        })->findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return back()->with('success', 'Lampiran berhasil dihapus!');
    }

    /**
     * Approve report
     * NOTE: Superadmin only
     */
    public function approve($id)
    {
        $report = Report::where('status', 'submitted')->findOrFail($id);

        $report->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => Carbon::now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Laporan berhasil disetujui!');
    }

    /**
     * Reject report with reason
     * NOTE: Superadmin only
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $report = Report::where('status', 'submitted')->findOrFail($id);

        $report->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => Carbon::now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('success', 'Laporan berhasil ditolak!');
    }

    /**
     * Export reports to Excel
     * NOTE: Superadmin only, exports filtered reports
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['user_id', 'status', 'date_from', 'date_to', 'month']);

        $filename = 'laporan_wfa_' . date('Y-m-d_His') . '.xlsx';

        return \Excel::download(new \App\Exports\ReportsExport($filters), $filename);
    }

    /**
     * Export reports to PDF
     * NOTE: Superadmin only, exports filtered reports
     */
    public function exportPdf(Request $request)
    {
        $query = Report::with('user:id,name,email,department');

        // Apply same filters as index
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('report_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('report_date', '<=', $request->date_to);
        }

        if ($request->filled('month')) {
            $query->whereRaw('DATE_FORMAT(report_date, "%Y-%m") = ?', [$request->month]);
        }

        $reports = $query->latest('report_date')->get();
        $filters = $request->only(['user_id', 'status', 'date_from', 'date_to', 'month']);

        $pdf = \PDF::loadView('backend.reports.pdf', [
            'reports' => $reports,
            'filters' => $filters,
        ]);

        $filename = 'laporan_wfa_' . date('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export single report to PDF - Standard format
     * NOTE: Superadmin only
     */
    public function pdfStandard($id)
    {
        $report = Report::with(['user', 'attachments'])->findOrFail($id);

        $pdf = \PDF::loadView('backend.reports.pdf-standard', [
            'report' => $report,
        ]);

        $filename = 'laporan_' . $report->user->name . '_' . $report->report_date->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Export single report to PDF - Detailed format
     * NOTE: Superadmin only, includes background, objectives, problems, solutions, evaluation
     */
    public function pdfDetailed($id)
    {
        $report = Report::with(['user', 'attachments'])->findOrFail($id);

        $pdf = \PDF::loadView('backend.reports.pdf-detailed', [
            'report' => $report,
        ]);

        $filename = 'laporan_lengkap_' . $report->user->name . '_' . $report->report_date->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Export user's own report to PDF - Standard format
     * NOTE: User role only, own reports
     */
    public function myPdfStandard($id)
    {
        $report = Report::with('attachments')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $report->load('user');

        $pdf = \PDF::loadView('backend.reports.pdf-standard', [
            'report' => $report,
        ]);

        $filename = 'laporan_' . $report->report_date->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Export user's own report to PDF - Detailed format
     * NOTE: User role only, own reports
     */
    public function myPdfDetailed($id)
    {
        $report = Report::with('attachments')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $report->load('user');

        $pdf = \PDF::loadView('backend.reports.pdf-detailed', [
            'report' => $report,
        ]);

        $filename = 'laporan_lengkap_' . $report->report_date->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }
}
