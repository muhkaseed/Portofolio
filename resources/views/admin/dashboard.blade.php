@extends('layouts.admin')
@section('title', 'Dashboard')
@section('menu', 'dashboard')

@section('content')
    <div class="page-head">
      <div>
        <h1 class="admin-title">Halo, {{ session('username') }} 👋</h1>
        <p class="admin-sub">Kelola seluruh konten portofolio dari sini. Perubahan langsung tampil di website setelah halaman dimuat ulang.</p>
      </div>
      <a class="btn" href="{{ route('home') }}" target="_blank" rel="noopener"><x-ikon name="external" />Lihat Website</a>
    </div>

    <div class="stat-grid">
      @foreach ($statistik as $s)
        <a class="card stat-card" href="{{ route($s[2]) }}">
          <span class="stat-icon"><x-ikon :name="$s[3]" /></span>
          <span>
            <span class="stat-num">{{ $s[1] }}</span>
            <span class="stat-label">{{ $s[0] }}</span>
          </span>
        </a>
      @endforeach
    </div>

    <div class="dash-grid">
      <section class="card panel" aria-labelledby="pesan-terbaru">
        <h2 class="panel-title" id="pesan-terbaru">Pesan terbaru</h2>
        @forelse ($pesanTerbaru as $p)
          <a class="recent-item" href="{{ route('admin.pesan.show', $p->id) }}">
            <strong>{{ $p->nama }}</strong>
            <small>{{ $p->tanggal }}</small>
            <span>{{ $p->subjek !== '' ? $p->subjek : $p->pesan }}</span>
          </a>
        @empty
          <p class="kosong-card">Belum ada pesan masuk.</p>
        @endforelse
      </section>

      <section class="card panel" aria-labelledby="menu-cepat">
        <h2 class="panel-title" id="menu-cepat">Menu cepat</h2>
        <div class="shortcut-list">
          <a class="shortcut" href="{{ route('admin.profil.edit') }}"><x-ikon name="user" />Edit profil / About Me</a>
          <a class="shortcut" href="{{ route('admin.projects.create') }}"><x-ikon name="plus" />Tambah project</a>
          <a class="shortcut" href="{{ route('admin.experience.create') }}"><x-ikon name="plus" />Tambah pengalaman</a>
          <a class="shortcut" href="{{ route('admin.certificates.create') }}"><x-ikon name="plus" />Tambah sertifikat</a>
          <a class="shortcut" href="{{ route('admin.kontak.edit') }}"><x-ikon name="phone" />Ubah informasi kontak</a>
        </div>
      </section>
    </div>
@endsection
