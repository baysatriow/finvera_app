<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Finvera</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --fin-green: #607e58;
            --fin-green-dark: #2f4f4f;
            --fin-bg: #f9f7f4;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--fin-bg);
            color: #333;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            border-right: 1px solid rgba(0,0,0,0.05);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            z-index: 1030;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--fin-green-dark);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            color: #666;
            font-weight: 500;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--fin-green);
            color: white;
            box-shadow: 0 4px 12px rgba(96, 126, 88, 0.25);
        }

        .nav-link i { font-size: 1.2rem; }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem 3rem;
            min-height: 100vh;
            transition: margin 0.3s ease;
        }

        /* Header */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .avatar {
            width: 45px;
            height: 45px;
            background-color: #ffecb3;
            color: #ff6f00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1.5rem; }
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-wallet2 text-success"></i> Finvera
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('loan.*') ? 'active' : '' }}" href="{{ route('loan.create') }}">
                <i class="bi bi-graph-up-arrow"></i> Pinjaman
            </a>

            @php
                $hasLoan = \App\Models\Loan::where('user_id', auth()->user()->user_id)
                            ->whereIn('status', ['active', 'defaulted'])->exists();
            @endphp

            @if($hasLoan)
            <a class="nav-link {{ request()->routeIs('installments.*') ? 'active' : '' }}" href="{{ route('installments.index') }}">
                <i class="bi bi-credit-card-2-front"></i> Cicilan Saya
            </a>
            @endif

            <div class="mt-4 mb-2 px-3 text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 700;">Lainnya</div>

            <a class="nav-link" href="#"><i class="bi bi-clock-history"></i> Riwayat</a>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <i class="bi bi-box-seam"></i> Produk Pinjaman
            </a>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                <i class="bi bi-person"></i> Profil
            </a>

            <div class="mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start text-danger bg-transparent border-0">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none shadow-sm" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list"></i>
                </button>
                <h3 class="fw-bold mb-0">@yield('header-title', 'Dashboard')</h3>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light rounded-circle p-2 position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>
                <div class="d-flex align-items-center gap-2">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold small">{{ Auth::user()->first_name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Member</div>
                    </div>
                    <div class="avatar">
                        {{ substr(Auth::user()->first_name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#607e58',
            customClass: { popup: 'rounded-4' }
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33',
            customClass: { popup: 'rounded-4' }
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
