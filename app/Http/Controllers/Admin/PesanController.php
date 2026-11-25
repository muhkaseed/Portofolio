<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PesanController extends Controller
{
    public function index()
    {
        return view('admin.pesan.index', ['pesan' => DB::table('pesan_kontak')->orderByDesc('id')->get()]);
    }

    public function show(int $id)
    {
        $pesan = DB::table('pesan_kontak')->where('id', $id)->first();
        if (! $pesan) {
            session()->flash('flash', 'Pesan tidak ditemukan.');
            session()->flash('flash_tipe', 'error');

            return redirect()->route('admin.pesan.index');
        }

        return view('admin.pesan.show', compact('pesan'));
    }

    public function destroy(int $id)
    {
        $hapus = DB::table('pesan_kontak')->where('id', $id)->delete();
        session()->flash('flash', $hapus > 0 ? 'Pesan berhasil dihapus.' : 'Data tidak ditemukan.');
        session()->flash('flash_tipe', $hapus > 0 ? 'ok' : 'error');

        return redirect()->route('admin.pesan.index');
    }
}
