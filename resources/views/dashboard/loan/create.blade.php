@extends('layouts.dashboard')
@section('title', 'Ajukan Pinjaman')
@section('header-title', 'Pengajuan Pinjaman')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('loan.storeStep1') }}" method="POST" id="loanForm">
            @csrf
            <input type="hidden" name="product_id" id="selectedProductId" required>

            <div class="mb-4">
                <h5 class="fw-bold mb-3">1. Pilih Produk Pinjaman</h5>

                <div class="row g-3" id="productGrid">
                    @foreach($products as $prod)
                    <div class="col-md-6">
                        <div class="card product-card h-100 border shadow-sm cursor-pointer position-relative"
                             onclick="selectProduct(this, {{ $prod }})"
                             style="border-radius: 12px; transition: all 0.2s; border: 2px solid transparent;">

                            <div class="position-absolute top-0 end-0 p-2 check-icon d-none">
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            </div>

                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <div class="bg-light p-2 rounded-circle text-success icon-box">
                                        <i class="bi bi-bank fs-5"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $prod->description ?? ucfirst($prod->product_type) }}</h6>
                                </div>

                                <div class="small text-muted border-top pt-2 mt-2">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Limit:</span>
                                        <span class="fw-bold text-dark">Rp {{ number_format($prod->max_amount/1000000, 0) }} Juta</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Tenor:</span>
                                        <span class="fw-bold text-dark">{{ $prod->max_tenor }} Bulan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="alert alert-danger d-none mt-3 py-2" id="productError">
                    <small><i class="bi bi-exclamation-circle me-1"></i> Silakan pilih produk terlebih dahulu.</small>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">2. Detail Pengajuan</h5>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Langkah 1 dari 3</span>
                    </div>

                    <fieldset id="loanDetailsFieldset" disabled>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tujuan Pinjaman</label>
                            <input type="text" name="purpose" class="form-control py-3 bg-light border-0" placeholder="Contoh: Renovasi Rumah, Biaya Pendidikan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Jumlah Pinjaman</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light fw-bold text-muted">Rp</span>
                                <input type="number" name="amount" id="amountInput" class="form-control py-3 bg-light border-0" placeholder="0" required>
                            </div>
                            <div class="form-text text-danger d-none fw-bold mt-1" id="amountError"></div>
                            <div class="form-text" id="amountHint">Pilih produk untuk melihat limit.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tenor (Bulan)</label>
                            <input type="number" name="tenor" id="tenorInput" class="form-control py-3 bg-light border-0" placeholder="Contoh: 6" required>
                            <div class="form-text text-danger d-none fw-bold mt-1" id="tenorError"></div>
                            <div class="form-text" id="tenorHint">Pilih produk untuk melihat tenor.</div>
                        </div>

                        <div class="bg-success bg-opacity-10 p-4 rounded-3 mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3 text-success fw-bold">
                                <i class="bi bi-calculator"></i> Simulasi Cicilan
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Pokok Pinjaman</span>
                                <span class="fw-bold" id="simAmount">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top border-success border-opacity-25">
                                <span class="text-success fw-bold">Cicilan Per Bulan</span>
                                <span class="fs-4 fw-bold text-success" id="simMonthly">Rp 0</span>
                            </div>
                            <div class="small text-muted mt-2 fst-italic text-end">*Cicilan pokok murni tanpa bunga tambahan.</div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: var(--fin-green); border:none;">
                            Lanjutkan Pengajuan
                        </button>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="card-body">
                <h6 class="fw-bold mb-4">Tahapan Pengajuan</h6>
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex gap-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">1</div>
                        <div><div class="fw-bold">Isi Form</div><small class="text-success">Sedang berlangsung</small></div>
                    </div>
                    <div class="d-flex gap-3 opacity-50">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">2</div>
                        <div class="fw-bold align-self-center">Verifikasi KYC</div>
                    </div>
                    <div class="d-flex gap-3 opacity-50">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">3</div>
                        <div class="fw-bold align-self-center">Review & Setuju</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card { cursor: pointer; }
    .product-card:hover { border-color: #ccc !important; background-color: #f8f9fa; }

    /* Selected State */
    .product-card.selected {
        border: 2px solid var(--fin-green) !important;
        background-color: #f0fdf4;
    }
    .product-card.selected .icon-box {
        background-color: var(--fin-green) !important;
        color: white !important;
    }
    .product-card.selected .check-icon {
        display: block !important;
    }
</style>

@push('scripts')
<script>
    let currentProduct = null;

    function selectProduct(element, productData) {
        // Visual Update
        document.querySelectorAll('.product-card').forEach(el => {
            el.classList.remove('selected');
            el.querySelector('.check-icon').classList.add('d-none');
        });
        element.classList.add('selected');
        element.querySelector('.check-icon').classList.remove('d-none');

        // Set Data
        currentProduct = productData;
        document.getElementById('selectedProductId').value = productData.product_id;
        document.getElementById('productError').classList.add('d-none');

        // Enable Form
        document.getElementById('loanDetailsFieldset').disabled = false;

        // Update Hints
        const minAmt = parseInt(productData.min_amount);
        const maxAmt = parseInt(productData.max_amount);
        document.getElementById('amountHint').innerText = `Limit: Rp ${minAmt.toLocaleString('id-ID')} - Rp ${maxAmt.toLocaleString('id-ID')}`;
        document.getElementById('tenorHint').innerText = `Tenor: ${productData.min_tenor} - ${productData.max_tenor} Bulan`;

        // Re-validate if inputs exist
        validateInput();
        updateSim();
    }

    function validateInput() {
        if(!currentProduct) return false;

        const amountInput = document.getElementById('amountInput');
        const tenorInput = document.getElementById('tenorInput');
        const amount = parseFloat(amountInput.value) || 0;
        const tenor = parseInt(tenorInput.value) || 0;
        let isValid = true;

        // Validasi Amount
        const amountErr = document.getElementById('amountError');
        if (amount > 0) {
            if (amount < currentProduct.min_amount || amount > currentProduct.max_amount) {
                amountErr.innerText = `Jumlah harus antara Rp ${parseInt(currentProduct.min_amount).toLocaleString()} - Rp ${parseInt(currentProduct.max_amount).toLocaleString()}`;
                amountErr.classList.remove('d-none');
                amountInput.classList.add('is-invalid');
                isValid = false;
            } else {
                amountErr.classList.add('d-none');
                amountInput.classList.remove('is-invalid');
                amountInput.classList.add('is-valid');
            }
        }

        // Validasi Tenor
        const tenorErr = document.getElementById('tenorError');
        if (tenor > 0) {
            if (tenor < currentProduct.min_tenor || tenor > currentProduct.max_tenor) {
                tenorErr.innerText = `Tenor harus antara ${currentProduct.min_tenor} - ${currentProduct.max_tenor} bulan`;
                tenorErr.classList.remove('d-none');
                tenorInput.classList.add('is-invalid');
                isValid = false;
            } else {
                tenorErr.classList.add('d-none');
                tenorInput.classList.remove('is-invalid');
                tenorInput.classList.add('is-valid');
            }
        }

        return isValid;
    }

    function updateSim() {
        const amount = parseFloat(document.getElementById('amountInput').value) || 0;
        const tenor = parseInt(document.getElementById('tenorInput').value) || 1;

        // LOGIC CICILAN MURNI: POKOK / TENOR (TANPA BUNGA)
        const monthly = amount > 0 ? Math.ceil(amount / tenor) : 0;

        document.getElementById('simAmount').innerText = 'Rp ' + amount.toLocaleString('id-ID');
        document.getElementById('simMonthly').innerText = 'Rp ' + monthly.toLocaleString('id-ID');
    }

    document.getElementById('amountInput').addEventListener('input', () => { validateInput(); updateSim(); });
    document.getElementById('tenorInput').addEventListener('input', () => { validateInput(); updateSim(); });

    document.getElementById('loanForm').addEventListener('submit', function(e) {
        if(!document.getElementById('selectedProductId').value) {
            e.preventDefault();
            document.getElementById('productError').classList.remove('d-none');
            window.scrollTo(0,0);
            return;
        }
        if(!validateInput()) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Sesuai',
                text: 'Pastikan jumlah dan tenor sesuai dengan batas produk.',
                confirmButtonColor: '#607e58',
                customClass: { popup: 'rounded-4' }
            });
        }
    });
</script>
@endpush
@endsection
