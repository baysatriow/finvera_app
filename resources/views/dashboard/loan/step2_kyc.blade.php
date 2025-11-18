@extends('layouts.dashboard')
@section('title', 'Verifikasi KYC')
@section('header-title', 'Verifikasi Identitas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Upload Dokumen</h5>
                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Langkah 2 dari 3</span>
            </div>

            <form id="kycForm" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase text-muted">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" name="nik" id="nikInput" class="form-control py-3 bg-light border-0" placeholder="Masukkan 16 digit NIK" maxlength="16" required>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Foto KTP</label>

                        <div class="upload-box border rounded-3 p-0 position-relative bg-light overflow-hidden d-flex align-items-center justify-content-center"
                             style="border: 2px dashed #ccc !important; height: 200px; cursor: pointer;"
                             onclick="document.getElementById('ktpFile').click()">

                            <div class="text-center p-3 placeholder-content">
                                <i class="bi bi-card-heading fs-1 text-muted"></i>
                                <p class="small text-muted mt-2 mb-0">Klik upload KTP</p>
                            </div>

                            <img id="ktpPreview" src="#" alt="Preview KTP" class="d-none w-100 h-100 object-fit-cover position-absolute top-0 start-0">

                            <input type="file" name="ktp_image" id="ktpFile" class="d-none" accept="image/*" required onchange="previewFile(this, 'ktpPreview')">
                        </div>

                        <div class="small text-success mt-1 d-none file-msg text-center fw-bold">File terpilih</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Foto Selfie dengan KTP</label>

                        <div class="upload-box border rounded-3 p-0 position-relative bg-light overflow-hidden d-flex align-items-center justify-content-center"
                             style="border: 2px dashed #ccc !important; height: 200px; cursor: pointer;"
                             onclick="document.getElementById('selfieFile').click()">

                            <div class="text-center p-3 placeholder-content">
                                <i class="bi bi-person-bounding-box fs-1 text-muted"></i>
                                <p class="small text-muted mt-2 mb-0">Klik upload Selfie</p>
                            </div>

                            <img id="selfiePreview" src="#" alt="Preview Selfie" class="d-none w-100 h-100 object-fit-cover position-absolute top-0 start-0">

                            <input type="file" name="selfie_image" id="selfieFile" class="d-none" accept="image/*" required onchange="previewFile(this, 'selfiePreview')">
                        </div>

                        <div class="small text-success mt-1 d-none file-msg text-center fw-bold">File terpilih</div>
                    </div>
                </div>

                <div class="alert alert-info border-0 bg-info bg-opacity-10 d-flex align-items-center gap-3 mb-4">
                    <i class="bi bi-stars fs-4 text-info"></i>
                    <div class="small text-muted lh-sm">
                        <strong>Analisis AI Cerdas:</strong> Sistem kami akan memeriksa keaslian KTP dan kecocokan NIK Anda secara otomatis. Pastikan foto terlihat jelas.
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: var(--fin-green); border:none;">
                    Verifikasi & Lanjut
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // 1. FUNGSI PREVIEW GAMBAR
    function previewFile(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Tampilkan elemen img
                const previewImg = document.getElementById(previewId);
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');

                // Sembunyikan placeholder icon
                const container = input.parentElement;
                container.querySelector('.placeholder-content').classList.add('d-none');

                // Update style border biar kelihatan "terisi"
                container.style.borderStyle = 'solid';
                container.style.borderColor = '#607e58';

                // Tampilkan teks "File terpilih"
                container.nextElementSibling.classList.remove('d-none');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // 2. HANDLE SUBMIT (AJAX UNTUK LOADING STATE BIAR GA BERAT!)
    document.getElementById('kycForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validasi NIK di Frontend
        const nik = document.getElementById('nikInput').value;
        if (!/^[0-9]{16}$/.test(nik)) {
            Swal.fire({
                icon: 'error',
                title: 'NIK Tidak Valid',
                text: 'NIK harus terdiri dari 16 digit angka.',
                confirmButtonColor: '#607e58',
                customClass: { popup: 'rounded-4' }
            });
            return;
        }

        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Sedang Menganalisis...';

        // SweetAlert Loading Overlay
        Swal.fire({
            title: 'Memproses Data',
            text: 'AI sedang memverifikasi keaslian dokumen Anda...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            customClass: { popup: 'rounded-4' }
        });

        try {
            // Kirim Request AJAX ke Server
            const response = await fetch("{{ route('loan.storeStep2') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                // SUKSES: AI Menyetujui
                Swal.fire({
                    icon: 'success',
                    title: 'Verifikasi Berhasil!',
                    text: 'Dokumen valid. Mengalihkan ke tahap selanjutnya...',
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-4' }
                }).then(() => {
                    window.location.href = result.redirect_url;
                });
            } else {
                // GAGAL: AI Menolak atau Error Validasi
                throw new Error(result.message || 'Verifikasi gagal.');
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Verifikasi Gagal',
                text: error.message,
                confirmButtonColor: '#d33',
                customClass: { popup: 'rounded-4' }
            });

            submitBtn.disabled = false;
            submitBtn.innerText = 'Verifikasi & Lanjut';
        }
    });
</script>
@endpush
@endsection
