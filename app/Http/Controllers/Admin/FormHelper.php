<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Bantuan validasi form admin (dipakai oleh CrudController & SingleFormController).
 * Setiap field didefinisikan di controller masing-masing (lihat fungsi config()).
 */
trait FormHelper
{
    protected function pesanValidasi(array $fields): array
    {
        $pesan = [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute terlalu panjang (maksimal :max karakter).',
            'integer' => ':attribute harus berupa angka.',
            'between' => ':attribute harus antara :min dan :max.',
            'email' => 'Format :attribute tidak valid.',
            'in' => ':attribute tidak valid.',
            'url' => ':attribute harus diawali http:// atau https://',
            'regex' => 'Format :attribute tidak valid.',
            'gte' => ':attribute tidak boleh lebih kecil dari :value.',
        ];
        // Pesan khusus per field: 'messages' => ['regex' => '...'] di definisi field.
        foreach ($fields as $f) {
            foreach ($f['messages'] ?? [] as $aturan => $teks) {
                $pesan[$f['name'] . '.' . $aturan] = $teks;
            }
        }

        return $pesan;
    }

    // Validasi input lalu rapikan nilainya untuk disimpan ke database.
    protected function validasiForm(Request $request, array $fields): array
    {
        $rules = [];
        $atribut = [];
        foreach ($fields as $f) {
            $tipe = $f['type'] ?? 'text';
            if ($tipe === 'section' || $tipe === 'checkbox') {
                continue;
            }
            $rules[$f['name']] = $f['rules'] ?? 'nullable|string';
            $atribut[$f['name']] = $f['label'];
        }

        $valid = Validator::make($request->all(), $rules, $this->pesanValidasi($fields), $atribut)->validate();

        $data = [];
        foreach ($fields as $f) {
            $tipe = $f['type'] ?? 'text';
            $nama = $f['name'] ?? null;
            if ($tipe === 'section') {
                continue;
            }
            if ($tipe === 'checkbox') {
                $data[$nama] = $request->boolean($nama) ? 1 : 0;
                continue;
            }
            $nilai = $valid[$nama] ?? null;
            $bolehNull = $f['db_null'] ?? false;
            if ($nilai === null || $nilai === '') {
                $data[$nama] = $bolehNull ? null : ($tipe === 'number' ? 0 : '');
            } else {
                $data[$nama] = $tipe === 'number' ? (int) $nilai : $nilai;
            }
        }

        return $data;
    }

    protected function flash(string $pesan, string $tipe = 'ok'): void
    {
        session()->flash('flash', $pesan);
        session()->flash('flash_tipe', $tipe);
    }
}
