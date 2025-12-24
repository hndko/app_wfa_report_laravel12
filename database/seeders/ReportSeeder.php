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

        // IT Helpdesk activities
        $activities = [
            'Menangani tiket helpdesk terkait troubleshooting laptop user yang tidak bisa connect WiFi, melakukan reset network adapter dan update driver wireless',
            'Instalasi software Microsoft Office 365 dan konfigurasi email Outlook untuk 3 user baru, setup OneDrive sync dan Teams desktop app',
            'Troubleshooting printer jaringan di lantai 2 yang paper jam, cleaning roller dan test print dokumen',
            'Backup data user sebelum reimaging laptop, proses reimaging Windows 11, restore data dan instalasi aplikasi standar kantor',
            'Support meeting online via Zoom/Teams, troubleshoot audio/video issues, setup screen sharing untuk presentasi',
            'Menangani request reset password Active Directory dan email, verifikasi identitas user melalui telepon',
            'Inventarisasi aset IT, update database asset management, labeling perangkat baru yang masuk',
            'Monitoring sistem jaringan dan server, cek log security, update antivirus definition pada endpoint',
            'Konfigurasi VPN untuk remote user, troubleshoot koneksi VPN yang putus-putus, cek firewall rules',
            'Dokumentasi SOP troubleshooting, update knowledge base internal, training user baru tentang tools IT',
        ];

        $results = [
            'Masalah WiFi terselesaikan, user dapat bekerja kembali dengan normal. Tiket ditutup dengan status resolved',
            'Instalasi selesai 100%, email sudah bisa diakses, OneDrive sync berjalan. User sudah bisa WFH dengan baik',
            'Printer sudah berfungsi normal, test print berhasil 10 halaman tanpa kendala',
            'Laptop berhasil di-reimaging, semua data user aman, aplikasi standar sudah terinstall dan berjalan lancar',
            'Meeting berjalan lancar tanpa kendala teknis, peserta meeting puas dengan support yang diberikan',
            'Password berhasil di-reset, user dapat login kembali ke sistem, reminder untuk ganti password sudah disampaikan',
            'Database asset updated, 15 perangkat baru sudah di-input dan diberi label, laporan inventaris bulan ini selesai',
            'Tidak ada anomali security terdeteksi, antivirus semua endpoint sudah up-to-date, sistem berjalan normal',
            'VPN user berhasil dikonfigurasi dan stabil, koneksi ke file server lancar, RDP ke workstation berhasil',
            'Dokumentasi SOP selesai dibuat, knowledge base ditambah 5 artikel baru, 2 user baru sudah ditraining',
        ];

        $locations = [
            'Rumah - Jakarta Selatan',
            'Rumah - Jakarta Barat',
            'Rumah - Jakarta Timur',
            'Co-working Space - Sudirman',
            'Rumah - Tangerang',
            'Rumah - Bekasi',
            'Rumah - Depok',
        ];

        $notes = [
            'Perlu follow up user besok untuk memastikan tidak ada kendala lanjutan',
            'Request tambahan lisensi software sudah diteruskan ke procurement',
            'Beberapa user masih belum update password, reminder sudah dikirim via email',
            'Stok kabel LAN menipis, sudah dibuatkan PR untuk pengadaan',
            null,
            null,
            'Koordinasi dengan vendor untuk maintenance rutin perangkat',
            null,
        ];

        foreach ($users as $user) {
            // Create 5 reports for each user
            for ($i = 0; $i < 5; $i++) {
                $reportDate = Carbon::now()->subDays(rand(1, 30));
                $startHour = rand(8, 9);
                $endHour = rand(16, 17);
                $activityIndex = array_rand($activities);

                Report::create([
                    'user_id' => $user->id,
                    'report_date' => $reportDate->format('Y-m-d'),
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'work_location' => $locations[array_rand($locations)],
                    'activities' => $activities[$activityIndex],
                    'results' => $results[$activityIndex],
                    'notes' => $notes[array_rand($notes)],
                    'status' => 'approved',
                    'approved_at' => $reportDate->addHours(rand(1, 24)),
                ]);
            }
        }

        // Also create reports for superadmin (for testing)
        $superadmin = User::where('role', 'superadmin')->first();
        if ($superadmin) {
            for ($i = 0; $i < 5; $i++) {
                $reportDate = Carbon::now()->subDays(rand(1, 30));
                $startHour = rand(8, 9);
                $endHour = rand(16, 17);
                $activityIndex = array_rand($activities);

                Report::create([
                    'user_id' => $superadmin->id,
                    'report_date' => $reportDate->format('Y-m-d'),
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'work_location' => $locations[array_rand($locations)],
                    'activities' => $activities[$activityIndex],
                    'results' => $results[$activityIndex],
                    'notes' => $notes[array_rand($notes)],
                    'status' => 'approved',
                    'approved_at' => $reportDate->addHours(rand(1, 24)),
                ]);
            }
        }
    }
}
