@extends('layouts.app')

@section('content')
<div class="fin-auth-wrapper">

  <div class="fin-auth-card">
    <div class="fin-auth-title">Masuk</div>
    <div class="fin-auth-subtitle">
      Silakan masuk untuk melanjutkan
    </div>

    <form method="POST" action="{{ route('login') }}">
      @csrf

      @error('login')
        <div class="alert alert-danger small py-2 mb-3 text-center rounded-3 border-0">
            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
        </div>
      @enderror

      <div class="mb-3">
        <label class="fin-label">Email atau Username</label>
        <input type="text"
               name="username"
               class="form-control fin-form-control @error('username') is-invalid @enderror"
               placeholder="Masukkan email atau username Anda"
               value="{{ old('username') }}"
               required
               autofocus />

        @error('username')
            <div class="invalid-feedback small">
                {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-4">
        <div class="d-flex justify-content-between">
            <label class="fin-label">Kata Sandi</label>
        </div>
        <input type="password"
               name="password"
               class="form-control fin-form-control @error('password') is-invalid @enderror"
               placeholder="Masukkan kata sandi"
               required />
      </div>

      <button type="submit" class="btn fin-submit-btn">
        Masuk
      </button>

      <div class="text-center mt-3" style="font-size:0.9rem;">
        Belum punya akun?
        <a href="{{ route('register.step1') }}" class="text-decoration-none" style="color:var(--finvera-green-mid); font-weight:500;">
          Daftar disini
        </a>
      </div>
    </form>
  </div>

</div>
@endsection
