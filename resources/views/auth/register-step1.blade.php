@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 shadow-lg rounded-xl">
    <h2 class="text-2xl font-bold text-center mb-6">Buat Akun Baru</h2>
    <form method="POST" action="{{ route('register.step1.post') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <input name="first_name" placeholder="Nama Depan" class="border p-2 rounded" required>
            <input name="last_name" placeholder="Nama Belakang" class="border p-2 rounded">
        </div>
        <input name="email" placeholder="Alamat Email" class="border p-2 w-full mt-3 rounded" required>
        <input name="username" placeholder="Nama Pengguna" class="border p-2 w-full mt-3 rounded" required>
        <input type="password" name="password" placeholder="Kata Sandi" class="border p-2 w-full mt-3 rounded" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Sandi" class="border p-2 w-full mt-3 rounded" required>
        <input name="phone_number" placeholder="Nomor Telepon" class="border p-2 w-full mt-3 rounded" required>
        <button class="w-full bg-green-700 text-white p-3 mt-4 rounded hover:bg-green-800">Selanjutnya</button>
    </form>
</div>
@endsection
