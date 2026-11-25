<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Induk untuk semua menu CRUD (Skills, Education, Experience, Projects, Certificates).
 * Isi tiap menu (tabel, kolom, field form) ada di fungsi config() pada controller anaknya.
 */
abstract class CrudController extends Controller
{
    use FormHelper;

    abstract protected function config(): array;

    // Boleh di-override untuk menyesuaikan data sebelum disimpan.
    protected function siapkan(array $data): array
    {
        return $data;
    }

    public function index()
    {
        $c = $this->config();
        $query = DB::table($c['table']);
        foreach ($c['order'] as $kolom) {
            $query->orderBy($kolom);
        }

        return view('admin.crud.index', ['c' => $c, 'rows' => $query->get()]);
    }

    public function create()
    {
        $c = $this->config();
        $nilai = $c['defaults'] ?? [];
        if (collect($c['fields'])->contains('name', 'urutan')) {
            $nilai['urutan'] = (int) DB::table($c['table'])->max('urutan') + 1;
        }

        return view('admin.crud.form', [
            'c' => $c, 'values' => $nilai, 'judul' => $c['tambahJudul'],
            'action' => route("admin.{$c['slug']}.store"), 'tombol' => 'Simpan',
            'batal' => route("admin.{$c['slug']}.index"),
        ]);
    }

    public function store(Request $request)
    {
        $c = $this->config();
        $data = $this->siapkan($this->validasiForm($request, $c['fields']));
        DB::table($c['table'])->insert($data);
        $this->flash($c['namaItem'] . ' berhasil ditambahkan.');

        return redirect()->route("admin.{$c['slug']}.index");
    }

    public function edit(int $id)
    {
        $c = $this->config();
        $row = DB::table($c['table'])->where('id', $id)->first();
        if (! $row) {
            return $this->tidakDitemukan($c);
        }

        return view('admin.crud.form', [
            'c' => $c, 'values' => (array) $row, 'judul' => $c['editJudul'],
            'action' => route("admin.{$c['slug']}.update", $id), 'tombol' => 'Simpan Perubahan',
            'batal' => route("admin.{$c['slug']}.index"),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $c = $this->config();
        if (! DB::table($c['table'])->where('id', $id)->exists()) {
            return $this->tidakDitemukan($c);
        }
        $data = $this->siapkan($this->validasiForm($request, $c['fields']));
        DB::table($c['table'])->where('id', $id)->update($data);
        $this->flash($c['namaItem'] . ' berhasil diperbarui.');

        return redirect()->route("admin.{$c['slug']}.index");
    }

    public function destroy(int $id)
    {
        $c = $this->config();
        $hapus = DB::table($c['table'])->where('id', $id)->delete();
        $hapus > 0
            ? $this->flash($c['namaItem'] . ' berhasil dihapus.')
            : $this->flash('Data tidak ditemukan.', 'error');

        return redirect()->route("admin.{$c['slug']}.index");
    }

    private function tidakDitemukan(array $c)
    {
        $this->flash('Data tidak ditemukan.', 'error');

        return redirect()->route("admin.{$c['slug']}.index");
    }
}
