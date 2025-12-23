<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display unified dashboard for all roles
     * NOTE: Single controller with role-based content
     */
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->role === 'superadmin') {
            // SUPERADMIN DASHBOARD STATISTICS
            $data = [
                'page_title' => 'Dashboard Superadmin',
                'total_users' => User::where('role', 'user')->count(),
                'active_users' => User::where('role', 'user')->where('is_active', true)->count(),
                'total_reports_today' => Report::whereDate('report_date', Carbon::today())->count(),
                'pending_reports' => Report::where('status', 'submitted')->count(),
                'approved_reports' => Report::where('status', 'approved')->count(),
                'rejected_reports' => Report::where('status', 'rejected')->count(),

                // Recent reports with user data (avoid N+1)
                'recent_reports' => Report::with('user:id,name,email,department')
                    ->where('status', 'submitted')
                    ->latest()
                    ->limit(5)
                    ->get(),

                // Monthly report statistics
                'monthly_stats' => Report::selectRaw('
                        strftime("%Y-%m", report_date) as month,
                        COUNT(*) as total,
                        SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                        SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                        SUM(CASE WHEN status = "submitted" THEN 1 ELSE 0 END) as pending
                    ')
                    ->whereYear('report_date', Carbon::now()->year)
                    ->groupByRaw('strftime("%Y-%m", report_date)')
                    ->orderByRaw('strftime("%Y-%m", report_date) desc')
                    ->limit(6)
                    ->get(),
            ];
        } else {
            // USER DASHBOARD STATISTICS
            $data = [
                'page_title' => 'Dashboard Saya',
                'total_reports' => Report::where('user_id', $user->id)->count(),
                'draft_reports' => Report::where('user_id', $user->id)->where('status', 'draft')->count(),
                'submitted_reports' => Report::where('user_id', $user->id)->where('status', 'submitted')->count(),
                'approved_reports' => Report::where('user_id', $user->id)->where('status', 'approved')->count(),
                'rejected_reports' => Report::where('user_id', $user->id)->where('status', 'rejected')->count(),
                'reports_this_month' => Report::where('user_id', $user->id)
                    ->whereYear('report_date', Carbon::now()->year)
                    ->whereMonth('report_date', Carbon::now()->month)
                    ->count(),

                // Recent user reports with attachments count (avoid N+1)
                'recent_reports' => Report::withCount('attachments')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->limit(5)
                    ->get(),

                // Quick info
                'has_report_today' => Report::where('user_id', $user->id)
                    ->whereDate('report_date', Carbon::today())
                    ->exists(),
            ];
        }

        return view('backend.dashboard', $data);
    }
}
