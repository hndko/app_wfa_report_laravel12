<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Approval Feature Setting (default: OFF)
        Setting::set(
            key: 'approval_enabled',
            value: 'false',
            type: 'boolean',
            group: 'reports',
            description: 'Enable/disable approval workflow for reports. When disabled, reports are automatically approved upon submission.'
        );

        // App Name Setting
        Setting::set(
            key: 'app_name',
            value: 'WFA Report System',
            type: 'string',
            group: 'general',
            description: 'Application name displayed in header and title'
        );

        // App Description
        Setting::set(
            key: 'app_description',
            value: 'Sistem Laporan Kerja Work From Anywhere',
            type: 'string',
            group: 'general',
            description: 'Short description of the application'
        );
    }
}
