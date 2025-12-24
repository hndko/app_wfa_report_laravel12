<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        $data = [
            'page_title' => 'Pengaturan Sistem',
            'settings' => $settings,
            'approval_enabled' => Setting::isApprovalEnabled(),
        ];

        return view('backend.settings.index', $data);
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        // Update approval setting
        $approvalEnabled = $request->boolean('approval_enabled');
        Setting::set('approval_enabled', $approvalEnabled ? 'true' : 'false', 'boolean', 'reports');

        // Update other settings if needed
        if ($request->filled('app_name')) {
            Setting::set('app_name', $request->input('app_name'), 'string', 'general');
        }

        if ($request->filled('app_description')) {
            Setting::set('app_description', $request->input('app_description'), 'string', 'general');
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }
}
