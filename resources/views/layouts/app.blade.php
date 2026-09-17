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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            background-color: #f0f5fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
        }

        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding-top: 30px;
            box-shadow: 2px 0 15px rgba(30, 60, 114, 0.1);
            position: fixed;
            width: 250px;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .sidebar h4 {
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
            margin: 0 20px 20px 20px;
        }

        .sidebar .menu-label {
            padding-left: 20px;
            margin-bottom: 15px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border-left: 3px solid #00bfff;
            padding-left: 17px;
        }

        .sidebar .logout-btn {
            margin-top: 40px;
            padding: 0 10px;
        }

        .sidebar .logout-btn .btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sidebar .logout-btn .btn:hover {
            background-color: rgba(255, 59, 48, 0.9);
            border-color: rgba(255, 59, 48, 0.9);
        }

        /* Main Content */
        .content {
            padding: 0;
            margin-left: 250px;
            width: calc(100% - 250px);
            main width: 0;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex: 1;
            flex-direction: column;
            position: relative;
        }

        /* Header Section */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 25px;
            box-shadow: 0 2px 8px rgba(30, 60, 114, 0.08);
            flex-shrink: 0;
            border-bottom: 1px solid #e0e6ed;
            font-size: 1rem;
        }

        .content-header h2 {
            color: #1e3c72;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }

        .content-header .user-info {
            text-align: right;
        }

        .content-header .user-info span {
            color: #666;
            font-size: 0.85rem;
            display: inline;
        }

        .content-header .user-info strong {
            color: #1e3c72;
            display: inline;
            margin: 0 5px;
        }

        /* Content wrapper untuk scrollable content */
        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 15px 20px;
            background-color: #f0f5fb;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(30, 60, 114, 0.08);
            overflow: hidden;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
        }

        .card:last-child {
            margin-bottom: 0;
        }

        .card:hover {
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.12);
        }

        .card.text-bg-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white !important;
        }

        .card.text-bg-success {
            background: linear-gradient(135deg, #00b894 0%, #00a676 100%);
            color: white !important;
        }

        .card.text-bg-warning {
            background: linear-gradient(135deg, #ffa502 0%, #ff8c00 100%);
            color: white !important;
        }

        .card.text-bg-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white !important;
        }

        .card.text-bg-info {
            background: linear-gradient(135deg, #00bfff 0%, #0080ff 100%);
            color: white !important;
        }

        .card.text-bg-dark {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white !important;
        }

        .card.text-bg-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            color: white !important;
        }

        .card-header {
            padding: 12px 18px;
            flex-shrink: 0;
        }

        .card-body {
            padding: 14px 18px;
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

        /* Button Styling */
        .btn-primary {
            background-color: #1e3c72;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0f1e3d;
            box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
        }

        .btn-secondary {
            background-color: #7f8c8d;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background-color: #5a6c7d;
        }

        /* Form Styling */
        .form-control, .form-select {
            border: 1.5px solid #e0e6ed;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            background-color: #fafbfc;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2a5298;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 10px;
            border-left: 4px solid;
        }

        .alert-danger {
            background-color: #ffe5e5;
            color: #cc0000;
            border-left-color: #ff6b6b;
        }

        .alert-success {
            background-color: #e5f9f0;
            color: #00b894;
            border-left-color: #00b894;
        }

        /* Table Styling */
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background-color: #f8fafb;
            border-bottom: 2px solid #e0e6ed;
            color: #1e3c72;
            font-weight: 700;
            padding: 15px;
        }

        .table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #e8ecf1;
        }

        .table tbody tr:hover {
            background-color: #f8fafb;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            padding: 20px 25px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Responsive */
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
                font-size: 1.3rem;
            }

            .content-header .user-info {
                text-align: center;
            }

            .card-body {
                padding: 15px;
            }

            .card-title {
                font-size: 0.8rem;
            }
        }

        i {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-start">
            <i class="bi bi-p-square-fill me-2"></i>Aplikasi Parkir
        </h4>
        <div class="menu-label">Menu {{ strtoupper(Auth::user()->role) }}</div>
        
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kelola User
            </a>
            <a href="{{ route('admin.tarif.index') }}" class="{{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Tarif Parkir
            </a>
            <a href="{{ route('admin.area.index') }}" class="{{ request()->routeIs('admin.area.*') ? 'active' : '' }}">
                <i class="bi bi-map"></i> Area Parkir
            </a>
            <a href="{{ route('admin.kendaraan.index') }}" class="{{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
                <i class="bi bi-car-front"></i> Data Kendaraan
            </a>
            <a href="{{ route('admin.log.index') }}" class="{{ request()->routeIs('admin.log.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Log Aktifitas
            </a>
        @elseif(Auth::user()->role == 'petugas')
            <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('petugas.transaksi.index') }}" class="{{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Transaksi Parkir
            </a>
        @elseif(Auth::user()->role == 'owner')
            <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('owner.rekap.index') }}" class="{{ request()->routeIs('owner.rekap.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Rekap Transaksi
            </a>
        @endif

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
                <span>Halo, {{ Auth::user()->nama_lengkap }} ({{ ucfirst(Auth::user()->role) }})</span>
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
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin keluar dari aplikasi?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Ya, Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
