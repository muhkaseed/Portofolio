<?php

namespace App\Http\Controllers\Admin;

class ProfilController extends SingleFormController
{
    protected function config(): array
    {
        return [
            'table' => 'profil', 'slug' => 'profil', 'menu' => 'profil',
            'judul' => 'Profil / About Me', 'namaItem' => 'Profil',
            'deskripsi' => 'Data ini tampil di bagian Home (nama & perkenalan) dan About Me pada website. Foto profil tidak dikelola di sini.',
            'fields' => [
                ['type' => 'section', 'label' => 'Identitas'],
                ['name' => 'nama', 'label' => 'Nama lengkap', 'required' => true, 'full' => true, 'maxlength' => 100, 'rules' => 'required|string|max:100',
                    'hint' => 'Dua kata terakhir tampil berwarna di judul Home, mis. "Muhammad <b>Kais Sidd</b>".'],
                ['name' => 'nim', 'label' => 'NIM / NRP', 'maxlength' => 30, 'rules' => 'nullable|string|max:30'],
                ['name' => 'prodi', 'label' => 'Program studi', 'maxlength' => 150, 'rules' => 'nullable|string|max:150'],
                ['name' => 'email', 'label' => 'Email', 'maxlength' => 100, 'rules' => 'nullable|email|max:100'],
                ['name' => 'status_mahasiswa', 'label' => 'Status mahasiswa', 'type' => 'checkbox', 'text' => 'Mahasiswa aktif'],
                ['name' => 'asal', 'label' => 'Asal daerah', 'maxlength' => 100, 'rules' => 'nullable|string|max:100'],
                ['name' => 'domisili', 'label' => 'Domisili', 'maxlength' => 100, 'rules' => 'nullable|string|max:100'],
                ['type' => 'section', 'label' => 'Minat & tujuan'],
                ['name' => 'minat', 'label' => 'Minat', 'maxlength' => 255, 'rules' => 'nullable|string|max:255'],
                ['name' => 'sedang_dipelajari', 'label' => 'Sedang dipelajari', 'maxlength' => 255, 'rules' => 'nullable|string|max:255'],
                ['name' => 'tujuan_karier', 'label' => 'Tujuan karier', 'full' => true, 'maxlength' => 255, 'rules' => 'nullable|string|max:255'],
                ['type' => 'section', 'label' => 'Halaman Home'],
                ['name' => 'tagline', 'label' => 'Tagline (teks kecil di atas nama)', 'full' => true, 'maxlength' => 150, 'rules' => 'nullable|string|max:150'],
                ['name' => 'deskripsi', 'label' => 'Deskripsi / perkenalan diri', 'type' => 'textarea', 'required' => true, 'rows' => 7, 'full' => true, 'rules' => 'required|string|max:3000'],
            ],
        ];
    }
}
