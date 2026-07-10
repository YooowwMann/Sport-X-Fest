# 📖 BACA_GBLG — SportX Fest
> Dokumentasi lengkap untuk developer, AI agent, dan siapa saja yang mau ngoprek project ini.
> Baca dari atas ke bawah sebelum ngapa-ngapain.

---

## 🧠 Tentang Project

**SportX Fest** adalah aplikasi web manajemen event olahraga berbasis **Laravel 12**.  
Sistem ini memiliki beberapa layer utama:
- **User Area** — register, login, dashboard sederhana, daftar event, contact form, dan dokumentasi
- **Admin Panel** — manajemen user, event, registrasi peserta, dokumentasi foto, contact inbox, activity log, statistik & chart

Project ini cocok dijadikan **portfolio**, **bahan belajar Laravel**, atau **base project** untuk dikembangkan lebih lanjut.

---

## ⚙️ Tech Stack

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| Language | PHP | ^8.2 |
| Framework | Laravel | ^12.0 |
| Database | MySQL (via XAMPP) | — |
| Frontend | Blade Templating | — |
| CSS | Custom CSS (inline di layout) | — |
| CSS Framework | Bootstrap 5 + custom CSS | dipakai di layout publik dan admin |
| Build Tool | Vite + laravel-vite-plugin | ^7.0 / ^2.0 |
| Chart | Chart.js | CDN |
| Alert | SweetAlert2 | CDN |
| Icon | Font Awesome 6 | CDN |
| Auth | Laravel Auth (session-based) | bawaan Laravel |
| Dev Tools | Tinker, Pint, Pail, Sail | — |

---

## 📁 Struktur Project

```
sportxfest/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php              ← login, register, logout
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php     ← statistik + chart data
│   │   │       ├── UserController.php          ← CRUD + role + status user
│   │   │       ├── EventController.php         ← CRUD event + upload gambar
│   │   │       ├── RegistrationController.php  ← approve/reject peserta
│   │   │       ├── ActivityLogController.php   ← list log aktivitas
│   │   │       └── GalleryController.php       ← CRUD foto dokumentasi
│   │   └── Middleware/
│   │       └── AdminMiddleware.php             ← blokir non-admin
│   ├── Models/
│   │   ├── User.php
│   │   ├── Event.php
│   │   ├── Registration.php
│   │   ├── ActivityLog.php
│   │   ├── Contact.php
│   │   ├── GalleryPhoto.php
│   │   └── UserProfile.php
│   └── Providers/
│       └── AppServiceProvider.php             ← Paginator::useBootstrapFive()
├── bootstrap/
│   └── app.php                                ← daftarkan middleware + redirect logic
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_01_01_000001_add_role_status_to_users_table.php
│   │   ├── 2024_01_01_000002_create_events_table.php
│   │   ├── 2024_01_01_000003_create_registrations_table.php
│   │   ├── 2024_01_01_000004_create_activity_logs_table.php
│   │   ├── 2024_01_01_000005_add_phone_to_users_table.php
│   │   ├── 2024_01_01_000006_create_user_profile_table.php
│   │   ├── 2026_07_10_000001_create_contacts_table.php
│   │   └── 2026_07_10_000002_create_gallery_photos_table.php
│   └── seeders/
│       ├── AdminSeeder.php                    ← buat akun admin default
│       ├── DatabaseSeeder.php
│       └── EventSeeder.php
├── public/
│   ├── css/style.css                          ← styling auth pages
│   └── images/
│       ├── LOGO.png                           ← logo utama (dipakai di sidebar + auth)
│       ├── lari.png                           ← foto hero login page
│       └── Lari.jpg                           ← foto hero register page
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── admin/
│   │   ├── layouts/app.blade.php              ← master layout admin (sidebar, topbar, css)
│   │   ├── dashboard.blade.php
│   │   ├── users/index.blade.php
│   │   ├── events/index.blade.php
│   │   ├── events/create.blade.php
│   │   ├── events/edit.blade.php
│   │   ├── registrations/index.blade.php
│   │   ├── logs/index.blade.php
│   │   ├── contact.blade.php
│   │   └── documentation/
│   │       ├── index.blade.php
│   │       └── edit.blade.php
│   ├── events/
│   │   ├── home.blade.php
│   │   ├── public_index.blade.php
│   │   ├── daftar.blade.php
│   │   ├── contact.blade.php
│   │   ├── dokumentasi.blade.php
│   │   └── (halaman publik tambahan lain mengikuti kebutuhan)
│   ├── layouts/
│   │   └── public.blade.php
│   └── dashboard.blade.php                   ← dashboard user biasa
└── routes/web.php
```

