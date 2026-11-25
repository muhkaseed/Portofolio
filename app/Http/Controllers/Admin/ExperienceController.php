<?php

namespace App\Http\Controllers\Admin;

class ExperienceController extends CrudController
{
    protected function config(): array
    {
        return [
            'table' => 'experience', 'slug' => 'experience', 'menu' => 'experience', 'order' => ['urutan', 'id'],
            'judul' => 'Experience', 'deskripsi' => 'Pengalaman organisasi, kepanitiaan, dan kegiatan. Urutan tampil mengikuti kolom "Urutan".',
            'tambahJudul' => 'Tambah Pengalaman', 'editJudul' => 'Edit Pengalaman', 'tombolTambah' => 'Tambah Pengalaman',
            'namaItem' => 'Pengalaman', 'kosong' => 'Belum ada data pengalaman.',
            'kolom' => [
                ['Organisasi / Kegiatan', fn ($r) => '<span class="cell-title">' . e($r->organisasi) . '</span>'
                    . ($r->jabatan !== '' ? '<span class="cell-sub">' . e($r->jabatan) . '</span>' : '')],
                ['Periode', fn ($r) => e($r->periode)],
                ['Tanggung jawab', fn ($r) => '<span class="cell-clip">' . e(str_replace(["\r\n", "\n"], ' • ', (string) $r->tanggung_jawab)) . '</span>'],
                ['Urutan', fn ($r) => (int) $r->urutan],
            ],
            'hapusTanya' => fn ($r) => 'Hapus pengalaman "' . $r->organisasi . '"?',
            'fields' => [
                ['name' => 'organisasi', 'label' => 'Nama organisasi / kegiatan', 'required' => true, 'maxlength' => 150, 'placeholder' => 'Wonderkind Festival', 'rules' => 'required|string|max:150'],
                ['name' => 'jabatan', 'label' => 'Jabatan / posisi', 'maxlength' => 150, 'placeholder' => 'Divisi Percetakan', 'rules' => 'nullable|string|max:150', 'hint' => 'Judul di website: "Organisasi — Jabatan".'],
                ['name' => 'periode', 'label' => 'Periode', 'required' => true, 'maxlength' => 50, 'placeholder' => '2024 atau 2026–sekarang', 'rules' => 'required|string|max:50'],
                ['name' => 'urutan', 'label' => 'Urutan tampil', 'type' => 'number', 'maxlength' => 4, 'rules' => 'nullable|integer|between:0,9999', 'hint' => 'Angka kecil tampil lebih dulu.'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi pengalaman', 'type' => 'textarea', 'rows' => 4, 'full' => true, 'db_null' => true, 'rules' => 'nullable|string|max:5000',
                    'hint' => 'Opsional. Jika diisi, tampil sebagai paragraf di dalam detail pengalaman.'],
                ['name' => 'tanggung_jawab', 'label' => 'Tanggung jawab / kontribusi', 'type' => 'textarea', 'rows' => 6, 'full' => true, 'db_null' => true, 'rules' => 'nullable|string|max:5000',
                    'hint' => 'Satu poin per baris — tekan Enter untuk membuat poin baru.'],
            ],
        ];
    }
}
