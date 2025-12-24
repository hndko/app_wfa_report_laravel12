<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users (not superadmin)
        $users = User::where('role', 'user')->get();

        // Sample activities
        $activities = [
            'Mengerjakan laporan bulanan, koordinasi dengan tim development, review dokumen project',
            'Meeting dengan client untuk diskusi requirement, dokumentasi hasil meeting',
            'Coding fitur baru untuk aplikasi, unit testing, bug fixing',
            'Analisis data penjualan Q4, membuat presentasi untuk management',
            'Training online tentang teknologi baru, dokumentasi hasil training',
            'Review code dari tim, mentoring junior developer, standup meeting',
            'Membuat proposal untuk project baru, riset teknologi yang akan digunakan',
            'Koordinasi dengan vendor, follow up progress development',
            'Testing aplikasi, membuat test case, dokumentasi bug',
            'Membuat dokumentasi teknis, update wiki internal',
        ];

        $results = [
            'Laporan bulanan selesai 100%, dokumen project sudah direview',
            'Requirement sudah terdokumentasi dengan baik, client menyetujui timeline',
            'Fitur baru sudah selesai dan lolos unit testing',
            'Presentasi sudah siap untuk meeting dengan management',
            'Sertifikat training sudah diterima, knowledge sharing dijadwalkan',
            'Code review selesai, 3 pull request sudah di-merge',
            'Proposal selesai dibuat, menunggu approval dari management',
            'Progress development sesuai timeline, tidak ada blocker',
            'Testing selesai, 5 bug ditemukan dan sudah dilaporkan',
            'Dokumentasi teknis sudah diupdate di wiki internal',
        ];

        $locations = [
            'Rumah - Jakarta Selatan',
            'Rumah - Jakarta Barat',
            'Coffee Shop - BSD',
            'Co-working Space - Sudirman',
            'Rumah - Tangerang',
            'Rumah - Bekasi',
            'Perpustakaan - UI Depok',
        ];

        foreach ($users as $user) {
            // Create 5 reports for each user
            for ($i = 0; $i < 5; $i++) {
                $reportDate = Carbon::now()->subDays(rand(1, 30));
                $startHour = rand(8, 10);
                $endHour = rand(16, 18);

                Report::create([
                    'user_id' => $user->id,
                    'report_date' => $reportDate->format('Y-m-d'),
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'work_location' => $locations[array_rand($locations)],
                    'activities' => $activities[array_rand($activities)],
                    'results' => $results[array_rand($results)],
                    'notes' => rand(0, 1) ? 'Tidak ada kendala berarti hari ini.' : null,
                    'status' => 'approved',
                    'approved_at' => $reportDate->addHours(rand(1, 24)),
                ]);
            }
        }

        // Also create reports for superadmin (optional - for testing)
        $superadmin = User::where('role', 'superadmin')->first();
        if ($superadmin) {
            for ($i = 0; $i < 5; $i++) {
                $reportDate = Carbon::now()->subDays(rand(1, 30));
                $startHour = rand(8, 10);
                $endHour = rand(16, 18);

                Report::create([
                    'user_id' => $superadmin->id,
                    'report_date' => $reportDate->format('Y-m-d'),
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'work_location' => $locations[array_rand($locations)],
                    'activities' => $activities[array_rand($activities)],
                    'results' => $results[array_rand($results)],
                    'notes' => 'Laporan dari superadmin untuk testing.',
                    'status' => 'approved',
                    'approved_at' => $reportDate->addHours(rand(1, 24)),
                ]);
            }
        }
    }
}