---

## 🗄️ Database Schema

### Tabel `users`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | auto increment |
| name | varchar | nama lengkap |
| email | varchar unique | email login |
| role | enum(admin,user) | default: user |
| is_active | boolean | default: true |
| email_verified_at | timestamp nullable | — |
| password | varchar | bcrypt |
| remember_token | varchar nullable | — |
| created_at / updated_at | timestamp | — |

### Tabel `events`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | — |
| title | varchar | judul event |
| description | text nullable | deskripsi |
| date | date | tanggal event |
| location | varchar | lokasi |
| quota | integer | maks peserta |
| image | varchar nullable | path gambar (storage/public) |
| status | enum(open,closed) | default: open |

### Tabel `contacts`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | — |
| nama | varchar | nama pengirim |
| email | varchar | email pengirim |
| subject | varchar | judul pesan |
| pesan | text | isi pesan |

### Tabel `gallery_photos`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | — |
| event_id | FK → events nullable | relasi ke event dokumentasi |
| photo_path | varchar | path file foto |
| description | text nullable | deskripsi kegiatan |

### Tabel `registrations`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | — |
| user_id | FK → users | cascade delete |
| event_id | FK → events | cascade delete |
| status | enum(pending,approved,rejected) | default: pending |

### Tabel `activity_logs`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | — |
| user_id | FK → users nullable | set null on delete |
| action | varchar | kode aksi (login, delete_user, dll) |
| description | varchar | deskripsi human-readable |
| ip_address | varchar(45) | IPv4/IPv6 |

---

## 🔐 Sistem Role & Akses

```
guest      → hanya bisa akses /login dan /register
user       → akses /dashboard setelah login
admin      → akses /admin/* setelah login
```

Middleware stack:
- `auth` — wajib login
- `admin` — wajib role = admin (via `AdminMiddleware.php`)
- `guest` — hanya untuk yang belum login, redirect otomatis berdasarkan role

Redirect logic (di `bootstrap/app.php`):
- User sudah login sebagai **admin** → buka `/login` → redirect ke `/admin/dashboard`
- User sudah login sebagai **user** → buka `/login` → redirect ke `/dashboard`

---

## 🌐 Route Map

```
GET  /                          → redirect /home
GET  /home                      → home publik
GET  /events-list               → daftar semua event
GET  /dokumentasi               → arsip foto dokumentasi per event
GET  /contact                   → halaman contact publik
POST /contact                   → simpan pesan contact
GET  /login                     → form login        [guest]
POST /login                     → proses login      [guest]
GET  /register                  → form register     [guest]
POST /register                  → proses register   [guest]
GET  /dashboard                 → dashboard user    [auth]
POST /logout                    → logout            [auth]

GET    /admin/dashboard                      [auth, admin]
GET    /admin/users                          [auth, admin]
PATCH  /admin/users/{user}/role              [auth, admin]
PATCH  /admin/users/{user}/toggle-status     [auth, admin]
DELETE /admin/users/{user}                   [auth, admin]
GET    /admin/events                         [auth, admin]
GET    /admin/events/create                  [auth, admin]
POST   /admin/events                         [auth, admin]
GET    /admin/events/{event}/edit            [auth, admin]
PUT    /admin/events/{event}                 [auth, admin]
DELETE /admin/events/{event}                 [auth, admin]
GET    /admin/registrations                  [auth, admin]
PATCH  /admin/registrations/{id}/approve     [auth, admin]
PATCH  /admin/registrations/{id}/reject      [auth, admin]
GET    /admin/logs                           [auth, admin]
GET    /admin/contact                        [auth, admin]
DELETE /admin/contact/{contact}              [auth, admin]
GET    /admin/dokumentasi                    [auth, admin]
POST   /admin/dokumentasi                    [auth, admin]
GET    /admin/dokumentasi/{galleryPhoto}/edit [auth, admin]
PUT    /admin/dokumentasi/{galleryPhoto}     [auth, admin]
DELETE /admin/dokumentasi/{galleryPhoto}     [auth, admin]
```

