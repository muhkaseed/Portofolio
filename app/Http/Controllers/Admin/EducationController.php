<?php

namespace App\Http\Controllers\Admin;

class EducationController extends CrudController
{
    protected function config(): array
    {
        return [
            'table' => 'education', 'slug' => 'education', 'menu' => 'education', 'order' => ['urutan', 'id'],
            'judul' => 'Education', 'deskripsi' => 'Riwayat pendidikan di bagian Education. Urutan tampil mengikuti kolom "Urutan".',
            'tambahJudul' => 'Tambah Pendidikan', 'editJudul' => 'Edit Pendidikan', 'tombolTambah' => 'Tambah Pendidikan',
            'namaItem' => 'Riwayat pendidikan', 'kosong' => 'Belum ada data pendidikan.',
            'kolom' => [
                ['Institusi', fn ($r) => '<span class="cell-title">' . e($r->institusi) . '</span>'],
                ['Jenjang & Jurusan', fn ($r) => e(trim($r->jenjang . ' ' . $r->jurusan))],
                ['Periode', fn ($r) => e($r->tahun_mulai) . ' – ' . ($r->tahun_selesai === null ? 'sekarang' : e($r->tahun_selesai))],
                ['Urutan', fn ($r) => (int) $r->urutan],
            ],
            'hapusTanya' => fn ($r) => 'Hapus riwayat pendidikan "' . $r->institusi . '"?',
            'fields' => [
                ['name' => 'institusi', 'label' => 'Nama institusi', 'required' => true, 'full' => true, 'maxlength' => 150, 'rules' => 'required|string|max:150'],
                ['name' => 'jenjang', 'label' => 'Jenjang pendidikan', 'type' => 'datalist', 'maxlength' => 30, 'placeholder' => 'D4, S1, SMA, ...',
                    'options' => ['SD', 'SMP', 'SMA', 'SMK', 'D3', 'D4', 'S1', 'S2', 'S3'], 'rules' => 'nullable|string|max:30',
                    'hint' => 'Jenjang D3/D4/S1/S2/S3 tampil sebagai "Program"; selain itu tampil sebagai "Jurusan".'],
                ['name' => 'jurusan', 'label' => 'Jurusan / program studi', 'maxlength' => 150, 'rules' => 'nullable|string|max:150'],
                ['name' => 'tahun_mulai', 'label' => 'Tahun mulai', 'type' => 'number', 'required' => true, 'maxlength' => 4, 'placeholder' => '2022', 'rules' => 'required|integer|between:1950,2100'],
                ['name' => 'tahun_selesai', 'label' => 'Tahun selesai', 'type' => 'number', 'db_null' => true, 'maxlength' => 4, 'placeholder' => '2025', 'rules' => 'nullable|integer|between:1950,2100|gte:tahun_mulai',
                    'hint' => 'Kosongkan jika masih berjalan (tampil "sekarang").'],
                ['name' => 'keterangan', 'label' => 'Keterangan tambahan', 'type' => 'textarea', 'rows' => 3, 'full' => true, 'db_null' => true, 'rules' => 'nullable|string|max:2000',
                    'hint' => 'Opsional. Jika diisi, tampil sebagai baris "Keterangan" di dalam detail pendidikan.'],
                ['name' => 'urutan', 'label' => 'Urutan tampil', 'type' => 'number', 'maxlength' => 4, 'rules' => 'nullable|integer|between:0,9999', 'hint' => 'Angka kecil tampil lebih dulu.'],
            ],
        ];
    }
}
