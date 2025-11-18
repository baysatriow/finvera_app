@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard Overview')

@section('content')
<div class="row g-4">

    <div class="col-12">
        <div class="card border-0 text-white shadow-sm overflow-hidden"
             style="background: linear-gradient(135deg, #607e58 0%, #2f4f4f 100%); border-radius: 16px;">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-start gap-3 position-relative" style="z-index: 2;">
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="bi bi-stars fs-3 text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-2">Rekomendasi Finansial AI</h5>

                        <div id="ai-loading" class="d-flex align-items-center gap-2 mt-2">
                            <div class="spinner-border spinner-border-sm text-white opacity-75" role="status"></div>
                            <span class="small opacity-75">Sedang menganalisis profil keuangan Anda...</span>
                        </div>

                        <div id="ai-result" class="d-none opacity-90" style="line-height: 1.6; font-size: 0.95rem;">
                            </div>
                    </div>
                </div>

                <i class="bi bi-robot position-absolute end-0 bottom-0 text-white opacity-10"
                   style="font-size: 8rem; margin-right: -20px; margin-bottom: -30px;"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">Limit Tersedia</h6>
                @php
                    $maxLimit = 20000000;
                    $usedLimit = $activeLoan ? $activeLoan->amount : 0;
                    $available = $maxLimit - $usedLimit;
                @endphp
                <h2 class="fw-bold text-success mb-0">Rp {{ number_format($available, 0, ',', '.') }}</h2>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: {{ ($available / $maxLimit) * 100 }}%"></div>
                </div>
                <p class="text-muted small mt-2 mb-0">Dari total limit Rp 20.000.000</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="card-body">
                <h6 class="text-muted text-uppercase fs-7 fw-bold mb-3">Pinjaman Aktif</h6>
                @if($activeLoan)
                    <h2 class="fw-bold text-dark mb-0">Rp {{ number_format($activeLoan->amount, 0, ',', '.') }}</h2>
                    <p class="text-danger small mt-2 mb-0 fw-bold">
                        <i class="bi bi-calendar-event me-1"></i>
                        Jatuh Tempo: {{ $activeLoan->due_date->format('d M Y') }}
                    </p>
                    <a href="{{ route('installments.index') }}" class="btn btn-sm btn-outline-success mt-3 rounded-pill px-3">
                        Lihat Cicilan
                    </a>
                @else
                    <h2 class="fw-bold text-muted mb-0">Rp 0</h2>
                    <p class="text-muted small mt-2 mb-0">Tidak ada tagihan aktif</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; border: 2px dashed #e0e0e0 !important;">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                <div class="mb-3 text-success bg-success bg-opacity-10 p-3 rounded-circle">
                    <i class="bi bi-plus-lg fs-4"></i>
                </div>
                <h6 class="fw-bold mb-1">Ajukan Pinjaman Baru</h6>
                <p class="text-muted small mb-3">Proses cepat & mudah tanpa ribet</p>
                <a href="{{ route('loan.create') }}" class="btn btn-success rounded-pill px-4 fw-bold" style="background-color: var(--fin-green); border:none;">
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchDashboardAi();
    });

    async function fetchDashboardAi() {
        try {
            const response = await fetch("{{ route('dashboard.ai') }}");
            const data = await response.json();

            const loadingDiv = document.getElementById('ai-loading');
            const resultDiv = document.getElementById('ai-result');

            loadingDiv.classList.add('d-none');

            if(data.status === 'success') {
                resultDiv.innerText = data.recommendation;
            } else {
                resultDiv.innerText = "Rekomendasi tidak tersedia saat ini.";
            }

            resultDiv.classList.remove('d-none');
            resultDiv.classList.add('fade-in');

        } catch (error) {
            document.getElementById('ai-loading').innerHTML = '<small class="text-white opacity-50">Gagal memuat rekomendasi.</small>';
        }
    }
</script>
@endpush
@endsection