---

## 🧩 Fitur Aktif Sekarang

- **Publik**: Home, Events, Dokumentasi, Contact, Login, Register, Dashboard user
- **Registrasi event**: pilih event, cek kuota, simpan pending/approve/reject
- **Contact form**: pesan user masuk ke tabel `contacts`, admin bisa lihat inbox dan balas via email
- **Dokumentasi galeri**: foto per event ditampilkan di halaman Dokumentasi dan bisa ditautkan ke event terkait
- **Admin panel**: user, event, registrations, logs, contact inbox, dan dokumentasi foto

---

## 🚀 Tutorial Clone & Setup

### Prasyarat
- XAMPP (PHP 8.2+, MySQL, Apache)
- Composer
- Node.js + NPM
- Git

### Langkah 1 — Clone Project
```bash
cd C:/xampp/htdocs
git clone <URL_REPO> sportxfest
cd sportxfest
```

### Langkah 2 — Install Dependencies
```bash
composer install
npm install
```

### Langkah 3 — Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### Langkah 4 — Konfigurasi Database
Edit file `.env`:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306        # ganti 3307 jika port XAMPP kamu custom
DB_DATABASE=sportxfest
DB_USERNAME=root
DB_PASSWORD=        # kosong jika tidak ada password
```

Buat database `sportxfest` di phpMyAdmin:
1. Buka `http://localhost/phpmyadmin`
2. Klik **New** → isi nama `sportxfest` → **Create**

### Langkah 5 — Migrate & Seed
```bash
php artisan migrate
php artisan db:seed
```

> Seeder akan membuat akun admin default:
> - Email: `admin@sportxfest.com`
> - Password: `admin123`

### Langkah 6 — Storage Link (untuk upload gambar event)
```bash
php artisan storage:link
```

### Langkah 7 — Jalankan Server
```bash
php artisan serve
```

Akses di browser:
```
Home         → http://localhost:8000/home
Dokumentasi  → http://localhost:8000/dokumentasi
Contact      → http://localhost:8000/contact
User Login   → http://localhost:8000/login
Admin Panel  → http://localhost:8000/admin/dashboard
```

---

## 📝 Catatan QA Terakhir

- Route root `/` sekarang redirect ke `/home`, jadi test default Laravel yang mengharapkan 200 di `/` memang perlu disesuaikan.
- Dokumentasi galeri dan contact inbox sudah ada di program utama, jadi folder lama seperti `Rafa-Dokumentasi` dan `Gilbert-Contact-us` tidak lagi dibutuhkan sebagai dependency.
- Untuk upload gambar event/dokumentasi, jalankan `php artisan storage:link` sekali jika belum pernah.

> Jika menggunakan Apache XAMPP langsung (tanpa `php artisan serve`):
> `http://localhost/sportxfest/public/login`

---

## 🧪 Test Koneksi Database (Opsional)

```bash
php artisan tinker
```

```php
// Cek koneksi
DB::connection()->getPdo();

// Cek user admin tersedia
App\Models\User::where('role', 'admin')->first();

// Coba login manual
Auth::attempt(['email' => 'admin@sportxfest.com', 'password' => 'admin123']);
```

---

## ✅ Kelebihan Project Ini

- **Role-based access control** — admin dan user terpisah dengan middleware
- **Laravel Auth system** yang proper — pakai `Auth::attempt()`, session regenerate, CSRF
- **Activity Log** — setiap aksi admin tercatat otomatis (login, hapus, edit, dll)
- **Validasi kuota event** — sistem cegah approve melebihi kuota yang ditentukan
- **Upload gambar event** — dengan preview sebelum upload dan hapus file lama otomatis
- **Search + Filter + Pagination** di semua halaman data
- **SweetAlert2** untuk konfirmasi hapus data (UX lebih baik)
- **Chart.js** — dashboard dengan 2 grafik (bar & line)
- **Redirect cerdas** — admin dan user diarahkan ke halaman yang sesuai role-nya
- **Null-safe operator** (`?->`) dipakai untuk mencegah error data nullable
- **CSS inline di layout** — tidak bergantung file CSS external tambahan untuk admin panel
- **Logout aman** — via POST + session invalidate + CSRF token regenerate

