@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-16 bg-white p-8 shadow-lg rounded-xl">
    <h2 class="text-2xl font-bold text-center mb-6">Masuk</h2>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <input name="username" placeholder="Nama Pengguna" class="border p-2 w-full rounded">
        <input name="email" placeholder="Alamat Email" class="border p-2 w-full mt-3 rounded">
        <input type="password" name="password" placeholder="Kata Sandi" class="border p-2 w-full mt-3 rounded">
        <button class="w-full bg-green-700 text-white p-3 mt-4 rounded hover:bg-green-800">Masuk</button>
    </form>
    <p class="text-center text-sm mt-3">
        Belum punya akun? <a href="{{ route('register.step1') }}" class="text-green-700 font-semibold">Daftar</a>
    </p>
</div>
@endsection
