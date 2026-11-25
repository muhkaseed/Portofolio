<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin | Portofolio</title>
  <link rel="icon" href="data:,">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
  <script>
    (function () {
      var tema = null;
      try { tema = localStorage.getItem('portfolio-theme'); } catch (e) {}
      if (tema !== 'light' && tema !== 'dark') {
        tema = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }
      document.documentElement.setAttribute('data-theme', tema);
    })();
  </script>
</head>
<body class="login-page">
  <main class="login-wrap">
    <form class="card form-card login-card" method="POST" action="{{ route('admin.login.proses') }}" novalidate>
      @csrf
      <p class="hero-tag">Admin Panel</p>
      <h1 class="login-title">Masuk</h1>

      @if ($errors->any())
        <p class="alert alert-error" role="alert">{{ $errors->first() }}</p>
      @endif

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" value="{{ old('username') }}" required autofocus>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>
      </div>

      <button type="submit" class="btn login-btn">Login</button>
      <p class="login-back"><a href="{{ route('home') }}">&larr; Kembali ke portofolio</a></p>
    </form>
  </main>
</body>
</html>