---

## ⚠️ Kekurangan & Batasan Saat Ini

- **Dashboard user masih sederhana** — user sudah bisa lihat area dasar, tapi belum ada summary aktivitas yang kaya
- **Belum ada email notification otomatis** — approve/reject registrasi dan contact reply masih manual melalui inbox/email client
- **Belum ada export data** — belum ada fitur export Excel/CSV untuk user, peserta, atau dokumentasi
- **Belum ada manajemen galeri tingkat lanjut** — misalnya album, tag, atau filter kategori foto per event
- **welcome.blade.php masih default Laravel** — belum diganti dengan landing page SportX Fest
- **Tidak ada fitur reset password** — user yang lupa password tidak bisa reset sendiri
- **Tidak ada pagination settings global** — per_page hanya ada di halaman Users
- **CSS admin sepenuhnya inline** — susah di-maintain jika project makin besar, idealnya dipindah ke file terpisah
- **Belum ada unit test / feature test**
- **Tidak ada validasi duplikat registrasi** — user bisa didaftarkan ke event yang sama lebih dari sekali (jika ditambahkan fitur registrasi dari sisi user)

---

## 🔮 Rencana Update ke Depan (Roadmap)

### Prioritas Tinggi
- [ ] Halaman user — list event yang tersedia, tombol daftar, status registrasi pribadi
- [ ] Validasi unique registrasi per user per event
- [ ] Email notifikasi (approve/reject) menggunakan Laravel Mail + Mailtrap
- [ ] Fitur reset password

### Prioritas Menengah
- [ ] Export data user dan peserta ke Excel (pakai `maatwebsite/excel`)
- [ ] Landing page yang proper (ganti `welcome.blade.php`)
- [ ] Responsive mobile yang lebih baik untuk admin panel
- [ ] Pindahkan CSS admin ke file terpisah (`public/css/admin.css`)
- [ ] Tambah per_page selector di semua halaman data (Events, Registrations, Logs)

### Prioritas Rendah / Bonus
- [ ] Dark mode toggle di admin panel
- [ ] Fitur pencarian global di topbar admin
- [ ] Print / PDF registrasi peserta
- [ ] Avatar upload untuk profil user
- [ ] Two-factor authentication (2FA)
- [ ] API endpoint untuk mobile app

---

## 🚫 PANTANGAN — Jangan Lakukan Ini

### Database
- ❌ **Jangan hapus migration yang sudah dijalankan** — akan merusak struktur database. Buat migration baru jika perlu mengubah tabel.
- ❌ **Jangan jalankan `php artisan migrate:fresh` di production** — akan menghapus semua data.
- ❌ **Jangan edit langsung tabel di phpMyAdmin** tanpa membuat migration — perubahan tidak terlacak di Git.

### Auth & Security
- ❌ **Jangan ganti `Auth::attempt()` kembali ke `DB::table()` manual** — akan merusak seluruh sistem middleware dan session.
- ❌ **Jangan hapus `session()->regenerate()`** di method login — rentan session fixation attack.
- ❌ **Jangan buat route logout via GET** — harus POST + CSRF untuk keamanan.
- ❌ **Jangan commit file `.env`** ke Git — berisi APP_KEY dan kredensial database.

### Route & Middleware
- ❌ **Jangan hapus nama route `login`** (`->name('login')`) — middleware `auth` bawaan Laravel membutuhkan ini untuk redirect.
- ❌ **Jangan proteksi route admin hanya dengan `auth`** tanpa `admin` middleware — user biasa bisa akses panel admin.
- ❌ **Jangan ganti method HTTP logout dari POST ke GET** — keamanan CSRF.

### File & Storage
- ❌ **Jangan hapus symlink `public/storage`** — gambar event tidak akan bisa diakses.
- ❌ **Jangan simpan file upload langsung ke `public/`** — gunakan `storage/app/public/` dan akses via `Storage::url()`.

