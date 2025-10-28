@extends('layouts.app')

@section('content')

  {{-- HERO SECTION --}}
  <section class="hero-bg py-5 py-lg-5">
    <div class="container">
      <div class="row align-items-center gy-5">

        {{-- Kiri: headline + badge + CTA --}}
        <div class="col-lg-6">

          <div class="hero-badge">
            <i class="bi bi-shield-check"></i>
            <span>Pinjaman Syariah • 100% Transparan</span>
          </div>

          <h1 class="hero-headline mb-3">
            KEUANGAN MUDAH,<br />
            <span class="accent">BERKAH TANPA BATAS</span>
          </h1>

          <p class="hero-sub">
            Pinjaman syariah tanpa bunga, proses cepat, transparan 100%
          </p>

          <div class="hero-cta-row">
            <a
              href="{{ route('register.step1') }}"
              class="fin-btn-pill-solid text-center"
            >
              Ajukan Sekarang
            </a>

            <a
              href="{{ route('login') }}"
              class="fin-btn-pill-outline text-center"
            >
              Masuk
            </a>
          </div>
        </div>

        {{-- Kanan: ilustrasi / hero image --}}
        <div class="col-lg-6 hero-illustration-wrapper">
          <div class="hero-illustration-img-holder">
            <img
              src="{{ asset('assets/images/hero.png') }}"
              alt="Ilustrasi Finvera"
              class="hero-illustration-img"
            />
          </div>

          {{-- Floating glass card with limit info --}}
          <div class="hero-float-card">
            <div class="hero-float-label">Limit hingga</div>
            <div class="hero-float-value">Rp 20.000.000</div>
            <div class="hero-float-sub">tanpa riba</div>
          </div>
        </div>

      </div>
    </div>
  </section>


  {{-- KEUNGGULAN KAMI --}}
  <section class="section-block">
    <div class="container">

      <div class="mb-4 text-center">
        <div class="section-title mb-2">KEUNGGULAN KAMI</div>
        <div class="section-desc">
          Kami berkomitmen memberikan layanan pembiayaan yang aman, transparan,
          dan sesuai prinsip syariah.
        </div>
      </div>

      <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="bi bi-slash-circle"></i>
            </div>
            <div class="feature-title mb-1">Bebas bunga</div>
            <div class="feature-text">Sistem syariah tanpa riba</div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="bi bi-phone"></i>
            </div>
            <div class="feature-title mb-1">Proses Digital</div>
            <div class="feature-text">Pengajuan online yang mudah</div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="bi bi-eye"></i>
            </div>
            <div class="feature-title mb-1">Transparan penuh</div>
            <div class="feature-text">Tidak ada biaya tersembunyi</div>
          </div>
        </div>
      </div>

    </div>
  </section>


  {{-- PROSES MUDAH --}}
  <section class="section-block process-wrapper pt-4 pb-5">
    <div class="container">

      <div class="mb-4 text-center">
        <div class="section-title mb-2">PROSES MUDAH</div>
        <div class="section-desc">
          Hanya 3 langkah untuk mendapatkan pembiayaan
        </div>
      </div>

      <div class="row gy-4 justify-content-center process-flow">

        <div class="col-md-4 col-sm-6 process-step">
          <div class="process-step-circle">1</div>
          <div class="process-step-title mb-2">AJUKAN ONLINE</div>
          <div class="process-step-desc">
            Isi formulir pengajuan secara digital
          </div>
        </div>

        <div class="col-md-4 col-sm-6 process-step">
          <div class="process-step-circle">2</div>
          <div class="process-step-title mb-2">VERIFIKASI</div>
          <div class="process-step-desc">
            Tim kami akan memverifikasi data Anda
          </div>
        </div>

        <div class="col-md-4 col-sm-6 process-step">
          <div class="process-step-circle">3</div>
          <div class="process-step-title mb-2">DANA CAIR</div>
          <div class="process-step-desc">
            Dana langsung cair ke rekening Anda
          </div>
        </div>

      </div>

    </div>
  </section>

@endsection
