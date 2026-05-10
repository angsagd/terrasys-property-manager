# Terrasys Property Manager

Terrasys Property Manager adalah aplikasi internal berbasis Laravel untuk mengelola aset properti perusahaan, sertifikat tanah, dokumen legal, status pemanfaatan aset, laporan dasar, audit trail, dan peta sebaran properti.

Project ini mengikuti rancangan pada `Blueprint.md` dengan fokus awal pada Phase 1: fondasi autentikasi, role access, property + certificate, master data, document upload, dashboard, dan audit trail dasar.

## Stack

- Backend: Laravel 13
- Frontend: Blade, Tailwind CSS, Alpine.js
- Database: MySQL / MariaDB
- Auth: Laravel Breeze
- Role & permission: Spatie Laravel Permission
- Asset build: Vite
- Map: Leaflet + OpenStreetMap CDN
- Test: PHPUnit

## Modul Saat Ini

- Login, register, profile, password management dari Laravel Breeze.
- Role dan permission:
  - `Super Admin`
  - `Property Manager`
  - `Viewer`
- Dashboard ringkasan aset.
- Property CRUD dengan sertifikat utama dalam satu form.
- Certificate list dan detail.
- Additional Certificate CRUD.
- Document upload dan download.
- Map sebaran property berdasarkan latitude/longitude.
- Reports dasar:
  - Assets by region
  - Assets by land right
  - Idle properties
  - Expiring certificates
- Notifications page dasar.
- Master Data read-only.
- Audit Trail.
- System Settings read-only.

## Struktur Data Utama

Relasi inti aplikasi:

- `properties` memiliki satu `certificates` utama.
- `properties` memiliki banyak `additional_certificates`.
- `properties` memiliki banyak `documents`.
- `properties` memiliki banyak `lease_contracts`.
- `documents` dapat terhubung ke property, certificate, additional certificate, atau lease contract.

Master data utama:

- Property Type
- Property Utilization Status
- Land Right Type
- Certificate Status
- Lease Type
- Lease Status
- Document Category
- Province / City / District / Village

## Setup Lokal

Pastikan dependency berikut tersedia:

- PHP 8.3+
- Composer
- Node.js dan npm
- MySQL atau MariaDB

Install dependency:

```bash
composer install
npm install
```

Siapkan file environment:

```bash
cp .env.example .env
php artisan key:generate
```

Atur database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=terrasys
DB_USERNAME=terrasys
DB_PASSWORD="password-anda"
```

Jika password berisi karakter khusus seperti `#`, bungkus dengan tanda kutip seperti contoh di atas.

Jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

Buat symlink storage untuk upload dokumen:

```bash
php artisan storage:link
```

Build asset frontend:

```bash
npm run build
```

Jalankan aplikasi:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Akses aplikasi di:

```text
http://127.0.0.1:8000
```

## Akun Awal

Seeder membuat akun Super Admin:

```text
Email    : admin@example.com
Password : password
```

Ganti password setelah login pertama jika aplikasi dipakai di environment selain lokal.

## Development

Untuk menjalankan Vite dev server:

```bash
npm run dev
```

Untuk menjalankan Laravel dev server:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Untuk menjalankan test:

```bash
php artisan test
```

Untuk membersihkan cache Laravel:

```bash
php artisan optimize:clear
```

## Catatan Implementasi

- Middleware Spatie didaftarkan di `bootstrap/app.php` dengan alias `role`, `permission`, dan `role_or_permission`.
- Base controller memakai trait `AuthorizesRequests` agar controller dapat menggunakan `$this->authorize(...)`.
- `polygon_geojson` disimpan sebagai `LONGTEXT` agar kompatibel dengan MySQL/MariaDB.
- Validasi GeoJSON dilakukan di level Form Request.
- Upload dokumen menggunakan disk `public`, sehingga `php artisan storage:link` diperlukan.
- Leaflet sementara dimuat via CDN pada halaman map.

## Roadmap Singkat

Phase berikutnya yang belum lengkap:

- Lease Management full CRUD.
- Notification generator untuk certificate/document/lease expiry.
- Export Excel/PDF.
- User Management dan Role Management UI.
- Master Data CRUD.
- Advanced report filters.
- GeoJSON drawing/editing dengan Leaflet Draw.
- API Phase 2 dengan Laravel Sanctum.

## Verifikasi Terakhir

Command yang digunakan untuk validasi:

```bash
php artisan migrate:status
npm run build
php artisan test
```

Status terakhir:

```text
PHPUnit: 25 tests passed
Vite build: successful
Migrations: ran successfully
```
