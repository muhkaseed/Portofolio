<?php

namespace App\Http\Controllers\Admin;

class CertificateController extends CrudController
{
    protected function config(): array
    {
        return [
            'table' => 'certificates', 'slug' => 'certificates', 'menu' => 'certificates', 'order' => ['urutan', 'id'],
            'judul' => 'Certificates', 'deskripsi' => 'Sertifikat di bagian Certificates. Urutan tampil mengikuti kolom "Urutan".',
            'tambahJudul' => 'Tambah Sertifikat', 'editJudul' => 'Edit Sertifikat', 'tombolTambah' => 'Tambah Sertifikat',
            'namaItem' => 'Sertifikat', 'kosong' => 'Belum ada data sertifikat.',
            'defaults' => ['ikon' => 'award'],
            'kolom' => [
                ['Nama Sertifikat', fn ($r) => '<span class="cell-title">' . e($r->nama) . '</span>'],
                ['Penyelenggara', fn ($r) => $r->penyelenggara !== '' ? e($r->penyelenggara) : '–'],
                ['Tahun', fn ($r) => $r->tahun !== '' ? e($r->tahun) : '–'],
                ['Urutan', fn ($r) => (int) $r->urutan],
            ],
            'hapusTanya' => fn ($r) => 'Hapus sertifikat "' . $r->nama . '"?',
            'fields' => [
                ['name' => 'nama', 'label' => 'Nama sertifikat', 'required' => true, 'full' => true, 'maxlength' => 200, 'rules' => 'required|string|max:200'],
                ['name' => 'penyelenggara', 'label' => 'Penyelenggara', 'maxlength' => 150, 'rules' => 'nullable|string|max:150'],
                ['name' => 'tahun', 'label' => 'Tahun / tanggal terbit', 'maxlength' => 30, 'placeholder' => '2024', 'rules' => 'nullable|string|max:30'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi / keterangan', 'type' => 'textarea', 'rows' => 3, 'full' => true, 'db_null' => true, 'rules' => 'nullable|string|max:2000',
                    'hint' => 'Opsional. Jika diisi, tampil di bawah penyelenggara.'],
                ['name' => 'link', 'label' => 'Link sertifikat', 'db_null' => true, 'maxlength' => 255, 'placeholder' => 'https://...', 'rules' => 'nullable|url:http,https|max:255',
                    'hint' => 'Opsional. Jika diisi, muncul tautan "Lihat sertifikat".'],
                ['name' => 'ikon', 'label' => 'Ikon kartu', 'type' => 'select', 'options' => ['award' => 'Medali (lomba / penghargaan)', 'book' => 'Buku (hafalan / pelatihan)'], 'rules' => 'required|in:award,book'],
                ['name' => 'urutan', 'label' => 'Urutan tampil', 'type' => 'number', 'maxlength' => 4, 'rules' => 'nullable|integer|between:0,9999', 'hint' => 'Angka kecil tampil lebih dulu.'],
            ],
        ];
    }
}
