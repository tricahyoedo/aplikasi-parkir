<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Parkir</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            background-color: #f0fdf9;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: #1a2e2b;
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            height: 100vh;
            background: linear-gradient(160deg, #0f766e 0%, #059669 100%);
            color: white;
            padding-top: 0;
            box-shadow: 2px 0 20px rgba(15, 118, 110, 0.2);
            position: fixed;
            width: 250px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.45);
        }

        /* Sidebar brand */
        .sidebar-brand {
            padding: 22px 18px 18px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon i {
            font-size: 1.3rem;
            color: white;
        }

        .sidebar-brand .brand-text span {
            font-weight: 700;
            font-size: 0.92rem;
            color: white;
            line-height: 1.25;
            display: block;
        }

        .sidebar-brand .brand-text small {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .sidebar-nav {
            flex: 1;
            padding: 14px 0;
        }

        .sidebar .menu-label {
            padding-left: 18px;
            margin: 6px 0 8px 0;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 2px 10px;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-size: 0.88rem;
            font-weight: 500;
            position: relative;
        }

        .sidebar a i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.22);
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: -10px;
            width: 3px;
            height: 22px;
            background: #a7f3d0;
            border-radius: 2px;
        }

        .sidebar .logout-btn {
            padding: 12px 10px 18px 10px;
            flex-shrink: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar .logout-btn .btn {
            background-color: rgba(255, 255, 255, 0.12);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 10px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .sidebar .logout-btn .btn:hover {
            background-color: rgba(239, 68, 68, 0.85);
            border-color: rgba(239, 68, 68, 0.85);
        }

        /* ===================== MAIN CONTENT ===================== */
        .content {
            padding: 0;
            margin-left: 250px;
            width: calc(100% - 250px);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex: 1;
            flex-direction: column;
            position: relative;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 14px 28px;
            box-shadow: 0 1px 0 #d1fae5, 0 2px 8px rgba(0, 0, 0, 0.04);
            flex-shrink: 0;
            border-bottom: 1px solid #d1fae5;
        }

        .content-header h2 {
            color: #064e3b;
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
        }

        .content-header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0f766e, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .content-header .user-info span {
            color: #6b7280;
            font-size: 0.84rem;
        }

        .content-header .user-info strong {
            color: #064e3b;
            font-weight: 600;
        }

        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 24px;
            background-color: #f0fdf9;
        }

        /* ===================== CARDS ===================== */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s ease;
        }

        .card:last-child {
            margin-bottom: 0;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(15, 118, 110, 0.12);
        }

        .card.text-bg-primary {
            background: linear-gradient(135deg, #0f766e 0%, #059669 100%);
            color: white !important;
        }

        .card.text-bg-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white !important;
        }

        .card.text-bg-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white !important;
        }

        .card.text-bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white !important;
        }

        .card.text-bg-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white !important;
        }

        .card.text-bg-dark {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            color: white !important;
        }

        .card.text-bg-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white !important;
        }

        .card-header {
            padding: 14px 18px;
            flex-shrink: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 16px 18px;
            flex: 0 0 auto;
        }

        .card-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        /* ===================== BUTTONS ===================== */
        .btn-primary {
            background: linear-gradient(135deg, #0f766e, #059669);
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0d6b64, #047857);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-secondary {
            background-color: #6b7280;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        /* ===================== FORMS ===================== */
        .form-control,
        .form-select {
            border: 1.5px solid #d1fae5;
            border-radius: 8px;
            padding: 10px 14px;
            transition: all 0.2s ease;
            background-color: #fafafa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #10b981;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.875rem;
        }

        /* ===================== ALERTS ===================== */
        .alert {
            border: none;
            border-radius: 10px;
            border-left: 4px solid;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #b91c1c;
            border-left-color: #ef4444;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #047857;
            border-left-color: #10b981;
        }

        /* ===================== TABLES ===================== */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: #f0fdf9;
            border-bottom: 2px solid #d1fae5;
            color: #064e3b;
            font-weight: 700;
            padding: 13px 15px;
            font-size: 0.875rem;
        }

        .table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecfdf5;
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background-color: #f0fdf9;
        }

        /* ===================== MODALS ===================== */
        .modal-content {
            border: none;
            border-radius: 14px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        .modal-header {
            background: linear-gradient(135deg, #0f766e 0%, #059669 100%);
            color: white;
            border: none;
            padding: 18px 24px;
            border-radius: 14px 14px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .content {
                margin-left: 0;
                padding: 15px 20px;
            }

            .content-header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                padding: 10px 15px;
                margin-bottom: 15px;
            }

            .content-header h2 {
                font-size: 1.2rem;
            }

            .content-header .user-info {
                text-align: center;
            }

            .card-body {
                padding: 14px;
            }

            .card-title {
                font-size: 0.85rem;
            }
        }

        i {
            font-size: 1.05rem;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon" style="background:rgba(255,255,255,0.15); padding:0; overflow:hidden;">
                    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="width:40px;height:40px;display:block;">
                        <text x="36" y="72" font-family="Arial, sans-serif" font-size="66" font-weight="bold" fill="white" text-anchor="middle">P</text>
                        <rect x="50" y="66" width="22" height="7" rx="3" fill="white" opacity="0.85"/>
                        <circle cx="54" cy="74" r="3.5" fill="white" opacity="0.85"/>
                        <circle cx="68" cy="74" r="3.5" fill="white" opacity="0.85"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <span>Aplikasi Parkir</span>
                    <small>Sistem Parkir Digital</small>
                </div>
            </div>

            <div class="sidebar-nav">
                <div class="menu-label">Menu {{ strtoupper(Auth::user()->role) }}</div>

                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.user.index') }}"
                        class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Kelola User
                    </a>
                    <a href="{{ route('admin.tarif.index') }}"
                        class="{{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Tarif Parkir
                    </a>
                    <a href="{{ route('admin.area.index') }}"
                        class="{{ request()->routeIs('admin.area.*') ? 'active' : '' }}">
                        <i class="bi bi-map"></i> Area Parkir
                    </a>
                    <a href="{{ route('admin.kendaraan.index') }}"
                        class="{{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
                        <i class="bi bi-car-front"></i> Data Kendaraan
                    </a>
                    <a href="{{ route('admin.log.index') }}"
                        class="{{ request()->routeIs('admin.log.*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Log Aktifitas
                    </a>
                @elseif(Auth::user()->role == 'petugas')
                    <a href="{{ route('petugas.dashboard') }}"
                        class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('petugas.transaksi.index') }}"
                        class="{{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i> Transaksi Parkir
                    </a>
                @elseif(Auth::user()->role == 'owner')
                    <a href="{{ route('owner.dashboard') }}"
                        class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="{{ route('owner.rekap.index') }}"
                        class="{{ request()->routeIs('owner.rekap.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph"></i> Rekap Transaksi
                    </a>
                @endif
            </div>

            <div class="logout-btn">
                <button type="button" class="btn w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="content-header">
                <h2>@yield('title')</h2>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                    </div>
                    <div>
                        <span>Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong></span>
                        <span class="d-block"
                            style="font-size:0.75rem; color:#9ca3af;">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>
            </div>

            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="bi bi-box-arrow-right me-2"></i>Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px 24px; color: #374151;">
                    Apakah Anda yakin ingin keluar dari aplikasi?
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f3f4f6; padding: 16px 24px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="border-radius:8px; font-weight:600;">
                            <i class="bi bi-box-arrow-right me-1"></i>Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>