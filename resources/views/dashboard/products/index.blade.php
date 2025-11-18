@extends('layouts.dashboard')

@section('title', 'Produk Pinjaman')
@section('header-title', 'Manajemen Produk')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h5 class="fw-bold text-dark mb-1">Daftar Produk</h5>
        <p class="text-muted small mb-0">Kelola jenis pinjaman yang tersedia untuk pengguna.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-success fw-bold rounded-pill shadow-sm" style="background-color: var(--fin-green); border:none;">
        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
    </a>
</div>

<div class="row g-4">
    @forelse($products as $product)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-3" style="border-radius: 16px;">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="text-success bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $product->status == 'active' ? 'text-success' : 'text-secondary' }} rounded-pill px-3">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <h5 class="fw-bold mb-1">{{ $product->description }}</h5>
                <p class="text-muted small mb-3">{{ ucfirst($product->product_type) }} Loan</p>

                <div class="bg-light p-3 rounded-3 mb-4 flex-grow-1">
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="small text-muted">Limit</span>
                        <span class="small fw-bold text-dark">Rp {{ number_format($product->min_amount/1000000, 0) }}jt - {{ number_format($product->max_amount/1000000, 0) }}jt</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="small text-muted">Tenor</span>
                        <span class="small fw-bold text-dark">{{ $product->min_tenor }} - {{ $product->max_tenor }} Bulan</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Denda Late</span>
                        <span class="small fw-bold text-danger">{{ $product->late_fee_percentage }}%</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-outline-secondary w-100 rounded-pill btn-sm fw-bold">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" class="w-100" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-pill btn-sm fw-bold">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <img src="https://illustrations.popsy.co/amber/surr-searching.svg" alt="Empty" style="width: 200px; opacity: 0.6;">
        <p class="text-muted mt-3">Belum ada produk pinjaman.</p>
    </div>
    @endforelse
</div>
@endsection
