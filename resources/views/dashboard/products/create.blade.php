@extends('layouts.dashboard')

@section('title', 'Tambah Produk')
@section('header-title', 'Tambah Produk Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">

            <form action="{{ route('products.store') }}" method="POST" id="productForm" novalidate>
                @csrf

                <h6 class="fw-bold mb-3 text-uppercase text-muted small border-start border-4 border-success ps-2">Informasi Dasar</h6>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Nama Produk / Deskripsi <span class="text-danger">*</span></label>
                    <input type="text" name="description" id="descInput" class="form-control py-2 bg-light border-0 @error('description') is-invalid @enderror" value="{{ old('description') }}" placeholder="Contoh: Kredit Multiguna Pendidikan" required minlength="5">
                    <div class="invalid-feedback">Nama produk wajib diisi (min. 5 karakter).</div>
                    @error('description') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Tipe Produk</label>
                        <select name="product_type" class="form-select py-2 bg-light border-0">
                            <option value="installment">Installment (Cicilan)</option>
                            <option value="payday">Payday (Gajian)</option>
                            <option value="micro">Micro Loan</option>
                            <option value="business">Business</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Status</label>
                        <select name="status" class="form-select py-2 bg-light border-0">
                            <option value="active">Active (Tampil)</option>
                            <option value="inactive">Inactive (Sembunyikan)</option>
                        </select>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 mt-4 text-uppercase text-muted small border-start border-4 border-success ps-2">Limit & Tenor</h6>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Min Amount (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="min_amount" id="minAmount" class="form-control py-2 bg-light border-0 @error('min_amount') is-invalid @enderror" value="{{ old('min_amount') }}" required min="1000000" step="100000">
                        <div class="form-text text-muted small">Minimal Rp 1.000.000 (Kelipatan 100rb)</div>
                        <div class="invalid-feedback" id="minAmountError">Wajib diisi, min 1 juta.</div>
                        @error('min_amount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Max Amount (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="max_amount" id="maxAmount" class="form-control py-2 bg-light border-0 @error('max_amount') is-invalid @enderror" value="{{ old('max_amount') }}" required step="100000">
                        <div class="form-text text-muted small">Harus lebih besar dari Min Amount</div>
                        <div class="invalid-feedback" id="maxAmountError">Wajib diisi, harus > Min Amount.</div>
                        @error('max_amount') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Min Tenor (Bulan) <span class="text-danger">*</span></label>
                        <input type="number" name="min_tenor" id="minTenor" class="form-control py-2 bg-light border-0 @error('min_tenor') is-invalid @enderror" value="{{ old('min_tenor', 1) }}" required min="1">
                        <div class="invalid-feedback">Wajib diisi (min 1 bulan).</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Max Tenor (Bulan) <span class="text-danger">*</span></label>
                        <input type="number" name="max_tenor" id="maxTenor" class="form-control py-2 bg-light border-0 @error('max_tenor') is-invalid @enderror" value="{{ old('max_tenor', 12) }}" required min="1">
                        <div class="invalid-feedback" id="maxTenorError">Harus >= Min Tenor.</div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3 mt-4 text-uppercase text-muted small border-start border-4 border-success ps-2">Biaya & Denda</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Denda Keterlambatan (%) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="late_fee_percentage" class="form-control py-2 bg-light border-0 @error('late_fee_percentage') is-invalid @enderror" value="{{ old('late_fee_percentage', 5) }}" required min="0" max="100">
                            <span class="input-group-text border-0 bg-light">%</span>
                            <div class="invalid-feedback">Range valid: 0-100%.</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('products.index') }}" class="btn btn-light px-4 rounded-pill fw-bold text-muted">Batal</a>
                    <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm" style="background-color: var(--fin-green); border:none;">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('productForm');
        const minAmount = document.getElementById('minAmount');
        const maxAmount = document.getElementById('maxAmount');
        const minTenor = document.getElementById('minTenor');
        const maxTenor = document.getElementById('maxTenor');

        // === 1. Validasi Realtime Nominal (Genap & Logic Min-Max) ===
        function validateAmount() {
            const minVal = parseFloat(minAmount.value) || 0;
            const maxVal = parseFloat(maxAmount.value) || 0;

            // Cek Kelipatan 100.000
            if (minVal > 0 && minVal % 100000 !== 0) {
                minAmount.setCustomValidity('Harus kelipatan 100.000');
                document.getElementById('minAmountError').innerText = 'Nominal harus kelipatan Rp 100.000';
            } else {
                minAmount.setCustomValidity('');
            }

            if (maxVal > 0 && maxVal % 100000 !== 0) {
                maxAmount.setCustomValidity('Harus kelipatan 100.000');
                document.getElementById('maxAmountError').innerText = 'Nominal harus kelipatan Rp 100.000';
            } else if (maxVal > 0 && maxVal < minVal) {
                maxAmount.setCustomValidity('Max < Min');
                document.getElementById('maxAmountError').innerText = 'Maksimum harus lebih besar dari Minimum.';
            } else {
                maxAmount.setCustomValidity('');
            }
        }

        minAmount.addEventListener('input', validateAmount);
        maxAmount.addEventListener('input', validateAmount);

        // === 2. Validasi Realtime Tenor (Logic Min-Max) ===
        function validateTenor() {
            const minT = parseInt(minTenor.value) || 0;
            const maxT = parseInt(maxTenor.value) || 0;

            if (maxT > 0 && maxT < minT) {
                maxTenor.setCustomValidity('Invalid');
                document.getElementById('maxTenorError').innerText = 'Maksimum Tenor tidak boleh kurang dari Minimum.';
            } else {
                maxTenor.setCustomValidity('');
            }
        }

        minTenor.addEventListener('input', validateTenor);
        maxTenor.addEventListener('input', validateTenor);

        // === 3. Form Submit Handler ===
        form.addEventListener('submit', function (event) {
            validateAmount(); // Re-check saat submit
            validateTenor();

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Valid',
                    text: 'Mohon periksa kembali inputan form Anda.',
                    confirmButtonColor: '#607e58',
                    customClass: { popup: 'rounded-4' }
                });
            }

            form.classList.add('was-validated');
        }, false);
    });
</script>
@endpush
@endsection
