@extends('layouts.app')

@push('styles')
<style>
  /* Warna utama hijau Finvera */
  :root {
    --finvera-green-dark: #2f4f4f;
    --finvera-green-mid: #607E58;
    --finvera-green-light: #6e8d5f;
    --finvera-bg-soft: #F9F7F4;
  }

  /* HERO background gradient */
  .hero-section {
    background: radial-gradient(circle at 20% 20%, #ffffff 0%, #f9f7f4 40%, #f4eee4 100%);
    border-bottom: 1px solid rgba(0,0,0,0.05);
  }

  .hero-headline {
    font-weight: 700;
    color: var(--finvera-green-dark);
    line-height: 1.2;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }
  .hero-headline .accent {
    color: var(--finvera-green-light);
  }

  .hero-subtext {
    color: #666;
    font-size: 0.95rem;
    border-top: 1px solid rgba(0,0,0,0.15);
    display: inline-block;
    padding-top: .5rem;
    margin-top: .75rem;
  }

  /* Card Keunggulan */
  .keunggulan-card {
    background: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 16px 30px rgba(0,0,0,0.06);
    min-height: 150px;
  }

  .keunggulan-icon {
    font-size: 1.8rem;
    color: var(--finvera-green-mid);
    margin-bottom: .75rem;
  }

  .keunggulan-title {
    font-weight: 600;
    color: var(--finvera-green-dark);
    font-size: 1rem;
  }

  .keunggulan-desc {
    color: #444;
    font-size: 0.9rem;
  }

  /* Section heading */
  .section-heading {
    text-align: center;
    text-transform: uppercase;
    color: var(--finvera-green-dark);
    font-weight: 700;
    letter-spacing: 0.08em;
  }

  .section-desc {
    color: #6b6b6b;
    font-size: 0.95rem;
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
  }

  /* PROSES MUDAH */
  .process-wrapper {
    background: radial-gradient(circle at 50% 0%, #ffffff 0%, #f9f7f4 50%, #f5ecdc 100%);
    border-top: 1px solid rgba(0,0,0,0.03);
    border-bottom: 1px solid rgba(0,0,0,0.03);
  }

  .step-circle {
    width: 64px;
    height: 64px;
    background-color: var(--finvera-green-mid);
    color: #fff;
    font-weight: 600;
    font-size: 1.25rem;
    line-height: 64px;
    border-radius: 50%;
    margin: 0 auto 1rem auto;
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
  }

  .step-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--finvera-green-dark);
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .step-desc {
    color: #6b6b6b;
    font-size: .9rem;
  }

  /* helper spacing tweaks for large screens */
  @media(min-width: 992px){
    .hero-col-left{
      padding-right: 3rem;
    }
  }

  /* Placeholder ilustrasi kanan hero */
  .hero-illustration-box{
    background: linear-gradient(135deg,#fff 0%,#ffda79 40%,#ffb347 100%);
    border-radius: 12px;
    min-height: 220px;
    border: 3px solid var(--finvera-green-mid);
    box-shadow: 0 24px 36px rgba(0,0,0,0.1);
    position: relative;
  }
  .hero-illustration-card{
    position:absolute;
    right:-16px;
    bottom:-16px;
    background:#fff;
    border-radius:8px;
    box-shadow:0 16px 30px rgba(0,0,0,.12);
    border:1px solid rgba(0,0,0,0.05);
    padding:1rem 1.25rem;
    min-width:140px;
  }
  .hero-illustration-card .label{
    font-size: .8rem;
    color:#444;
  }
  .hero-illustration-card .value{
    font-size:1.1rem;
    font-weight:600;
    color: var(--finvera-green-dark);
  }
</style>

<!-- Bootstrap Icons (untuk ikon seperti "no-interest", "phone", "shield", dll)  -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
/>
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-section py-5 py-lg-5">
      <div class="row align-items-center">
        {{-- Kiri: Headline --}}
        <div class="col-lg-6 hero-col-left mb-5 mb-lg-0">

          <h1 class="hero-headline display-5">
            KEUANGAN MUDAH, <br/>
            <span class="accent">BERKAH TANPA BATAS</span>
          </h1>

          <div class="hero-subtext">
            Pinjaman syariah tanpa bunga, proses cepat, transparan 100%
          </div>

          <div class="mt-4 d-flex flex-wrap gap-2">
            <a href="{{ route('register.step1') }}" class="btn btn-green">
              Ajukan Sekarang
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-green">
              Masuk
            </a>
          </div>
        </div>

        {{-- Kanan: Ilustrasi --}}
        <div class="col-lg-6">
          <div class="d-flex justify-content-center">
            <div class="hero-illustration-box w-100" style="max-width:320px;">
              {{-- kartu kecil di pojok ilustrasi --}}
              <div class="hero-illustration-card">
                <div class="label">Limit hingga</div>
                <div class="value">Rp 20.000.000</div>
                <div class="small text-muted">tanpa riba</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    {{-- KEUNGGULAN KAMI --}}
    <section class="py-5">
      <div class="text-center mb-4">
        <h2 class="section-heading fs-4 mb-3">KEUNGGULAN KAMI</h2>
        <p class="section-desc">
          Kami berkomitmen memberikan layanan pembiayaan yang aman, transparan,
          dan sesuai prinsip syariah.
        </p>
      </div>

      <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
          <div class="keunggulan-card h-100 text-center">
            <div class="keunggulan-icon">
              <i class="bi bi-slash-circle"></i>
            </div>
            <div class="keunggulan-title">Bebas bunga</div>
            <div class="keunggulan-desc">sistem syariah tanpa riba</div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="keunggulan-card h-100 text-center">
            <div class="keunggulan-icon">
              <i class="bi bi-phone"></i>
            </div>
            <div class="keunggulan-title">Proses Digital</div>
            <div class="keunggulan-desc">Pengajuan online yang mudah</div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="keunggulan-card h-100 text-center">
            <div class="keunggulan-icon">
              <i class="bi bi-shield-check"></i>
            </div>
            <div class="keunggulan-title">Transparan penuh</div>
            <div class="keunggulan-desc">Tidak ada biaya tersembunyi</div>
          </div>
        </div>
      </div>
    </section>


    {{-- PROSES MUDAH --}}
    <section class="process-wrapper py-5">
      <div class="text-center mb-4">
        <h2 class="section-heading fs-4 mb-2">PROSES MUDAH</h2>
        <p class="section-desc">
          Hanya 3 langkah untuk mendapatkan pembiayaan
        </p>
      </div>

      <div class="row text-center g-4 justify-content-center">

        <div class="col-md-4 col-sm-6">
          <div class="step-circle">1</div>
          <div class="step-title">Ajukan Online</div>
          <div class="step-desc">
            Isi formulir pengajuan secara digital
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="step-circle">2</div>
          <div class="step-title">Verifikasi</div>
          <div class="step-desc">
            Tim kami akan memverifikasi data Anda
          </div>
        </div>

        <div class="col-md-4 col-sm-6">
          <div class="step-circle">3</div>
          <div class="step-title">Dana Cair</div>
          <div class="step-desc">
            Dana langsung cair ke rekening Anda
          </div>
        </div>

      </div>
    </section>

@endsection
