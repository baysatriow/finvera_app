@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 shadow-lg rounded-xl">
    <h2 class="text-2xl font-bold text-center mb-6">Informasi Pribadi</h2>
    <form method="POST" action="{{ route('register.step2.post') }}">
        @csrf
        <input type="date" name="date_of_birth" placeholder="Tanggal Lahir" class="border p-2 w-full rounded" required>
        <input name="occupation" placeholder="Pekerjaan" class="border p-2 w-full mt-3 rounded" required>
        <input name="monthly_income" placeholder="Pendapatan Bulanan" class="border p-2 w-full mt-3 rounded" required>
        <textarea name="address" placeholder="Alamat Lengkap" class="border p-2 w-full mt-3 rounded" required></textarea>
        <button class="w-full bg-green-700 text-white p-3 mt-4 rounded hover:bg-green-800">Daftar Akun</button>
    </form>
</div>
@endsection
