<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Finvera</title>

    <!-- Bootstrap 5 CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />

    <!-- Inter Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <style>
      :root {
        --finvera-bg-base: #f9f7f4;
        --finvera-bg-grad-start: #ffffff;
        --finvera-bg-grad-mid: #f9f7f4;
        --finvera-bg-grad-end: #f4eee4;
        --finvera-green-dark: #2f4f4f;
        --finvera-green-mid: #607e58;
        --finvera-green-mid-hover: #4e6849;
        --finvera-green-soft-bg: #eef1ec;
        --finvera-text-muted: #6b6b6b;
        --finvera-border-soft: rgba(0, 0, 0, 0.07);
        --finvera-shadow-card: 0 24px 40px rgba(0, 0, 0, 0.07);
        --finvera-shadow-button: 0 6px 12px rgba(0, 0, 0, 0.18);
      }

      body {
        font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background-color: var(--finvera-bg-base);
        color: #1a1a1a;
      }

      /* NAVBAR */
      .fin-navbar {
        background-color: #ffffff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.07);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
      }
      .fin-brand {
        font-weight: 700;
        color: var(--finvera-green-dark) !important;
        font-size: 1.15rem;
        letter-spacing: -0.03em;
      }
      .fin-nav-link {
        color: #444 !important;
        font-weight: 500;
        font-size: 0.95rem;
      }
      .fin-nav-link:hover {
        color: var(--finvera-green-mid) !important;
      }

      /* pill buttons in navbar */
      .fin-btn-pill-outline {
        background-color: #fff;
        border: 1px solid rgba(0,0,0,0.12);
        color: var(--finvera-green-mid);
        font-weight: 500;
        border-radius: 999px;
        padding: 6px 16px;
        line-height: 1.2;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(0,0,0,.08);
      }
      .fin-btn-pill-outline:hover {
        background-color: var(--finvera-green-soft-bg);
        border-color: rgba(0,0,0,0.18);
        color: var(--finvera-green-dark);
      }

      .fin-btn-pill-solid {
        background-color: var(--finvera-green-mid);
        border: 1px solid var(--finvera-green-mid);
        color: #fff;
        font-weight: 500;
        border-radius: 999px;
        padding: 6px 16px;
        line-height: 1.2;
        font-size: 0.9rem;
        box-shadow: var(--finvera-shadow-button);
      }
      .fin-btn-pill-solid:hover {
        background-color: var(--finvera-green-mid-hover);
        border-color: var(--finvera-green-mid-hover);
        color: #fff;
      }

      /* AUTH CARD (login / register steps) */
      .fin-auth-wrapper {
        background: radial-gradient(
          circle at 20% 20%,
          var(--finvera-bg-grad-start) 0%,
          var(--finvera-bg-grad-mid) 45%,
          var(--finvera-bg-grad-end) 100%
        );
        min-height: calc(100vh - 64px - 280px); /* header - footer approx */
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding-top: 3rem;
        padding-bottom: 3rem;
      }

      .fin-auth-card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: var(--finvera-shadow-card);
        border: 1px solid var(--finvera-border-soft);
        max-width: 480px;
        width: 100%;
        padding: 2rem 2rem 2rem;
      }

      .fin-auth-title {
        font-weight: 600;
        font-size: 1.25rem;
        color: #000;
        text-align: center;
        margin-bottom: 0.25rem;
      }

      .fin-auth-subtitle {
        font-size: 0.9rem;
        color: var(--finvera-text-muted);
        text-align: center;
        margin-bottom: 1.5rem;
      }

      .fin-label {
        font-size: 0.9rem;
        color: #000;
        font-weight: 500;
        margin-bottom: 0.25rem;
      }

      .fin-form-control {
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,.18);
        font-size: 0.95rem;
        padding: 0.6rem 0.75rem;
      }

      .fin-form-control:focus {
        border-color: var(--finvera-green-mid);
        box-shadow: 0 0 0 0.2rem rgba(96, 126, 88, 0.15);
      }

      .fin-submit-btn {
        background-color: var(--finvera-green-mid);
        border-color: var(--finvera-green-mid);
        color: #fff;
        width: 100%;
        font-weight: 500;
        border-radius: 8px;
        padding: 0.7rem 1rem;
        font-size: 1rem;
        box-shadow: var(--finvera-shadow-button);
      }
      .fin-submit-btn:hover {
        background-color: var(--finvera-green-mid-hover);
        border-color: var(--finvera-green-mid-hover);
      }

      .fin-terms-text {
        font-size: 0.8rem;
        color: #4a4a4a;
        text-align: center;
        line-height: 1.4;
      }
      .fin-terms-text a {
        color: var(--finvera-green-mid);
        text-decoration: none;
      }
      .fin-terms-text a:hover {
        text-decoration: underline;
      }

      .fin-progress-wrap {
        margin-bottom: 1rem;
      }
      .fin-progress-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #4a4a4a;
        margin-bottom: 0.4rem;
      }
      .fin-progress-bar-bg {
        background-color: #d0d0d0;
        border-radius: 999px;
        width: 100%;
        height: 6px;
        overflow: hidden;
      }
      .fin-progress-bar-inner {
        background-color: var(--finvera-green-mid);
        height: 100%;
        width: 50%;
      }
      .fin-progress-bar-inner.step2 {
        width: 100%;
      }

      /* FOOTER */
      footer.fin-footer {
        background-color: #111;
        color: #ccc;
        padding-top: 2.5rem;
        padding-bottom: 2.5rem;
        font-size: 0.9rem;
        margin-top: 3rem;
      }

      .fin-footer-heading {
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: .5rem;
      }

      .fin-footer-email {
        color: #fff;
        font-size: 0.9rem;
        margin-bottom: .5rem;
      }

      .fin-footer-desc {
        font-size: 0.8rem;
        max-width: 500px;
        color: #aaa;
      }

      .fin-footer-links a {
        color: #ccc;
        text-decoration: none;
        font-size: 0.8rem;
        margin-right: 1rem;
      }
      .fin-footer-links a:hover {
        color: #fff;
      }

      .fin-footer-bottom-links a {
        color: #999;
        font-size: 0.8rem;
        text-decoration: none;
        margin-right: 1rem;
      }
      .fin-footer-bottom-links a:hover {
        color: #fff;
      }

      .fin-footer-copy {
        color: #777;
        font-size: 0.8rem;
      }

      /* utility spacing for hero / sections */
      .section-block {
        padding-top: 4rem;
        padding-bottom: 4rem;
      }
      .section-title {
        text-transform: uppercase;
        color: var(--finvera-green-dark);
        font-weight: 700;
        letter-spacing: 0.08em;
        font-size: 1.1rem;
        text-align: center;
      }
      .section-desc {
        color: var(--finvera-text-muted);
        font-size: 0.95rem;
        max-width: 580px;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
      }

      /* cards on landing feature section */
      .feature-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 24px 40px rgba(0,0,0,0.07);
        border: 1px solid var(--finvera-border-soft);
        min-height: 160px;
        padding: 1.5rem;
        text-align: center;
      }
      .feature-icon {
        font-size: 1.8rem;
        color: var(--finvera-green-mid);
        margin-bottom: .75rem;
      }
      .feature-title {
        color: var(--finvera-green-dark);
        font-weight: 600;
        font-size: 1rem;
      }
      .feature-text {
        font-size: .9rem;
        color: #444;
      }

      /* process step */
      .process-step-circle {
        width: 64px;
        height: 64px;
        background-color: var(--finvera-green-mid);
        color: #fff;
        font-weight: 600;
        font-size: 1.25rem;
        line-height: 64px;
        border-radius: 50%;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 1rem;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
      }
      .process-step-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--finvera-green-dark);
        text-transform: uppercase;
        letter-spacing: 0.06em;
      }
      .process-step-desc {
        color: var(--finvera-text-muted);
        font-size: 0.9rem;
      }

      /* hero style */
      .hero-bg {
        background: radial-gradient(
          circle at 20% 20%,
          var(--finvera-bg-grad-start) 0%,
          var(--finvera-bg-grad-mid) 45%,
          var(--finvera-bg-grad-end) 100%
        );
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      }

      .hero-headline {
        font-weight: 700;
        color: var(--finvera-green-dark);
        line-height: 1.2;
        text-transform: uppercase;
        letter-spacing: 0.03em;
      }
      .hero-headline .accent {
        color: var(--finvera-green-mid);
      }
      .hero-sub {
        font-size: 0.95rem;
        color: #666;
        display: inline-block;
        border-top: 1px solid rgba(0,0,0,0.2);
        padding-top: .5rem;
        margin-top: .75rem;
      }

      .hero-visual-box {
        background: linear-gradient(135deg, #fff 0%, #ffda79 40%, #ffb347 100%);
        border-radius: 12px;
        min-height: 230px;
        border: 3px solid var(--finvera-green-mid);
        box-shadow: 0 24px 36px rgba(0,0,0,0.1);
        position: relative;
      }
      .hero-float-card {
        position: absolute;
        right: -16px;
        bottom: -16px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 16px 30px rgba(0,0,0,.12);
        border: 1px solid rgba(0,0,0,.07);
        padding: 1rem 1.25rem;
        min-width: 150px;
      }
      .hero-float-label {
        font-size: .8rem;
        color: #444;
        margin-bottom: .25rem;
      }
      .hero-float-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--finvera-green-dark);
        line-height: 1.2;
      }
      .hero-float-sub {
        font-size: .8rem;
        color: #6b6b6b;
      }
    </style>

    @stack('styles')
  </head>

  <body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg fin-navbar sticky-top py-2">
      <div class="container">
        <a class="navbar-brand fin-brand" href="{{ route('home') }}">
          Finvera
        </a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#mainNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
          <ul class="navbar-nav me-3">
            <li class="nav-item">
              <a class="nav-link fin-nav-link" href="{{ route('home') }}">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fin-nav-link" href="#">Produk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fin-nav-link" href="#">Tentang Kami</a>
            </li>
          </ul>

          <div class="d-flex gap-2">
            <a href="{{ route('login') }}" class="fin-btn-pill-outline text-decoration-none">
              Masuk
            </a>
            <a href="{{ route('register.step1') }}" class="fin-btn-pill-solid text-decoration-none">
              Daftar
            </a>
          </div>
        </div>
      </div>
    </nav>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <footer class="fin-footer mt-auto">
      <div class="container">
        <div class="row gy-4 justify-content-between">
          <div class="col-md-6 col-lg-5">
            <div class="fin-footer-heading">Finvera</div>
            <div class="fin-footer-email">finvera@gmail.com <i class="bi bi-arrow-up-right ms-1"></i></div>
            <p class="fin-footer-desc mb-3">
              Subscribe to our newsletter and unlock a world of exclusive benefits.
              Be the first to know about our latest products, special promotions,
              and exciting updates. Join our community of like-minded individuals
              who share a passion for integrity.
            </p>

            <div class="fin-footer-links mb-3">
              <a href="#">Facebook</a>
              <a href="#">Instagram</a>
              <a href="#">LinkedIn</a>
              <a href="#">Twitter</a>
            </div>

            <div class="fin-footer-bottom-links mb-2">
              <a href="#">Terms</a>
              <a href="#">Privacy</a>
              <a href="#">Cookies</a>
            </div>
          </div>

          <div class="col-md-5 col-lg-3 text-md-end">
            <div class="fin-footer-copy">&copy; 2025 Finvera. All Rights Reserved.</div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

    @stack('scripts')
  </body>
</html>
