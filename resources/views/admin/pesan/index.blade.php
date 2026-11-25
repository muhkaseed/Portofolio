@extends('layouts.admin')
@section('title', 'Pesan Kontak')
@section('menu', 'pesan')

@section('content')
    <div class="page-head">
      <div>
        <h1 class="admin-title">Pesan Kontak</h1>
        <p class="admin-sub">Pesan dari form kontak di website. Klik "Baca" untuk melihat isi lengkap.</p>
      </div>
    </div>

    <div class="card table-card">
      <table class="data-table">
        <thead>
          <tr><th class="col-no">No</th><th>Pengirim</th><th>Subjek &amp; Pesan</th><th>Tanggal</th><th class="col-aksi">Aksi</th></tr>
        </thead>
        <tbody>
          @forelse ($pesan as $b)
            <tr>
              <td class="col-no">{{ $loop->iteration }}</td>
              <td data-label="Pengirim">
                <span class="cell-title">{{ $b->nama }}</span>
                <span class="cell-sub">{{ $b->email }}</span>
              </td>
              <td data-label="Subjek & Pesan">
                @if ($b->subjek !== '')<span class="cell-title">{{ $b->subjek }}</span>@endif
                <span class="cell-clip">{{ $b->pesan }}</span>
              </td>
              <td data-label="Tanggal">{{ $b->tanggal }}</td>
              <td class="col-aksi">
                <div class="aksi-group">
                  <a class="btn-aksi btn-lihat" href="{{ route('admin.pesan.show', $b->id) }}"><x-ikon name="eye" /><span>Baca</span></a>
                  @include('admin.partials.hapus', ['action' => route('admin.pesan.destroy', $b->id), 'tanya' => 'Hapus pesan dari "' . $b->nama . '"?'])
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="kosong">Belum ada pesan masuk.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
@endsection
