-- ==========================================================
-- PRAKTIKUM 6 - PHP DAN MYSQL
-- Jalankan dari terminal Laragon (folder portfolio):
--   mysql -u root < database.sql
-- ==========================================================

CREATE DATABASE IF NOT EXISTS db_cv
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_cv;

-- Tabel pesan kontak (Tugas Pendahuluan)
CREATE TABLE IF NOT EXISTS pesan_kontak (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  nama    VARCHAR(100) NOT NULL,
  email   VARCHAR(100) NOT NULL,
  subjek  VARCHAR(150) NOT NULL DEFAULT '',
  pesan   TEXT NOT NULL,
  tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel admin (login)
CREATE TABLE IF NOT EXISTS admin (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- Tabel skill (data CV yang dikelola lewat admin)
CREATE TABLE IF NOT EXISTS skill (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nama_skill VARCHAR(100) NOT NULL,
  tingkat    VARCHAR(30) NOT NULL DEFAULT 'Pemula'
);

-- Akun admin awal: username "admin", password "admin123" (disimpan sebagai hash)
-- Segera ganti setelah praktikum.
INSERT INTO admin (username, password)
SELECT 'admin', '$2y$10$lQNzPGBDAHOyygMiU.xAEO9z45iqJY0j40NSsaXDH2RQpbxn70Mo6'
WHERE NOT EXISTS (SELECT 1 FROM admin WHERE username = 'admin');

-- Data skill awal (diambil dari array statis Praktikum 5)
INSERT INTO skill (nama_skill, tingkat)
SELECT * FROM (
  SELECT 'HTML' AS nama_skill, 'Menengah' AS tingkat UNION ALL
  SELECT 'CSS', 'Menengah' UNION ALL
  SELECT 'JavaScript', 'Pemula' UNION ALL
  SELECT 'PHP', 'Pemula' UNION ALL
  SELECT 'MySQL', 'Pemula' UNION ALL
  SELECT 'C/C++', 'Pemula' UNION ALL
  SELECT 'Java', 'Pemula' UNION ALL
  SELECT 'Blender', 'Menengah' UNION ALL
  SELECT '2D Design', 'Menengah' UNION ALL
  SELECT '3D Design', 'Pemula'
) AS awal
WHERE NOT EXISTS (SELECT 1 FROM skill);
