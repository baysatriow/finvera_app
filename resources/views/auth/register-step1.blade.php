@extends('layouts.app')

@section('content')
<div class="fin-auth-wrapper">

  <div class="fin-auth-card">

    {{-- Progress --}}
    <div class="fin-progress-wrap">
      <div class="fin-progress-label">Langkah 1 dari 2</div>
      <div class="fin-progress-bar-bg">
        <div class="fin-progress-bar-inner" style="width:50%;"></div>
      </div>
    </div>

    <div class="fin-auth-title">Buat Akun Baru</div>
    <div class="fin-auth-subtitle">
      Isi informasi akun anda untuk memulai
    </div>

    <form method="POST" action="{{ route('register.step1.post') }}">
      @csrf

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="fin-label">Nama Depan</label>
          <input type="text" name="first_name" class="form-control fin-form-control" placeholder="Masukkan nama depan" required />
        </div>

        <div class="col-md-6 mb-3">
          <label class="fin-label">Nama Belakang</label>
          <input type="text" name="last_name" class="form-control fin-form-control" placeholder="Masukkan nama belakang" />
        </div>
      </div>

      <div class="mb-3">
        <label class="fin-label">Alamat Email</label>
        <input type="email" name="email" class="form-control fin-form-control" placeholder="Masukkan email" required />
      </div>

      <div class="mb-3">
        <label class="fin-label">Nama Pengguna</label>
        <input type="text" name="username" class="form-control fin-form-control" placeholder="Masukkan username" required />
      </div>

      <div class="mb-3">
        <label class="fin-label">Kata Sandi</label>
        <input type="password" name="password" class="form-control fin-form-control" placeholder="Masukkan kata sandi" required />
      </div>

      <div class="mb-3">
        <label class="fin-label">Konfirmasi Kata Sandi</label>
        <input type="password" name="password_confirmation" class="form-control fin-form-control" placeholder="Ulangi kata sandi" required />
      </div>

      <div class="mb-4">
        <label class="fin-label">Nomor Telepon</label>
        <input type="text" name="phone_number" class="form-control fin-form-control" placeholder="+62" required />
      </div>

      <button type="submit" class="btn fin-submit-btn">
        Selanjutnya
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
