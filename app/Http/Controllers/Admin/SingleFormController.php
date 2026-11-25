<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Induk untuk menu yang hanya punya 1 data (Profil dan Informasi Kontak).
 * Datanya selalu berada di baris id = 1.
 */
abstract class SingleFormController extends Controller
{
    use FormHelper;

    abstract protected function config(): array;

    public function edit()
    {
        $c = $this->config();
        $row = DB::table($c['table'])->where('id', 1)->first();

        return view('admin.crud.form', [
            'c' => $c, 'values' => $row ? (array) $row : [], 'judul' => $c['judul'],
            'action' => route("admin.{$c['slug']}.update"), 'tombol' => 'Simpan Perubahan',
            'batal' => route('admin.dashboard'),
        ]);
    }

    public function update(Request $request)
    {
        $c = $this->config();
        $data = $this->validasiForm($request, $c['fields']);
        DB::table($c['table'])->updateOrInsert(['id' => 1], $data);
        $this->flash($c['namaItem'] . ' berhasil diperbarui.');

        return redirect()->route("admin.{$c['slug']}.edit");
    }
}
