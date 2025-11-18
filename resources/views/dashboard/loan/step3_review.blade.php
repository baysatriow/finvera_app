@extends('layouts.dashboard')
@section('title', 'Review Pengajuan')
@section('header-title', 'Review & Persetujuan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="alert alert-success border-0 shadow-sm rounded-4 p-4 mb-4 d-flex gap-3 align-items-start bg-success bg-opacity-10">
            <div class="bg-white bg-opacity-75 rounded-circle p-2 shadow-sm text-success">
                <i class="bi bi-robot fs-3"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="fw-bold alert-heading text-success mb-2">Analisis Kelayakan AI</h5>

                <div id="ai-loading" class="d-flex align-items-center gap-2 text-muted small">
                    <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                    <span>Sedang menganalisis profil risiko Anda...</span>
                </div>

                <div id="ai-result" class="d-none text-dark opacity-75" style="line-height: 1.6; font-size: 0.95rem;">
                    </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
            <h5 class="fw-bold mb-4 text-center">Konfirmasi Pinjaman</h5>

            <div class="table-responsive mb-4">
                <table class="table table-borderless align-middle">
                    <tr>
                        <td class="text-muted">Jumlah Pinjaman</td>
                        <td class="fw-bold text-end fs-5">Rp {{ number_format($application->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tenor</td>
                        <td class="fw-bold text-end">{{ $application->tenor }} Bulan</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Cicilan Bulanan</td>
                        <td class="fw-bold text-end text-success">
                            Rp {{ number_format(ceil($application->amount / $application->tenor), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="border-top">
                        <td class="pt-3 text-muted">NIK Terverifikasi</td>
                        <td class="pt-3 fw-bold text-end">{{ $application->kycVerification->id_card_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Produk</td>
                        <td class="fw-bold text-end">{{ $application->product->description ?? 'Kredit Multiguna' }}</td>
                    </tr>
                </table>
            </div>

            <form action="{{ route('loan.submit') }}" method="POST" id="submitForm">
                @csrf
                <div class="form-check mb-4 p-3 bg-light rounded-3 border border-light">
                    <input class="form-check-input mt-1" type="checkbox" id="agree" required style="cursor: pointer;">
                    <label class="form-check-label small text-muted ms-2" for="agree" style="cursor: pointer;">
                        Saya telah membaca dan menyetujui Syarat & Ketentuan Layanan Finvera. Saya menjamin data yang diberikan adalah benar.
                    </label>
                </div>

                <button type="submit" id="btnSubmit" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: var(--fin-green); border:none;">
                    Setujui & Cairkan Dana
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchAiAnalysis();

        document.getElementById('submitForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses Pencairan...';
        });
    });

    async function fetchAiAnalysis() {
        try {
            const response = await fetch("{{ route('loan.analyze') }}");
            const data = await response.json();

            const loadingDiv = document.getElementById('ai-loading');
            const resultDiv = document.getElementById('ai-result');

            loadingDiv.classList.add('d-none');

            if(data.status === 'success') {
                let formattedText = parseMarkdown(data.analysis);
                resultDiv.innerHTML = formattedText;
            } else {
                resultDiv.innerText = "Analisis tidak tersedia saat ini.";
            }

            resultDiv.classList.remove('d-none');
            resultDiv.classList.add('fade-in');

        } catch (error) {
            console.error("AI Error:", error);
            document.getElementById('ai-loading').innerHTML = '<small class="text-danger">Gagal memuat analisis AI.</small>';
        }
    }

    // PARSE GEMINI
    function parseMarkdown(text) {
        let html = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');

        html = html.replace(/\n/g, '<br>');

        return html;
    }
</script>
@endpush
@endsection
