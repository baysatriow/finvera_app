@extends('layouts.app')

@section('content')
<div class="fin-auth-wrapper">

  <div class="fin-auth-card">
    <div class="fin-auth-title">Masuk</div>
    <div class="fin-auth-subtitle">
      Silakan masuk untuk melanjutkan
    </div>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="mb-3">
        <label class="fin-label">Nama Pengguna</label>
        <input type="text" name="username" class="form-control fin-form-control" placeholder="Masukkan nama pengguna" />
      </div>

      <div class="mb-3">
        <label class="fin-label">Alamat Email</label>
        <input type="email" name="email" class="form-control fin-form-control" placeholder="Masukkan alamat email" />
      </div>

      <div class="mb-4">
        <label class="fin-label">Kata Sandi</label>
        <input type="password" name="password" class="form-control fin-form-control" placeholder="Masukkan kata sandi" />
      </div>

      <button type="submit" class="btn fin-submit-btn">
        Masuk
      </button>

      <div class="text-center mt-3" style="font-size:0.9rem;">
        Belum punya akun?
        <a href="{{ route('register.step1') }}" class="text-decoration-none" style="color:var(--finvera-green-mid); font-weight:500;">
          Klik disini
        </a>
      </div>
    </form>
  </div>

</div>
@endsection
