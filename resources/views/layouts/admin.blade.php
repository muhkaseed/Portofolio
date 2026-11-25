@php
    // Menu sidebar: [kode menu, nama rute, label, ikon]
    $menuAdmin = [
        ['Utama', [
            ['dashboard', 'admin.dashboard', 'Dashboard', 'home'],
        ]],
        ['Kelola Konten', [
            ['profil', 'admin.profil.edit', 'Profil / About Me', 'user'],
            ['skill', 'admin.skill.index', 'Skills', 'code'],
            ['education', 'admin.education.index', 'Education', 'school'],
            ['experience', 'admin.experience.index', 'Experience', 'briefcase'],
            ['projects', 'admin.projects.index', 'Projects', 'folder'],
            ['certificates', 'admin.certificates.index', 'Certificates', 'award'],
            ['kontak', 'admin.kontak.edit', 'Informasi Kontak', 'phone'],
        ]],
        ['Pesan', [
            ['pesan', 'admin.pesan.index', 'Pesan Kontak', 'mail'],
        ]],
    ];
    $menuAktif = trim($__env->yieldContent('menu'));
    $jumlahPesanMasuk = \Illuminate\Support\Facades\DB::table('pesan_kontak')->count();
    $namaAdmin = session('username', '');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') | Admin Portofolio</title>
  <link rel="icon" href="data:,">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
  <script>
    // Samakan tema dengan halaman publik (disimpan di localStorage).
    (function () {
      var tema = null;
      try { tema = localStorage.getItem('portfolio-theme'); } catch (e) {}
      if (tema !== 'light' && tema !== 'dark') {
        tema = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }
      document.documentElement.setAttribute('data-theme', tema);
    })();
  </script>
  <script src="{{ asset('assets/js/admin.js') }}" defer></script>
</head>
<body class="admin-body">
  <div class="admin-shell" id="admin-shell">

    <aside class="sidebar" id="sidebar" aria-label="Menu admin">
      <div class="sidebar-brand">
        <a class="brand" href="{{ route('admin.dashboard') }}">
          <span class="brand-mark" aria-hidden="true">MK</span>
          <span class="brand-text">Admin Panel</span>
        </a>
        <button type="button" class="topbar-btn sidebar-close" id="sidebar-close" aria-label="Tutup menu"><x-ikon name="close" /></button>
      </div>

      <nav class="sidebar-nav">
        @foreach ($menuAdmin as $grup)
          <p class="nav-group">{{ $grup[0] }}</p>
          <ul>
            @foreach ($grup[1] as $m)
              <li>
                <a href="{{ route($m[1]) }}" class="nav-item{{ $menuAktif === $m[0] ? ' active' : '' }}"{!! $menuAktif === $m[0] ? ' aria-current="page"' : '' !!}>
                  <x-ikon :name="$m[3]" />
                  <span>{{ $m[2] }}</span>
                  @if ($m[0] === 'pesan' && $jumlahPesanMasuk > 0)
                    <span class="nav-badge">{{ $jumlahPesanMasuk }}</span>
                  @endif
                </a>
              </li>
            @endforeach
          </ul>
        @endforeach
      </nav>

      <div class="sidebar-foot">
        <a class="nav-item" href="{{ route('home') }}" target="_blank" rel="noopener"><x-ikon name="external" /><span>Lihat Website</span></a>
        <form method="POST" action="{{ route('admin.logout') }}" class="form-inline">
          @csrf
          <button type="submit" class="nav-item nav-logout"><x-ikon name="logout" /><span>Logout</span></button>
        </form>
      </div>
    </aside>
    <div class="sidebar-backdrop" id="sidebar-backdrop" hidden></div>

    <div class="admin-content">
      <header class="topbar">
        <button type="button" class="topbar-btn menu-open" id="sidebar-open" aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false"><x-ikon name="menu" /></button>
        <p class="topbar-title">@yield('title', 'Admin')</p>
        <div class="topbar-actions">
          <button type="button" class="topbar-btn" id="admin-theme" aria-label="Ganti tema terang/gelap" title="Ganti tema">
            <span class="theme-moon"><x-ikon name="moon" /></span>
            <span class="theme-sun"><x-ikon name="sun" /></span>
          </button>
          <span class="topbar-user" title="Login sebagai {{ $namaAdmin }}">
            <span class="avatar" aria-hidden="true">{{ strtoupper(substr($namaAdmin !== '' ? $namaAdmin : 'A', 0, 1)) }}</span>
            <span class="topbar-user-name">{{ $namaAdmin }}</span>
          </span>
        </div>
      </header>

      <main class="admin-main" id="admin-main">
        @if (session('flash'))
          <p class="alert alert-{{ session('flash_tipe') === 'error' ? 'error' : 'ok' }}" role="status">{{ session('flash') }}</p>
        @endif

        @yield('content')
      </main>
      <footer class="admin-foot">Admin Panel Portofolio &middot; Perubahan langsung tampil di website setelah halaman dimuat ulang.</footer>
    </div>
  </div>
</body>
</html>
