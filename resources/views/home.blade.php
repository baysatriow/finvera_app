@extends('layouts.app')

@section('content')
  {{-- HERO --}}
  <section class="hero-bg py-5 py-lg-5">
    <div class="container">
      <div class="row align-items-center gy-4">
        <div class="col-lg-6">
          <h1 class="hero-headline display-6 mb-3">
            KEUANGAN MUDAH,<br />
            <span class="accent">BERKAH TANPA BATAS</span>
          </h1>

          <div class="hero-sub">
            Pinjaman syariah tanpa bunga, proses cepat, transparan 100%
          </div>

          <div class="mt-4 d-flex flex-wrap gap-2">
            <a href="{{ route('register.step1') }}" class="fin-btn-pill-solid text-decoration-none">
              Ajukan Sekarang
            </a>
            <a href="{{ route('login') }}" class="fin-btn-pill-outline text-decoration-none">
              Masuk
            </a>
          </div>
        </div>

        <div class="col-lg-6 d-flex justify-content-lg-end justify-content-center">
          <div class="hero-visual-box w-100" style="max-width:320px;">
            <div class="hero-float-card">
              <div class="hero-float-label">Limit hingga</div>
              <div class="hero-float-value">Rp 20.000.000</div>
              <div class="hero-float-sub">tanpa riba</div>
            </div>
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
            <div class="feature-title">Bebas bunga</div>
            <div class="feature-text">sistem syariah tanpa riba</div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="bi bi-phone"></i>
            </div>
            <div class="feature-title">Proses Digital</div>
            <div class="feature-text">Pengajuan online yang mudah</div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="bi bi-shield-check"></i>
            </div>
            <div class="feature-title">Transparan penuh</div>
            <div class="feature-text">Tidak ada biaya tersembunyi</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- PROSES MUDAH --}}
  <section class="section-block pt-4 pb-5" style="
    background: radial-gradient(circle at 50% 0%, #ffffff 0%, #f9f7f4 50%, #f5ecdc 100%);
    border-top: 1px solid rgba(0,0,0,0.03);
    border-bottom: 1px solid rgba(0,0,0,0.03);
  ">
    <div class="container">
      <div class="mb-4 text-center">
        <div class="section-title mb-2">PROSES MUDAH</div>
        <div class="section-desc">
          Hanya 3 langkah untuk mendapatkan pembiayaan
        </div>
      </div>

      <div class="row text-center g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
          <div class="process-step-circle">1</div>
          <div class="process-step-title">AJUKAN ONLINE</div>
          <div class="process-step-desc">
            Isi formulir pengajuan secara digital
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="process-step-circle">2</div>
          <div class="process-step-title">VERIFIKASI</div>
          <div class="process-step-desc">
            Tim kami akan memverifikasi data Anda
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="process-step-circle">3</div>
          <div class="process-step-title">DANA CAIR</div>
          <div class="process-step-desc">
            Dana langsung cair ke rekening Anda
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
