# Panduan Portofolio di Laravel (my-app)

Website portofolio PHP Native sudah dipindah ke dalam project Laravel ini.
Tampilan website dan dashboard admin SAMA dengan versi sebelumnya. Yang berubah hanya "mesin" di belakangnya.

## 1. Apa yang dipindahkan ke mana
| Dulu (PHP Native) | Sekarang (Laravel) |
|---|---|
| `index.php` | `resources/views/portfolio/index.blade.php` (tampilan) + `app/Http/Controllers/PortfolioController.php` (data) |
| `koneksi.php` | file `.env` (bagian `DB_...`) |
| `assets/css`, `assets/js`, `assets/images` | `public/assets/css`, `public/assets/js`, `public/assets/images` |
| `admin/login.php`, `auth.php` | `AuthController` + middleware `app/Http/Middleware/AdminLogin.php` |
| `admin/dashboard.php`, `profil.php`, dll. | `app/Http/Controllers/Admin/*Controller.php` |
| tampilan admin (`_head.php`, dll.) | `resources/views/layouts/admin.blade.php` dan `resources/views/admin/...` |
| alamat halaman | semua ada di `routes/web.php` dan `routes/admin.php` |
| `database.sql`, `database_migrasi.sql` | `database/sql/1_database_awal.sql`, `database/sql/2_database_migrasi.sql` |

## 2. Koneksi database
Database tetap `db_cv` (data lama dipakai lagi, tidak dibuat ulang). Pengaturannya ada di file **`.env`** (di folder `my-app`):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_cv
DB_USERNAME=root
DB_PASSWORD=
```
Ini sama dengan isi `koneksi.php` lama (user root, password kosong). Jika password MySQL Anda berbeda, isi di `DB_PASSWORD=`.
Setelah mengubah `.env`, jalankan `php artisan config:clear`.

Saya juga mengubah `.env` agar session dan cache memakai file (`SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`).
Dengan begitu Laravel TIDAK membuat tabel tambahan di `db_cv`.
**Jangan jalankan `php artisan migrate`** (itu untuk tabel bawaan Laravel yang tidak dipakai di sini).

## 3. Langkah menjalankan (Laragon)
1. Ekstrak ZIP, letakkan folder **`my-app`** di `C:\laragon\www\`.
2. Klik **Start All** di Laragon (Apache dan MySQL).
3. Siapkan database:
   - Jika `db_cv` Anda SUDAH berisi tabel hasil `database_migrasi.sql` sebelumnya: lewati langkah ini.
   - Jika belum / database kosong: buka terminal Laragon, lalu
     ```
     cd C:\laragon\www\my-app
     mysql -u root < database\sql\1_database_awal.sql
     mysql -u root db_cv < database\sql\2_database_migrasi.sql
     ```
4. Jalankan website. Pilih SALAH SATU:

   **Cara A (paling mudah, pasti jalan):** di terminal Laragon
   ```
   cd C:\laragon\www\my-app
   php artisan serve
   ```
   Lalu buka **http://127.0.0.1:8000** (biarkan jendela terminal tetap terbuka; tekan Ctrl+C untuk berhenti).

   **Cara B (alamat otomatis Laragon):** klik kanan ikon Laragon, pilih **Apache > Reload** (atau Stop All lalu Start All).
   Laragon membuat alamat otomatis, buka **http://my-app.test**.
   Jika tidak terbuka, pakai Cara A.

## 4. Alamat halaman
| Halaman | Alamat (Cara A) |
|---|---|
| Website portofolio | http://127.0.0.1:8000/ |
| Login admin | http://127.0.0.1:8000/admin/login |
| Dashboard | http://127.0.0.1:8000/admin/dashboard |
| Skills / Education / Experience / Projects / Certificates | `/admin/skill`, `/admin/education`, `/admin/experience`, `/admin/projects`, `/admin/certificates` |
| Profil / Kontak / Pesan | `/admin/profil`, `/admin/kontak`, `/admin/pesan` |

Login admin tidak berubah: pakai username dan password yang sama seperti sebelumnya (bawaan: `admin` / `admin123`).
Ikon gembok kecil di footer website juga mengarah ke halaman login.

## 5. Jika ada masalah
- **"could not find driver" / koneksi gagal:** pastikan MySQL Laragon sudah Start, dan `DB_DATABASE=db_cv` benar.
- **Halaman error 500 / "No application encryption key":** jalankan `php artisan key:generate`.
- **Tampilan berantakan (CSS tidak muncul):** buka lewat `php artisan serve` (Cara A), bukan lewat `localhost/my-app`.
- **Setelah mengubah `.env` tidak berubah:** `php artisan config:clear`.
- **Website menampilkan "Data portofolio belum tersedia / tabel tidak ada":** jalankan langkah 3 nomor 3 (database).
- Ganti password admin lewat terminal: lihat penjelasan sebelumnya (`password_hash` lalu `UPDATE admin ...`).

## 6. Catatan teknis singkat
- Semua simpan/ubah/hapus memakai metode POST dengan token CSRF bawaan Laravel (`@csrf`).
- Query memakai Query Builder Laravel (prepared statements). Output di-escape otomatis oleh Blade (`{{ }}`).
- Logout kini memakai tombol (POST), bukan tautan.
- Pesan "gagal login" dibatasi 10 percobaan per menit (`throttle`).
