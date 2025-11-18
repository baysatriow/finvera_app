@extends('layouts.dashboard')
@section('title', 'Cicilan Saya')
@section('header-title', 'Daftar Cicilan')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-danger text-white border-0 rounded-4 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="opacity-75">Total Tunggakan (Overdue)</h6>
                <h3 class="fw-bold">Rp {{ number_format($totalOverdue + $totalLateFee, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @if($nextInstallment)
        <div class="alert alert-warning border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 h-100">
            <i class="bi bi-exclamation-circle fs-2 text-warning"></i>
            <div>
                <div class="fw-bold">Pembayaran Berikutnya</div>
                <div>Jatuh tempo pada <strong>{{ $nextInstallment->due_date->format('d F Y') }}</strong> sebesar <strong>Rp {{ number_format($nextInstallment->amount, 0, ',', '.') }}</strong></div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="p-4 border-0">Cicilan Ke</th>
                        <th class="p-4 border-0">Jatuh Tempo</th>
                        <th class="p-4 border-0">Jumlah Tagihan</th>
                        <th class="p-4 border-0">Status</th>
                        <th class="p-4 border-0 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->installments as $inst)
                    <tr>
                        <td class="p-4 fw-bold">{{ $inst->installment_number }}</td>
                        <td class="p-4">{{ $inst->due_date->format('d M Y') }}</td>
                        <td class="p-4">
                            Rp {{ number_format($inst->amount, 0, ',', '.') }}
                            @if($inst->late_fee > 0)
                                <br><span class="text-danger small">+ Denda Rp {{ number_format($inst->late_fee, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($inst->status == 'paid')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Lunas</span>
                            @elseif($inst->status == 'overdue')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Terlambat</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Belum Bayar</span>
                            @endif
                        </td>
                        <td class="p-4 text-end">
                            @if($inst->status != 'paid')
                                <button class="btn btn-success btn-sm px-4 rounded-pill fw-bold"
                                        style="background-color: var(--fin-green); border:none;"
                                        onclick="payModal('{{ $inst->installment_id }}', {{ $inst->amount }}, {{ $inst->late_fee }})">
                                    Bayar
                                </button>
                            @else
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="payModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Pokok Cicilan</span>
                    <span class="fw-bold" id="mPokok">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-danger">
                    <span>Denda</span>
                    <span class="fw-bold" id="mDenda">Rp 0</span>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-bold small mb-2">Metode Pembayaran</label>
                    <select class="form-select py-2 bg-light border-0">
                        <option>BCA Virtual Account</option>
                        <option>Mandiri Virtual Account</option>
                        <option>GoPay</option>
                    </select>
                </div>

                <div class="bg-success bg-opacity-10 p-3 rounded-3 d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold text-success">Total Bayar</span>
                    <span class="fs-4 fw-bold text-success" id="mTotal">Rp 0</span>
                </div>

                <button class="btn btn-success w-100 py-2 fw-bold rounded-pill" style="background-color: var(--fin-green); border:none;">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function payModal(id, amount, fee) {
        let total = amount + fee;
        document.getElementById('mPokok').innerText = 'Rp ' + amount.toLocaleString('id-ID');
        document.getElementById('mDenda').innerText = 'Rp ' + fee.toLocaleString('id-ID');
        document.getElementById('mTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        new bootstrap.Modal(document.getElementById('payModal')).show();
    }
</script>
@endpush
@endsection
