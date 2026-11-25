<?php

namespace App\Http\Controllers\Admin;

class SkillController extends CrudController
{
    protected function config(): array
    {
        return [
            'table' => 'skill', 'slug' => 'skill', 'menu' => 'skill', 'order' => ['id'],
            'judul' => 'Skills', 'deskripsi' => 'Daftar kemampuan yang tampil di bagian Skills pada website.',
            'tambahJudul' => 'Tambah Skill', 'editJudul' => 'Edit Skill', 'tombolTambah' => 'Tambah Skill',
            'namaItem' => 'Skill', 'kosong' => 'Belum ada data skill.', 'sempit' => true,
            'defaults' => ['tingkat' => 'Pemula'],
            'kolom' => [
                ['Nama Skill', fn ($r) => '<span class="cell-title">' . e($r->nama_skill) . '</span>'],
                ['Tingkat', fn ($r) => '<span class="badge badge-level">' . e($r->tingkat) . '</span>'],
            ],
            'hapusTanya' => fn ($r) => 'Hapus skill "' . $r->nama_skill . '"?',
            'fields' => [
                ['name' => 'nama_skill', 'label' => 'Nama Skill', 'required' => true, 'full' => true, 'maxlength' => 100, 'rules' => 'required|string|max:100'],
                ['name' => 'tingkat', 'label' => 'Tingkat kemampuan', 'type' => 'select', 'full' => true, 'options' => ['Pemula' => 'Pemula', 'Menengah' => 'Menengah', 'Mahir' => 'Mahir'], 'rules' => 'required|in:Pemula,Menengah,Mahir'],
            ],
        ];
    }
}
