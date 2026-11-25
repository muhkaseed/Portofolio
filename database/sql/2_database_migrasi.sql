-- ==========================================================
-- MIGRASI DATABASE db_cv  —  Pengembangan Dashboard Admin
-- ----------------------------------------------------------
-- AMAN dijalankan pada database yang sudah ada dan berisi data:
--   * TIDAK menghapus / mengubah tabel admin, skill, pesan_kontak.
--   * TIDAK menghapus data apa pun.
--   * Hanya MEMBUAT tabel baru jika belum ada (CREATE TABLE IF NOT EXISTS).
--   * Data awal (dari index.php lama) hanya dimasukkan jika tabelnya MASIH KOSONG,
--     jadi aman dijalankan berulang kali tanpa membuat data dobel.
--
-- Cara menjalankan (Laragon):
--   Menu Database (HeidiSQL) > pilih db_cv > File > Run SQL file...
--   atau phpMyAdmin > pilih db_cv > tab Import > pilih file ini.
--   atau terminal Laragon:  mysql -u root db_cv < database_migrasi.sql
-- ==========================================================

SET NAMES utf8mb4;
USE db_cv;

-- ----------------------------------------------------------
-- 1. PROFIL  (hanya 1 baris, id = 1)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS profil (
  id                INT NOT NULL PRIMARY KEY,
  nama              VARCHAR(100) NOT NULL,
  nim               VARCHAR(30)  NOT NULL DEFAULT '',
  prodi             VARCHAR(150) NOT NULL DEFAULT '',
  email             VARCHAR(100) NOT NULL DEFAULT '',
  status_mahasiswa  TINYINT(1)   NOT NULL DEFAULT 1,
  asal              VARCHAR(100) NOT NULL DEFAULT '',
  domisili          VARCHAR(100) NOT NULL DEFAULT '',
  minat             VARCHAR(255) NOT NULL DEFAULT '',
  sedang_dipelajari VARCHAR(255) NOT NULL DEFAULT '',
  tujuan_karier     VARCHAR(255) NOT NULL DEFAULT '',
  tagline           VARCHAR(150) NOT NULL DEFAULT '',
  deskripsi         TEXT NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO profil
  (id, nama, nim, prodi, email, status_mahasiswa, asal, domisili, minat, sedang_dipelajari, tujuan_karier, tagline, deskripsi)
SELECT
  1,
  'Muhammad Kais Sidd',
  '5325600089',
  'Teknologi Rekayasa Multimedia',
  'mkaissidd@gmail.com',
  1,
  'Bekasi',
  'Kos Keputih',
  'Ngoding, Futsal, Brainstorming',
  '3D Modelling, Desain Web',
  'Design Website',
  'Multimedia Engineering Technology Student',
  'Saya adalah mahasiswa D4 Teknologi Rekayasa Multimedia di PENS yang memiliki ketertarikan pada desain, pengembangan web, dan teknologi multimedia. Saya senang mengeksplorasi ide kreatif dan mengubahnya menjadi karya digital, baik melalui desain maupun pengembangan aplikasi sederhana. Saya terus mengembangkan kemampuan di bidang teknologi dan desain melalui berbagai proyek, tugas, dan pengalaman organisasi.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM profil);

-- ----------------------------------------------------------
-- 2. EDUCATION
--    tahun_selesai = NULL berarti "sekarang" (masih berjalan)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS education (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  institusi      VARCHAR(150) NOT NULL,
  jenjang        VARCHAR(30)  NOT NULL DEFAULT '',
  jurusan        VARCHAR(150) NOT NULL DEFAULT '',
  tahun_mulai    SMALLINT NOT NULL,
  tahun_selesai  SMALLINT NULL,
  keterangan     TEXT NULL,
  urutan         INT NOT NULL DEFAULT 0
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO education (institusi, jenjang, jurusan, tahun_mulai, tahun_selesai, keterangan, urutan)
SELECT * FROM (
  SELECT 'Politeknik Elektronika Negeri Surabaya (PENS)' AS institusi, 'D4' AS jenjang,
         'Teknologi Rekayasa Multimedia' AS jurusan, 2025 AS tahun_mulai, NULL AS tahun_selesai,
         NULL AS keterangan, 1 AS urutan
  UNION ALL
  SELECT 'SMA IT Darul Qur''an', 'SMA', 'Teknik', 2022, 2025, NULL, 2
) AS awal
WHERE NOT EXISTS (SELECT 1 FROM education);

-- ----------------------------------------------------------
-- 3. EXPERIENCE
--    tanggung_jawab: satu poin per baris (tekan Enter untuk poin baru)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS experience (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  organisasi      VARCHAR(150) NOT NULL,
  jabatan         VARCHAR(150) NOT NULL DEFAULT '',
  periode         VARCHAR(50)  NOT NULL DEFAULT '',
  deskripsi       TEXT NULL,
  tanggung_jawab  TEXT NULL,
  urutan          INT NOT NULL DEFAULT 0
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO experience (organisasi, jabatan, periode, deskripsi, tanggung_jawab, urutan)
SELECT * FROM (
  SELECT 'OSIS SMA' AS organisasi,
         'Divisi Ta''mir Masjid (Keimanan & Ketaqwaan)' AS jabatan,
         '2023–2024' AS periode, NULL AS deskripsi,
         'Berkontribusi dalam kegiatan keagamaan dan pengelolaan aktivitas masjid.\nBekerja sama dalam tim untuk mendukung pelaksanaan kegiatan.' AS tanggung_jawab,
         1 AS urutan
  UNION ALL
  SELECT 'Wonderkind Festival', 'Divisi Percetakan', '2024', NULL,
         'Bertanggung jawab dalam proses produksi dan pencetakan banner.\nMengelola pembuatan merchandise seperti baju dan item acara.\nBerkoordinasi dengan tim untuk memastikan hasil produksi sesuai kebutuhan.', 2
  UNION ALL
  SELECT 'DTMK EXPO', 'Divisi Acara', '2026', NULL,
         'Berkontribusi dalam perencanaan dan pelaksanaan acara.\nBekerja sama dalam tim untuk memastikan kelancaran kegiatan.', 3
  UNION ALL
  SELECT 'Grand Opening Mentoring', 'Koordinator Divisi Acara', '2026', NULL,
         'Bertanggung jawab mengonsep jalannya acara.\nMelakukan koordinasi dengan divisi lain.\nBekerja sama dengan panitia lain untuk memastikan kelancaran acara.', 4
  UNION ALL
  SELECT 'Staff UKKI PENS', 'Divisi Syi''ar', '2026–sekarang', NULL,
         'Membuat kegiatan ngaji bersama untuk seluruh staf UKKI.\nMembuat kegiatan saat Ramadan.', 5
) AS awal
WHERE NOT EXISTS (SELECT 1 FROM experience);

-- ----------------------------------------------------------
-- 4. PROJECTS
--    status_tipe menentukan warna label: done = hijau, progress = kuning, paused = abu-abu
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nama         VARCHAR(150) NOT NULL,
  kategori     VARCHAR(100) NOT NULL,
  tahun        SMALLINT NULL,
  deskripsi    TEXT NOT NULL,
  teknologi    VARCHAR(255) NULL,
  link         VARCHAR(255) NULL,
  status       VARCHAR(120) NOT NULL DEFAULT 'Dalam pengembangan',
  status_tipe  VARCHAR(10)  NOT NULL DEFAULT 'progress'
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO projects (nama, kategori, tahun, deskripsi, teknologi, link, status, status_tipe)
SELECT * FROM (
  SELECT 'Kostra' AS nama, 'Website' AS kategori, NULL AS tahun,
         'Website pencarian kos di kawasan ITS Raya untuk membantu mahasiswa menemukan tempat kos yang sesuai.' AS deskripsi,
         NULL AS teknologi, NULL AS link, 'Dalam pengembangan' AS status, 'progress' AS status_tipe
  UNION ALL
  SELECT 'Portofolio', 'Web Development', NULL,
         'Website portofolio pribadi untuk menampilkan profil, kemampuan, pengalaman, dan berbagai karya digital.',
         NULL, NULL, 'Dalam pengembangan', 'progress'
  UNION ALL
  SELECT 'Intinya Kacamata', 'Animasi 2D', NULL,
         'Animasi tentang seorang siswa yang datang terlambat dan kesulitan melihat papan tulis karena duduk di bagian belakang kelas. Temannya kemudian mengenalkan kacamata ramah lingkungan yang dibuat dari bahan daur ulang. Cerita ini membawa pesan tentang kepedulian terhadap lingkungan.',
         NULL, NULL, 'Selesai', 'done'
  UNION ALL
  SELECT 'Satu Game Lagi', 'Animasi 3D', NULL,
         'Animasi tentang seorang anak yang diajak temannya keluar, tetapi terlalu lama bermain game di sebuah warung kopi hingga sore. Setelah keluarganya mencari dan anak tersebut mendapat nasihat, ia akhirnya pulang ke rumah. Cerita mengangkat tema pengelolaan waktu dan penggunaan game secara bijak.',
         NULL, NULL, 'Dalam pengembangan', 'progress'
  UNION ALL
  SELECT 'Roomify', 'AR/VR', NULL,
         'Proyek aplikasi atau pengalaman interaktif untuk menata interior ruangan dengan menempatkan furnitur, seperti sofa dan tempat tidur, ke dalam ruangan kosong.',
         NULL, NULL, 'Dalam pengembangan', 'progress'
  UNION ALL
  SELECT '3D Assets, Objects & Characters', 'Blender / 3D Modelling', NULL,
         'Kumpulan latihan dan karya pembuatan aset, objek, serta karakter 3D menggunakan Blender.',
         NULL, NULL, 'Dalam pengembangan', 'progress'
  UNION ALL
  SELECT 'Asal-Usul Banyuwangi', 'Visual Novel / Ren''Py', NULL,
         'Visual novel yang mengangkat legenda asal-usul Banyuwangi dalam bentuk cerita interaktif.',
         NULL, NULL, 'Selesai', 'done'
  UNION ALL
  SELECT 'Poster Design', 'Desain Grafis', NULL,
         'Kumpulan pengalaman berpartisipasi dalam kompetisi desain poster Language Improvement Competition (LIC) dan OHARA.',
         NULL, NULL, 'Selesai', 'done'
  UNION ALL
  SELECT 'Progres Gw', 'Website Produktivitas / Eksperimen Web', NULL,
         'Eksperimen website produktivitas yang memanfaatkan spreadsheet atau data sebagai bagian dari sistem, dengan integrasi GitHub dan deployment melalui Vercel. Pengembangan tidak dilanjutkan untuk saat ini karena masih terdapat sejumlah masalah yang belum diselesaikan.',
         NULL, NULL, 'Belum selesai — tidak dilanjutkan untuk saat ini', 'paused'
) AS awal
WHERE NOT EXISTS (SELECT 1 FROM projects);

-- ----------------------------------------------------------
-- 5. CERTIFICATES
--    ikon: 'award' (medali) atau 'book' (buku)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS certificates (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nama         VARCHAR(200) NOT NULL,
  penyelenggara VARCHAR(150) NOT NULL DEFAULT '',
  tahun        VARCHAR(30)  NOT NULL DEFAULT '',
  deskripsi    TEXT NULL,
  link         VARCHAR(255) NULL,
  ikon         VARCHAR(10)  NOT NULL DEFAULT 'award',
  urutan       INT NOT NULL DEFAULT 0
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO certificates (nama, penyelenggara, tahun, deskripsi, link, ikon, urutan)
SELECT * FROM (
  SELECT 'Sertifikat Lomba Desain Poster – LIC' AS nama, 'Language Improvement Competition' AS penyelenggara,
         '2022' AS tahun, NULL AS deskripsi, NULL AS link, 'award' AS ikon, 1 AS urutan
  UNION ALL
  SELECT 'Sertifikat Lomba Desain Poster – OHARA', '', '2024', NULL, NULL, 'award', 2
  UNION ALL
  SELECT 'Sertifikat Hafalan 3 Juz Al-Qur''an', '', '2025', NULL, NULL, 'book', 3
) AS awal
WHERE NOT EXISTS (SELECT 1 FROM certificates);

-- ----------------------------------------------------------
-- 6. KONTAK  (hanya 1 baris, id = 1)
--    whatsapp_tampil = teks yang terlihat di website (boleh beda dengan nomor)
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS kontak (
  id                  INT NOT NULL PRIMARY KEY,
  instagram_username  VARCHAR(100) NOT NULL DEFAULT '',
  instagram_link      VARCHAR(255) NOT NULL DEFAULT '',
  whatsapp_nomor      VARCHAR(30)  NOT NULL DEFAULT '',
  whatsapp_tampil     VARCHAR(100) NOT NULL DEFAULT '',
  whatsapp_link       VARCHAR(255) NOT NULL DEFAULT '',
  email_alamat        VARCHAR(100) NOT NULL DEFAULT '',
  email_link          VARCHAR(255) NOT NULL DEFAULT ''
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO kontak
  (id, instagram_username, instagram_link, whatsapp_nomor, whatsapp_tampil, whatsapp_link, email_alamat, email_link)
SELECT
  1,
  '_muhkaseed', 'https://instagram.com/_muhkaseed',
  '6282210175074', 'muhkaseed', 'https://wa.me/6282210175074',
  'mkaissidd@gmail.com', 'mailto:mkaissidd@gmail.com'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM kontak);

-- Selesai. Tabel admin, skill, dan pesan_kontak tidak disentuh sama sekali.
