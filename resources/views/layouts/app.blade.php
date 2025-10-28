<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finvera</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font (sesuai nuansa desain kamu) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
      body {
        font-family: 'Inter', sans-serif;
        background-color: #F9F7F4;
      }

      /* Navbar */
      .navbar {
        background-color: #fff;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
      }
      .navbar-brand {
        font-weight: 700;
        color: #2F4F4F !important;
      }
      .nav-link {
        color: #3B3B3B !important;
        font-weight: 500;
      }
      .nav-link:hover {
        color: #1F8A70 !important;
      }

      /* Buttons */
      .btn-green {
        background-color: #607E58;
        color: white;
        border-radius: 25px;
        padding: 6px 20px;
        transition: 0.3s;
      }
      .btn-green:hover {
        background-color: #4E6849;
        color: white;
      }
      .btn-outline-green {
        border: 1px solid #607E58;
        color: #607E58;
        border-radius: 25px;
        padding: 6px 20px;
      }
      .btn-outline-green:hover {
        background-color: #607E58;
        color: white;
      }

      footer {
        background-color: #111;
        color: #ccc;
        padding: 30px 0;
        font-size: 0.9rem;
      }
      footer a {
        color: #ccc;
        text-decoration: none;
      }
      footer a:hover {
        color: #fff;
      }
    </style>

    @stack('styles')
  </head>

  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
      <div class="container py-2">
        <a class="navbar-brand fs-4" href="/">Finvera</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav me-4">
            <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Produk</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
          </ul>
          <div class="d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-outline-green">Masuk</a>
            <a href="{{ route('register.step1') }}" class="btn btn-green">Daftar</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="min-vh-100 py-5">
      <div class="container">
        @yield('content')
      </div>
    </main>

    <!-- Footer -->
    <footer>
      <div class="container text-center">
        <h5 class="fw-bold text-white">Finvera</h5>
        <p class="mb-2">finvera@gmail.com</p>
        <p class="text-muted small">
          Subscribe to our newsletter to unlock benefits and stay updated on new services and promotions.
        </p>

        <div class="d-flex justify-content-center gap-3 mb-3">
          <a href="#">Facebook</a>
          <a href="#">Instagram</a>
          <a href="#">LinkedIn</a>
          <a href="#">Twitter</a>
        </div>

        <div class="text-muted small">
          <a href="#">Terms</a> · <a href="#">Privacy</a> · <a href="#">Cookies</a>
        </div>

        <p class="mt-3 text-secondary small mb-0">© 2025 Finvera. All Rights Reserved.</p>
      </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
  </body>
</html>
