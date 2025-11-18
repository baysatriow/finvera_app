@extends('layouts.dashboard')

@section('title', 'Edit Profil')
@section('header-title', 'Profil Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        @if($user->date_of_birth && $user->date_of_birth->isToday())
        <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-center gap-3 mb-4 fade show" role="alert">
            <div class="bg-warning bg-opacity-25 p-2 rounded-circle text-warning">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1">Data Tanggal Lahir Belum Valid</h6>
                <p class="mb-0 small">Sistem mendeteksi tanggal lahir Anda diset ke hari ini. Mohon segera perbarui tanggal lahir yang benar untuk keperluan verifikasi.</p>
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">

            <div class="d-flex align-items-center gap-4 mb-5 border-bottom pb-4">
                <div class="position-relative">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ substr($user->first_name, 0, 1) }}
                    </div>
                    <button class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle border shadow-sm" title="Ganti Foto">
                        <i class="bi bi-camera"></i>
                    </button>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $user->first_name }} {{ $user->last_name }}</h5>
                    <p class="text-muted mb-0 small">{{ $user->email }}</p>
                    <span class="badge {{ $user->kyc_status == 'verified' ? 'bg-success' : 'bg-warning' }} bg-opacity-25 text-dark mt-2 rounded-pill px-3">
                        <i class="bi {{ $user->kyc_status == 'verified' ? 'bi-patch-check-fill' : 'bi-clock' }} me-1"></i>
                        {{ $user->kyc_status == 'verified' ? 'Akun Terverifikasi' : 'Belum Verifikasi' }}
                    </span>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" id="profileForm" novalidate>
                @csrf
                @method('PUT')

                <h6 class="fw-bold mb-3 text-uppercase text-muted small border-start border-4 border-success ps-2">Informasi Pribadi</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Depan <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" id="firstName" class="form-control py-2 bg-light border-0" value="{{ old('first_name', $user->first_name) }}" required minlength="2">
                        <div class="invalid-feedback">Nama depan wajib diisi (min 2 karakter).</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Belakang</label>
                        <input type="text" name="last_name" class="form-control py-2 bg-light border-0" value="{{ old('last_name', $user->last_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="date_of_birth" id="dobInput" class="form-control py-2 bg-light border-0" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}" required>
                        <div class="invalid-feedback" id="dobError">Tanggal lahir wajib diisi.</div>
                        <div class="form-text small text-muted" id="ageHint">Minimal usia 20 tahun.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nomor HP <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted">+62</span>
                            <input type="text" name="phone_number" id="phoneInput" class="form-control py-2 bg-light border-0" value="{{ old('phone_number', Str::startsWith($user->phone_number, '+62') ? substr($user->phone_number, 3) : $user->phone_number) }}" required placeholder="81234567890">
                            <div class="invalid-feedback">Nomor HP tidak valid (min 10 digit angka).</div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 text-uppercase text-muted small border-start border-4 border-success ps-2">Kontak & Alamat</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="emailInput" class="form-control py-2 bg-light border-0" value="{{ old('email', $user->email) }}" required>
                        <div class="invalid-feedback" id="emailError">Format email tidak valid.</div>
                        <div class="form-text text-muted">Harus menggunakan domain .com</div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address" id="addressInput" class="form-control py-2 bg-light border-0" rows="3" required minlength="10">{{ old('address', $user->address) }}</textarea>
                        <div class="invalid-feedback">Alamat terlalu pendek (min 10 karakter).</div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 text-uppercase text-muted small border-start border-4 border-success ps-2">Data Pekerjaan</h6>
                <div class="row g-3 mb-5">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="occupation" class="form-control py-2 bg-light border-0" value="{{ old('occupation', $user->occupation) }}" required>
                        <div class="invalid-feedback">Pekerjaan wajib diisi.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Pendapatan Bulanan (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">Rp</span>
                            <input type="number" name="monthly_income" class="form-control py-2 bg-light border-0" value="{{ old('monthly_income', $user->monthly_income) }}" required min="0">
                            <div class="invalid-feedback">Pendapatan wajib diisi angka valid.</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="reset" class="btn btn-light px-4 rounded-pill fw-bold text-muted">Reset</button>
                    <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm" style="background-color: var(--fin-green); border:none;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('profileForm');

        // === 1. Validasi Email (.com only) ===
        const emailInput = document.getElementById('emailInput');
        emailInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/; // Regex khusus .com

            if (!emailRegex.test(email)) {
                this.setCustomValidity('Email harus valid dan berakhiran .com');
                document.getElementById('emailError').innerText = 'Email harus valid dan berakhiran .com';
            } else {
                this.setCustomValidity('');
            }
        });

        // === 2. Validasi Umur (Min 20 Tahun) ===
        const dobInput = document.getElementById('dobInput');
        const ageHint = document.getElementById('ageHint');
        const dobError = document.getElementById('dobError');

        dobInput.addEventListener('change', function() {
            const dob = new Date(this.value);
            const today = new Date();

            // Hitung umur
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            if (age < 20) {
                this.setCustomValidity('Umur minimal 20 tahun');
                dobError.innerText = 'Maaf, usia Anda belum mencukupi (Minimal 20 tahun).';
                ageHint.classList.add('text-danger');
                ageHint.classList.remove('text-muted');
            } else {
                this.setCustomValidity('');
                ageHint.classList.remove('text-danger');
                ageHint.classList.add('text-success');
                ageHint.innerText = `Usia Valid: ${age} tahun.`;
            }
        });

        // === 3. Validasi HP (Hanya Angka) ===
        const phoneInput = document.getElementById('phoneInput');
        phoneInput.addEventListener('input', function() {
            // Hapus karakter non-angka
            this.value = this.value.replace(/[^0-9]/g, '');

            if(this.value.length < 9) {
                this.setCustomValidity('Nomor HP terlalu pendek');
            } else {
                this.setCustomValidity('');
            }
        });

        // === 4. Form Submit Handler (Bootstrap Style) ===
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                // Trigger SweetAlert jika ada error
                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Sesuai',
                    text: 'Mohon periksa kembali inputan yang berwarna merah.',
                    confirmButtonColor: '#607e58',
                    customClass: { popup: 'rounded-4' }
                });
            } else {
                // Loading state
                const btn = form.querySelector('button[type="submit"]');
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
                btn.disabled = true;
            }

            form.classList.add('was-validated');
        }, false);
    });
</script>
@endpush
@endsection
