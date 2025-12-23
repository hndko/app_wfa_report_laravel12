# WFA Report System

Sistem Laporan Kerja Work From Anywhere (WFA) untuk pegawai outsourcing lembaga pemerintah.

## 📋 Tentang Proyek

Aplikasi web berbasis Laravel 12 yang memudahkan pegawai untuk membuat laporan kerja harian saat WFA, dan memudahkan admin untuk mengelola serta menyetujui laporan tersebut.

## 🚀 Teknologi

-   **Framework**: Laravel 12
-   **PHP**: 8.2.29
-   **Database**: SQLite (development)
-   **Frontend**: Blade Templates + Vanilla CSS

## 📦 Struktur Database

### Tabel Users

Menyimpan data pengguna dengan role (superadmin/user)

-   Role-based access control
-   Informasi pegawai (NIP, jabatan, unit kerja)
-   Status aktif/non-aktif

### Tabel Reports

Menyimpan laporan kerja WFA

-   Tanggal, jam mulai/selesai, lokasi kerja
-   Deskripsi kegiatan dan hasil kerja
-   Status: draft → submitted → approved/rejected
-   Approval tracking

### Tabel Report Attachments

Menyimpan bukti kerja (screenshot/foto)

-   Multiple attachments per report
-   File metadata (nama, ukuran, tipe)

## 👥 Role & Fitur

### Superadmin

✅ **Dashboard**: Statistik total user, laporan hari ini, pending approval
✅ **User Management**: CRUD users, activate/deactivate
✅ **Report Management**: View semua laporan, filter, approve/reject
✅ **Export**: Laporan ke Excel/PDF per periode

### User (Pegawai)

✅ **Dashboard**: Statistik personal, quick create laporan
✅ **Create Report**: Input laporan harian dengan lampiran
✅ **Edit/Delete**: Modifikasi laporan draft/rejected
✅ **View History**: Riwayat laporan dengan status
✅ **Profile**: Update data diri dan password

## 🔐 Default Accounts

| Role       | Email             | Password |
| ---------- | ----------------- | -------- |
| Superadmin | admin@example.com | password |
| User Demo  | user@example.com  | password |

## 🛠️ Setup & Installation

### Prerequisites

-   PHP 8.2+
-   Composer
-   SQLite (atau MySQL untuk production)

### Instalasi

```bash
# Clone atau navigate ke project directory
cd /Applications/ServBay/www/app_wfa_report_laravel12

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database
touch database/database.sqlite

# Run migrations & seeders
php artisan migrate:fresh --seed

# Create storage link (untuk upload file)
php artisan storage:link

# Start development server
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 📱 Cara Penggunaan

### Login

1. Buka `http://localhost:8000/login`
2. Gunakan salah satu akun default di atas
3. Anda akan diarahkan ke dashboard sesuai role

### User - Membuat Laporan

1. Login sebagai user
2. Klik "Buat Laporan Baru"
3. Isi form:
    - Tanggal laporan
    - Jam mulai & selesai
    - Lokasi kerja WFA
    - Deskripsi kegiatan
    - Hasil kerja
    - Upload bukti (screenshot/foto)
4. Simpan sebagai draft atau submit langsung
5. Laporan submitted akan menunggu approval

### Superadmin - Approve Laporan

1. Login sebagai superadmin
2. Buka menu "Laporan"
3. Filter laporan yang pending
4. Klik detail laporan
5. Approve atau Reject dengan alasan

## 📝 Status Development

### ✅ Completed

-   [x] Laravel 12 installation dengan PHP 8.2
-   [x] Database migrations (users, reports, attachments)
-   [x] Model relationships & scopes
-   [x] Authentication system (LoginController)
-   [x] Role-based middleware
-   [x] Route structure (auth, superadmin, user)
-   [x] Database seeder dengan default accounts
-   [x] Controller scaffolding (Dashboard, Users, Reports, Profile)

### 🚧 In Progress

-   [ ] Controller logic implementation
-   [ ] Blade views & layouts
-   [ ] File upload handling
-   [ ] Export Excel/PDF functionality
-   [ ] UI/UX styling

### 📋 Planned

-   [ ] Email notifications
-   [ ] Advanced filtering & search
-   [ ] Report analytics & charts
-   [ ] Mobile responsive optimization
-   [ ] API endpoints (optional)

## 🗂️ Struktur Folder

```
app_wfa_report_laravel12/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   ├── Superadmin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── ReportController.php
│   │   │   └── User/
│   │   │       ├── DashboardController.php
│   │   │       ├── ReportController.php
│   │   │       └── ProfileController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Report.php
│       └── ReportAttachment.php
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/
    └── web.php
```

## 🔄 Development Workflow

1. **Tambah Fitur Baru**: Buat migration → Model → Controller → View
2. **Update Database**: `php artisan migrate`
3. **Reset Database**: `php artisan migrate:fresh --seed`
4. **Testing**: Manual testing per role & feature

## 📞 Support

Untuk pertanyaan atau issue, silakan hubungi tim development.

## 📄 License

Proprietary - Internal use only untuk lembaga pemerintah terkait.

---

**Version**: 1.0.0-dev
**Last Updated**: 2025-12-24
**Developer**: AI Assistant
