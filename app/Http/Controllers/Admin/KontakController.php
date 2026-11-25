<?php

namespace App\Http\Controllers\Admin;

class KontakController extends SingleFormController
{
    protected function config(): array
    {
        return [
            'table' => 'kontak', 'slug' => 'kontak', 'menu' => 'kontak',
            'judul' => 'Informasi Kontak', 'namaItem' => 'Informasi kontak',
            'deskripsi' => 'Tampil di kartu "Informasi Kontak" pada bagian Contact di website. Kosongkan satu bagian untuk menyembunyikannya.',
            'fields' => [
                ['type' => 'section', 'label' => 'Instagram'],
                ['name' => 'instagram_username', 'label' => 'Username Instagram', 'maxlength' => 100, 'placeholder' => '_muhkaseed', 'rules' => 'nullable|string|max:100'],
                ['name' => 'instagram_link', 'label' => 'Link Instagram', 'maxlength' => 255, 'placeholder' => 'https://instagram.com/username', 'rules' => 'nullable|url:http,https|max:255'],
                ['type' => 'section', 'label' => 'WhatsApp'],
                ['name' => 'whatsapp_nomor', 'label' => 'Nomor WhatsApp', 'maxlength' => 30, 'placeholder' => '6281234567890', 'rules' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s]+$/'],
                    'hint' => 'Format internasional tanpa tanda +, contoh 6281234567890.', 'messages' => ['regex' => 'Nomor WhatsApp hanya boleh berisi angka.']],
                ['name' => 'whatsapp_tampil', 'label' => 'Teks yang ditampilkan', 'maxlength' => 100, 'placeholder' => 'muhkaseed', 'rules' => 'nullable|string|max:100',
                    'hint' => 'Jika dikosongkan, website menampilkan nomor WhatsApp.'],
                ['name' => 'whatsapp_link', 'label' => 'Link WhatsApp', 'full' => true, 'maxlength' => 255, 'placeholder' => 'https://wa.me/6281234567890', 'rules' => 'nullable|url:http,https|max:255'],
                ['type' => 'section', 'label' => 'Email'],
                ['name' => 'email_alamat', 'label' => 'Alamat email', 'maxlength' => 100, 'placeholder' => 'nama@email.com', 'rules' => 'nullable|email|max:100'],
                ['name' => 'email_link', 'label' => 'Link email', 'maxlength' => 255, 'placeholder' => 'mailto:nama@email.com', 'rules' => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|mailto:[^\s@]+@[^\s@]+\.[^\s@]+$)/i'],
                    'messages' => ['regex' => 'Link email harus diawali mailto: (contoh mailto:nama@email.com) atau https://']],
            ],
        ];
    }
}
