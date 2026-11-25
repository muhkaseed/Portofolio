@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('menu', 'pesan')

@section('content')
    <div class="page-head">
      <div>
        <h1 class="admin-title">Detail Pesan</h1>
        <p class="admin-sub">Pesan dari pengunjung website.</p>
      </div>
      <a class="btn-ghost" href="{{ route('admin.pesan.index') }}"><x-ikon name="back" />&nbsp;Kembali</a>
    </div>

    <article class="card pesan-detail">
      <div class="pesan-meta">
        <strong>{{ $pesan->nama }}</strong>
        <a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a>
        <time datetime="{{ $pesan->tanggal }}">{{ $pesan->tanggal }}</time>
      </div>
      @if ($pesan->subjek !== '')
        <p class="pesan-subjek">{{ $pesan->subjek }}</p>
      @endif
      <p class="pesan-isi">{!! nl2br(e($pesan->pesan)) !!}</p>

      <div class="form-actions">
        <a class="btn" href="mailto:{{ $pesan->email }}?subject={{ rawurlencode('Re: ' . $pesan->subjek) }}"><x-ikon name="mail" />Balas via Email</a>
        @include('admin.partials.hapus', ['action' => route('admin.pesan.destroy', $pesan->id), 'tanya' => 'Hapus pesan dari "' . $pesan->nama . '"?'])
      </div>
    </article>
@endsection
