# WFA Report System

🚀 **Sistem Laporan Kerja Work From Anywhere (WFA)** untuk pegawai dengan fitur approval workflow, export PDF, dan dashboard analytics.

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-4.0-blue.svg)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)](https://php.net)

## ✨ Features

-   🔐 **Role-based Access** - Superadmin & User roles with different permissions
-   📝 **Report Management** - Create, edit, submit daily work reports with attachments
-   ✅ **Approval Workflow** - Optional approval system (can be toggled on/off)
-   📤 **Drag & Drop Upload** - Multiple image upload with live preview
-   📊 **Export PDF** - Standard & detailed report formats
-   📈 **Dashboard Analytics** - Statistics & monthly report charts
-   🎨 **Modern UI** - Tailwind CSS with responsive design
-   🌙 **Settings Panel** - Configurable application settings

## 🛠️ Tech Stack

-   **Backend**: Laravel 12, PHP 8.2+
-   **Frontend**: Tailwind CSS 4.0, Alpine.js
-   **Database**: MySQL / SQLite
-   **Build Tool**: Vite
-   **PDF Export**: DomPDF
-   **Excel Export**: Maatwebsite Excel

## 📦 Installation

```bash
# Clone repository
git clone https://github.com/your-repo/wfa-report-system.git
cd wfa-report-system

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate:fresh --seed
php artisan storage:link

# Build assets
npm run build

# Start server
php artisan serve
```

## 👤 Default Accounts

| Role       | Email             | Password |
| ---------- | ----------------- | -------- |
| Superadmin | admin@example.com | password |
| User       | user@example.com  | password |

## 📱 Screenshots

### Dashboard

Modern dashboard with statistics cards and recent reports table.

### Report Form

Drag & drop file upload with live preview support.

### PDF Export

Two report formats: Standard (simple) and Detailed (with background, objectives, evaluation).

## 🔧 Configuration

### Approval Toggle

Superadmin can enable/disable the approval workflow from Settings page:

-   **OFF**: Reports are auto-approved on submit
-   **ON**: Reports require admin approval

### Settings

-   Application name
-   Application description
-   Approval workflow toggle

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/Backend/
│   │   ├── DashboardController.php
│   │   ├── ReportController.php
│   │   ├── UserController.php
│   │   ├── ProfileController.php
│   │   └── SettingController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Report.php
│   │   ├── ReportAttachment.php
│   │   └── Setting.php
│   └── Exports/
│       └── ReportsExport.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── UserSeeder.php
│       ├── SettingSeeder.php
│       └── ReportSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   └── backend/
│   ├── css/app.css
│   └── js/app.js
└── routes/web.php
```

## 🔒 Security

-   CSRF protection on all forms
-   Role-based middleware for route protection
-   Validated file uploads (2MB max, images/PDF only)
-   Password hashing with bcrypt

## 📝 License

This project is proprietary software.

---

**Developed with ❤️ using Laravel & Tailwind CSS**
