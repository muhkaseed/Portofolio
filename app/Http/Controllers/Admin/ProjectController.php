<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;

class ProjectController extends CrudController
{
    private const STATUS_BAWAAN = [
        'done' => 'Selesai',
        'progress' => 'Dalam pengembangan',
        'paused' => 'Belum selesai — tidak dilanjutkan untuk saat ini',
    ];

    // Jika teks status dikosongkan, pakai teks bawaan sesuai jenis status.
    protected function siapkan(array $data): array
    {
        if ($data['status'] === '') {
            $data['status'] = self::STATUS_BAWAAN[$data['status_tipe']];
        }

        return $data;
    }

    protected function config(): array
    {
        $kategori = DB::table('projects')->distinct()->orderBy('kategori')->pluck('kategori')->all();

        return [
            'table' => 'projects', 'slug' => 'projects', 'menu' => 'projects', 'order' => ['id'],
            'judul' => 'Projects', 'deskripsi' => 'Proyek di bagian Projects. Kategori yang Anda isi otomatis muncul di filter kategori pada website.',
            'tambahJudul' => 'Tambah Project', 'editJudul' => 'Edit Project', 'tombolTambah' => 'Tambah Project',
            'namaItem' => 'Project', 'kosong' => 'Belum ada data project.',
            'defaults' => ['status_tipe' => 'progress'],
            'kolom' => [
                ['Nama Project', fn ($r) => '<span class="cell-title">' . e($r->nama) . '</span><span class="cell-clip">' . e($r->deskripsi) . '</span>'],
                ['Kategori', fn ($r) => e($r->kategori)],
                ['Tahun', fn ($r) => $r->tahun === null ? '–' : e($r->tahun)],
                ['Status', fn ($r) => '<span class="badge badge-' . (in_array($r->status_tipe, ['done', 'progress', 'paused'], true) ? $r->status_tipe : 'progress') . '">' . e($r->status) . '</span>'],
            ],
            'hapusTanya' => fn ($r) => 'Hapus project "' . $r->nama . '"?',
            'fields' => [
                ['name' => 'nama', 'label' => 'Nama project', 'required' => true, 'full' => true, 'maxlength' => 150, 'rules' => 'required|string|max:150'],
                ['name' => 'kategori', 'label' => 'Kategori', 'type' => 'datalist', 'required' => true, 'maxlength' => 100, 'options' => $kategori, 'rules' => 'required|string|max:100',
                    'hint' => 'Pilih dari saran atau ketik kategori baru. Menjadi pilihan di filter website.'],
                ['name' => 'tahun', 'label' => 'Tahun', 'type' => 'number', 'db_null' => true, 'maxlength' => 4, 'placeholder' => '2025', 'rules' => 'nullable|integer|between:1990,2100',
                    'hint' => 'Kosong = "belum dicantumkan". Project diurutkan dari tahun terbaru.'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi project', 'type' => 'textarea', 'required' => true, 'rows' => 5, 'full' => true, 'rules' => 'required|string|max:3000'],
                ['name' => 'teknologi', 'label' => 'Teknologi / tools', 'db_null' => true, 'maxlength' => 255, 'placeholder' => 'PHP, MySQL, Blender', 'rules' => 'nullable|string|max:255',
                    'hint' => 'Opsional. Jika diisi, tampil di kartu project.'],
                ['name' => 'link', 'label' => 'Link project', 'db_null' => true, 'maxlength' => 255, 'placeholder' => 'https://...', 'rules' => 'nullable|url:http,https|max:255',
                    'hint' => 'Opsional. Jika diisi, tampil sebagai tautan di kartu project.'],
                ['name' => 'status_tipe', 'label' => 'Jenis status', 'type' => 'select', 'rules' => 'required|in:done,progress,paused',
                    'options' => ['done' => 'Selesai (hijau)', 'progress' => 'Dalam pengembangan (kuning)', 'paused' => 'Dihentikan / belum selesai (abu-abu)']],
                ['name' => 'status', 'label' => 'Teks status', 'maxlength' => 120, 'placeholder' => 'Kosongkan untuk teks bawaan', 'rules' => 'nullable|string|max:120',
                    'hint' => 'Teks pada label status. Kosong = teks bawaan sesuai jenis status.'],
            ],
        ];
    }
}
