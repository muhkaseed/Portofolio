<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $metaDeskripsi }}">
  <title>{{ $nama }} | Portofolio</title>
  <link rel="icon" href="data:,">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <script src="{{ asset('assets/js/script.js') }}" defer></script>
</head>
<body>
  <a class="skip-link" href="#main">Lewati ke konten utama</a>

  <!-- ===================== HEADER & NAVIGASI ===================== -->
  <header class="site-header">
    <nav class="navbar container" aria-label="Navigasi utama">
      <a class="brand" href="#home">
        <span class="brand-mark" aria-hidden="true">{{ $inisial }}</span>
        <span class="brand-text">{{ $namaAksen }}</span>
      </a>

      <ul class="nav-links" id="nav-menu">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About Me</a></li>
        <li><a href="#skills">Skills</a></li>
        <li><a href="#education">Education</a></li>
        <li><a href="#experience">Experience</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#certificates">Certificates</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>

      <div class="nav-actions">
        <button type="button" class="icon-btn" id="theme-toggle" aria-label="Aktifkan mode gelap" title="Aktifkan mode gelap">
          <svg class="icon icon-moon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
          <svg class="icon icon-sun" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/>
            <line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/>
            <line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
          </svg>
        </button>

        <button type="button" class="icon-btn menu-toggle" id="menu-toggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="nav-menu">
          <span class="bars" aria-hidden="true">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </span>
        </button>
      </div>
    </nav>
  </header>

  <main id="main" tabindex="-1">

    <!-- ===================== HOME ===================== -->
    <section class="hero" id="home" aria-labelledby="home-title">
      <div class="container hero-inner">
        <div class="hero-text">
          <p class="hero-tag">{{ $profil->tagline ?? '' }}</p>
          <h1 id="home-title">{{ $namaDepan !== '' ? $namaDepan . ' ' : '' }}<span class="accent-text">{{ $namaAksen }}</span></h1>
          <p class="hero-desc">{{ $profil->deskripsi ?? '' }}</p>
          <form class="greeting-form" method="GET" action="{{ route('home') }}">
            <label for="nama-pengunjung">Kenalan dulu yuk</label>
            <div class="greeting-controls">
              <input type="text" id="nama-pengunjung" name="nama" value="{{ $namaPengunjung }}" placeholder="Masukkan nama kamu">
              <button class="btn" type="submit">Sapa</button>
            </div>
            @if ($namaPengunjung !== '')
              <p class="greeting-result">{{ $sapaan }}</p>
            @endif
          </form>
        </div>

        <div class="hero-photo">
          <div class="photo-frame">
            <img src="{{ asset('assets/images/profil.jpeg') }}" alt="Foto profil {{ $nama }}">
          </div>
        </div>
      </div>
    </section>

    <!-- ===================== ABOUT ME ===================== -->
    <section class="section" id="about" aria-labelledby="about-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">01</span>
          <h2 class="section-title" id="about-title">About Me</h2>
        </div>

        <dl class="info-grid">
          <div class="info-card reveal">
            <dt>Nama</dt>
            <dd>{{ $nama }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>NRP</dt>
            <dd>{{ $profil->nim ?? '' }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Program Studi</dt>
            <dd>{{ $profil->prodi ?? '' }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Status</dt>
            <dd>{{ $statusTeks }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Asal</dt>
            <dd>{{ $profil->asal ?? '' }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Domisili</dt>
            <dd>{{ $profil->domisili ?? '' }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Minat</dt>
            <dd>{{ $profil->minat ?? '' }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Sedang Dipelajari</dt>
            <dd>{{ $profil->sedang_dipelajari ?? '' }}</dd>
          </div>
          <div class="info-card reveal">
            <dt>Tujuan Karier</dt>
            <dd>{{ $profil->tujuan_karier ?? '' }}</dd>
          </div>
        </dl>
      </div>
    </section>

    <!-- ===================== SKILLS ===================== -->
    <section class="section section-alt" id="skills" aria-labelledby="skills-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">02</span>
          <h2 class="section-title" id="skills-title">Skills</h2>
        </div>

        <ul class="skills-grid">
          @foreach ($skills as $index => $skill)
            <li class="reveal"><button type="button" class="skill-card" aria-pressed="false"><span class="skill-number" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span><span class="skill-name">{{ $skill->nama_skill }}</span><span class="skill-level">{{ $skill->tingkat }}</span></button></li>
          @endforeach
        </ul>
      </div>
    </section>

    <!-- ===================== EDUCATION ===================== -->
    <section class="section" id="education" aria-labelledby="education-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">03</span>
          <h2 class="section-title" id="education-title">Education</h2>
        </div>

        <div class="accordion" data-accordion>
          @foreach ($education as $index => $item)
            <div class="accordion-item reveal" {{ $index === 0 ? 'data-open' : '' }}>
              <h3 class="accordion-heading">
                <button type="button" class="accordion-trigger" id="edu-trigger-{{ $index + 1 }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="edu-panel-{{ $index + 1 }}">
                  <span class="trigger-text"><span class="trigger-title">{{ $item['nama'] }}</span><span class="trigger-meta">{{ $item['periode'] }}</span></span>
                  <span class="chevron" aria-hidden="true"></span>
                </button>
              </h3>
              <div class="accordion-panel" id="edu-panel-{{ $index + 1 }}" role="region" aria-labelledby="edu-trigger-{{ $index + 1 }}" {{ $index === 0 ? '' : 'hidden' }}>
                <dl class="detail-list">
                  <div><dt>Periode</dt><dd>{{ $item['periode'] }}</dd></div>
                  <div><dt>{{ $item['label'] }}</dt><dd>{{ $item['detail'] }}</dd></div>
                  @if ($item['keterangan'] !== '')
                    <div><dt>Keterangan</dt><dd>{{ $item['keterangan'] }}</dd></div>
                  @endif
                </dl>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- ===================== EXPERIENCE ===================== -->
    <section class="section section-alt" id="experience" aria-labelledby="experience-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">04</span>
          <h2 class="section-title" id="experience-title">Experience</h2>
        </div>

        <div class="accordion" data-accordion>
          @foreach ($experiences as $index => $item)
            <div class="accordion-item reveal" {{ $index === 0 ? 'data-open' : '' }}>
              <h3 class="accordion-heading">
                <button type="button" class="accordion-trigger" id="exp-trigger-{{ $index + 1 }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="exp-panel-{{ $index + 1 }}">
                  <span class="trigger-text"><span class="trigger-title">{{ $item['judul'] }}</span><span class="trigger-meta">{{ $item['periode'] }}</span></span>
                  <span class="chevron" aria-hidden="true"></span>
                </button>
              </h3>
              <div class="accordion-panel" id="exp-panel-{{ $index + 1 }}" role="region" aria-labelledby="exp-trigger-{{ $index + 1 }}" {{ $index === 0 ? '' : 'hidden' }}>
                @if ($item['deskripsi'] !== '')
                  <p class="panel-desc">{!! nl2br(e($item['deskripsi'])) !!}</p>
                @endif
                @if (count($item['tanggung_jawab']) > 0)
                <p class="panel-label">Tanggung jawab</p>
                <ul class="bullet-list">
                  @foreach ($item['tanggung_jawab'] as $tanggungJawab)
                    <li>{{ $tanggungJawab }}</li>
                  @endforeach
                </ul>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- ===================== PROJECTS ===================== -->
    <section class="section" id="projects" aria-labelledby="projects-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">05</span>
          <h2 class="section-title" id="projects-title">Projects</h2>
        </div>

        <form class="project-filters" method="GET" action="{{ route('home') }}#projects">
          <div class="filter-field">
            <label for="cari-project">Cari judul project</label>
            <input type="search" id="cari-project" name="cari" value="{{ $kataKunci }}" placeholder="Contoh: Kostra">
          </div>
          <div class="filter-field">
            <label for="kategori-project">Filter kategori</label>
            <select id="kategori-project" name="kategori">
              <option value="">Semua kategori</option>
              @foreach ($kategoriProject as $kategori)
                <option value="{{ $kategori }}" {{ $kategoriDipilih === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
              @endforeach
            </select>
          </div>
          <button class="btn" type="submit">Cari Project</button>
          <a class="filter-reset" href="{{ route('home') }}#projects">Reset</a>
        </form>

        <p class="project-count">Menampilkan {{ count($projectTampil) }} dari {{ count($projects) }} project.</p>
        @if (count($projectTampil) > 0)
          <ul class="projects-grid">
            @foreach ($projectTampil as $project)
              <li class="reveal">
                <article class="project-card">
                  <p class="project-category">{{ $project['kategori'] }}</p>
                  <h3 class="project-title">{{ $project['judul'] }}</h3>
                  <p class="project-desc">{{ $project['deskripsi'] }}</p>
                  <p class="project-year">Tahun: {{ $project['tahun'] ?: 'belum dicantumkan' }}</p>
                  @if ($project['teknologi'] !== '')
                    <p class="project-year">Teknologi: {{ $project['teknologi'] }}</p>
                  @endif
                  <p class="project-footer"><span class="status {{ $project['status_class'] }}">{{ $project['status'] }}</span>@if ($project['link'] !== '') <a class="project-link" href="{{ $project['link'] }}" target="_blank" rel="noopener noreferrer">Lihat project</a>@endif</p>
                </article>
              </li>
            @endforeach
          </ul>
        @else
          <p class="no-projects">Project tidak ditemukan. Coba ubah kata kunci atau kategori pencarian.</p>
        @endif
      </div>
    </section>

    <!-- ===================== CERTIFICATES ===================== -->
    <section class="section section-alt" id="certificates" aria-labelledby="certificates-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">06</span>
          <h2 class="section-title" id="certificates-title">Certificates</h2>
        </div>

        <ul class="cert-grid">
          @foreach ($certificates as $cert)
          <li class="card cert-card reveal">
            <span class="cert-icon" aria-hidden="true">
              @if ($cert['ikon'] === 'book')
              <svg class="icon" viewBox="0 0 24 24" focusable="false">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
              </svg>
              @else
              <svg class="icon" viewBox="0 0 24 24" focusable="false">
                <circle cx="12" cy="8" r="6"/>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
              </svg>
              @endif
            </span>
            <h3 class="cert-title">{{ $cert['nama'] }}</h3>
            @if ($cert['penyelenggara'] !== '')
              <p class="cert-detail">{{ $cert['penyelenggara'] }}</p>
            @endif
            @if ($cert['deskripsi'] !== '')
              <p class="cert-detail">{{ $cert['deskripsi'] }}</p>
            @endif
            @if ($cert['tahun'] !== '')
              <p class="cert-year">{{ $cert['tahun'] }}</p>
            @endif
            @if ($cert['link'] !== '')
              <p class="cert-detail"><a class="cert-link" href="{{ $cert['link'] }}" target="_blank" rel="noopener noreferrer">Lihat sertifikat</a></p>
            @endif
          </li>
          @endforeach
        </ul>
      </div>
    </section>

    <!-- ===================== CONTACT ===================== -->
    <section class="section" id="contact" aria-labelledby="contact-title">
      <div class="container">
        <div class="section-head reveal">
          <span class="section-index">07</span>
          <h2 class="section-title" id="contact-title">Contact</h2>
        </div>

        <div class="contact-grid">
          <form class="card form-card reveal" id="contact-form" method="POST" action="{{ route('home') }}#contact" novalidate>
            @csrf
            <h3 class="card-title">Kirim Pesan</h3>

            <div class="form-group">
              <label for="contact-name">Nama</label>
              <input type="text" id="contact-name" name="nama" data-label="Nama" autocomplete="name" placeholder="Nama lengkap" value="{{ $formData['nama'] }}" aria-invalid="{{ isset($formErrors['nama']) ? 'true' : 'false' }}" aria-describedby="contact-name-error">
              <p class="field-error" id="contact-name-error">{{ $formErrors['nama'] ?? '' }}</p>
            </div>

            <div class="form-group">
              <label for="contact-email">Email</label>
              <input type="email" id="contact-email" name="email" data-label="Email" autocomplete="email" placeholder="nama@email.com" value="{{ $formData['email'] }}" aria-invalid="{{ isset($formErrors['email']) ? 'true' : 'false' }}" aria-describedby="contact-email-error">
              <p class="field-error" id="contact-email-error">{{ $formErrors['email'] ?? '' }}</p>
            </div>

            <div class="form-group">
              <label for="contact-subject">Subjek</label>
              <input type="text" id="contact-subject" name="subjek" data-label="Subjek" placeholder="Judul pesan" value="{{ $formData['subjek'] }}" aria-invalid="{{ isset($formErrors['subjek']) ? 'true' : 'false' }}" aria-describedby="contact-subject-error">
              <p class="field-error" id="contact-subject-error">{{ $formErrors['subjek'] ?? '' }}</p>
            </div>

            <div class="form-group">
              <label for="contact-message">Pesan</label>
              <textarea id="contact-message" name="pesan" data-label="Pesan" rows="5" placeholder="Tulis pesan Anda di sini" aria-invalid="{{ isset($formErrors['pesan']) ? 'true' : 'false' }}" aria-describedby="contact-message-error">{{ $formData['pesan'] }}</textarea>
              <p class="field-error" id="contact-message-error">{{ $formErrors['pesan'] ?? '' }}</p>
            </div>

            <button type="submit" name="kirim" value="1" class="btn">Kirim Pesan</button>
            <div class="form-status{{ $pesanGagal ? ' is-error' : '' }}" id="form-status" role="status" aria-live="polite">{{ $pesanSapaan }}</div>
          </form>

          <div class="card info-card-contact reveal">
            <h3 class="card-title">Informasi Kontak</h3>
            <ul class="contact-list">
              @if ($instagram)
              <li>
                <a class="contact-link" href="{{ $instagram['href'] }}" target="_blank" rel="noopener noreferrer">
                  <span class="contact-icon" aria-hidden="true">
                    <svg class="icon" viewBox="0 0 24 24" focusable="false">
                      <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                      <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                      <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                    </svg>
                  </span>
                  <span class="contact-text">
                    <span class="contact-label">Instagram</span>
                    <span class="contact-value">{{ $instagram['teks'] }}</span>
                  </span>
                </a>
              </li>
              @endif
              @if ($whatsapp)
              <li>
                <a class="contact-link" href="{{ $whatsapp['href'] }}" target="_blank" rel="noopener noreferrer">
                  <span class="contact-icon" aria-hidden="true">
                    <svg class="icon" viewBox="0 0 24 24" focusable="false">
                      <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                  </span>
                  <span class="contact-text">
                    <span class="contact-label">WhatsApp</span>
                    <span class="contact-value">{{ $whatsapp['teks'] }}</span>
                  </span>
                </a>
              </li>
              @endif
              @if ($email)
              <li>
                <a class="contact-link" href="{{ $email['href'] }}">
                  <span class="contact-icon" aria-hidden="true">
                    <svg class="icon" viewBox="0 0 24 24" focusable="false">
                      <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                      <polyline points="22,6 12,13 2,6"/>
                    </svg>
                  </span>
                  <span class="contact-text">
                    <span class="contact-label">Email</span>
                    <span class="contact-value">{{ $email['teks'] }}</span>
                  </span>
                </a>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- ===================== FOOTER ===================== -->
  <footer class="site-footer">
    <div class="container footer-inner">
      <p>&copy; {{ date('Y') }} {{ $nama }}<a class="admin-link" href="{{ route('admin.login') }}" aria-label="Login admin" title="Admin"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></a></p>
      <a href="#home">Kembali ke atas</a>
    </div>
  </footer>
</body>
</html>