### Coding
- ❌ **Jangan pakai `$_SESSION` langsung** — selalu gunakan helper Laravel `session()`.
- ❌ **Jangan hardcode kredensial** (password, key) di dalam kode — gunakan `.env`.
- ❌ **Jangan hapus `@csrf`** di form POST/PUT/DELETE — request akan ditolak 419.

---

## 📝 Informasi Penting untuk AI Agent Lain

Jika kamu adalah AI agent yang akan mengerjakan project ini, baca poin-poin ini:

### Konteks Sistem
- Project ini pakai **Laravel 12** dengan PHP 8.2+. Syntax null-safe operator (`?->`) dan named arguments sudah didukung.
- Session driver: **database** (bukan file). Tabel `sessions` harus ada di database.
- File gambar event disimpan di `storage/app/public/events/` dan diakses via `Storage::url($path)`.
- Pagination menggunakan **Bootstrap 5** (diset di `AppServiceProvider`).

### Konvensi Kode
- Semua controller admin ada di namespace `App\Http\Controllers\Admin\`
- Route admin semua punya prefix `admin.` (contoh: `route('admin.events.index')`)
- Activity log ditulis dengan `ActivityLog::record('action_name', 'deskripsi')` — tersedia di semua controller
- Model `User` punya method `isAdmin()` — gunakan ini, bukan cek `$user->role === 'admin'` langsung

### Yang Sudah Dikerjakan
- ✅ Auth system (login, register, logout) dengan Laravel Auth
- ✅ Role-based middleware (auth + admin)
- ✅ Redirect berdasarkan role di `bootstrap/app.php`
- ✅ Admin panel lengkap (dashboard, users, events, registrations, logs)
- ✅ Upload gambar event dengan storage link
- ✅ Activity log otomatis
- ✅ Chart.js terintegrasi di dashboard

### Yang Belum Ada (Jangan Asumsikan Sudah Ada)
- ❌ Fitur user untuk mendaftar event
- ❌ Email notification
- ❌ Export data
- ❌ Reset password
- ❌ Test suite

### Jika Ada Error Umum
| Error | Kemungkinan Penyebab |
|-------|---------------------|
| `Route [login] not defined` | Route GET /login belum punya `->name('login')` |
| `Call to member function format() on null` | Data `created_at` null, gunakan `?->format()` |
| `419 Page Expired` | Form tidak ada `@csrf` |
| `403 Forbidden` | User bukan admin mencoba akses `/admin/*` |
| `Class not found` | Namespace controller salah (perhatikan `Controllers` vs `Controller`) |
| Login berhasil tapi balik ke login | `Auth::attempt()` tidak dipakai, session manual tidak dikenali middleware |
| Gambar event tidak muncul | `php artisan storage:link` belum dijalankan |

---

## 👤 Akun Default Setelah Seed

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sportxfest.com | admin123 |

> Untuk akun user biasa, daftar melalui `/register`.

---

## 🔑 Environment Variables Penting

```dotenv
APP_KEY=            # wajib ada, generate dengan: php artisan key:generate
APP_DEBUG=true      # matikan di production (false)
APP_URL=            # sesuaikan dengan URL deployment

DB_CONNECTION=mysql
DB_PORT=3306        # atau 3307 jika XAMPP custom
DB_DATABASE=sportxfest

SESSION_DRIVER=database   # jangan ganti ke file kecuali kamu tahu implikasinya
```

---

## 📦 Perintah Artisan yang Sering Dipakai

```bash
php artisan migrate              # jalankan migration baru
php artisan migrate:rollback     # batalkan migration terakhir
php artisan db:seed              # jalankan seeder (buat admin default)
php artisan storage:link         # buat symlink public/storage
php artisan config:clear         # clear config cache
php artisan cache:clear          # clear application cache
php artisan route:list           # lihat semua route terdaftar
php artisan tinker               # REPL interaktif untuk debug
php artisan make:migration ...   # buat file migration baru
php artisan make:model ...       # buat model baru
php artisan make:controller ...  # buat controller baru
```

---

*Dokumentasi ini dibuat berdasarkan state project pada sesi development terakhir. Update dokumen ini setiap kali ada perubahan besar pada struktur atau fitur project.*
