@extends('layouts.app')

@section('content')
<div class="fin-auth-wrapper">

  <div class="fin-auth-card">

    {{-- Progress --}}
    <div class="fin-progress-wrap">
      <div class="fin-progress-label">Langkah 2 dari 2</div>
      <div class="fin-progress-bar-bg">
        <div class="fin-progress-bar-inner step2"></div>
      </div>
    </div>

    <div class="fin-auth-title">Buat Akun Baru</div>
    <div class="fin-auth-subtitle">
      Isi informasi akun anda untuk memulai
    </div>

    <form method="POST" action="{{ route('register.step2.post') }}">
      @csrf

      <div class="mb-3">
        <label class="fin-label">Tanggal Lahir</label>
        <input type="date" name="date_of_birth" class="form-control fin-form-control" required />
      </div>

      <div class="mb-3">
        <label class="fin-label">Pekerjaan</label>
        <input type="text" name="occupation" class="form-control fin-form-control" placeholder="Masukkan pekerjaan" required />
      </div>

      <div class="mb-3">
        <label class="fin-label">Pendapatan Bulanan</label>
        <input type="number" name="monthly_income" class="form-control fin-form-control" placeholder="Rp" required />
      </div>

      <div class="mb-4">
        <label class="fin-label">Alamat Lengkap</label>
        <textarea name="address" class="form-control fin-form-control" rows="3" placeholder="Masukkan alamat lengkap (jalan, kota, provinsi, kode pos)" required></textarea>
      </div>

      <button type="submit" class="btn fin-submit-btn">
        Daftar Akun
      </button>

      <div class="mt-3 fin-terms-text">
        Dengan mendaftar anda menyetujui
        <a href="#">syarat &amp; ketentuan</a> dan
        <a href="#">kebijakan privasi</a>
      </div>
    </form>
  </div>

</div>
@endsection
