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
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #343a40; color: white; padding-top: 20px;}
        .sidebar a { color: #adb5bd; text-decoration: none; padding: 10px 20px; display: block; border-radius: 5px; margin: 5px 10px;}
        .sidebar a:hover, .sidebar a.active { background: #495057; color: white; }
        .content { padding: 30px; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <h4 class="text-center mb-4 border-bottom pb-3">
            <i class="bi bi-p-square-fill text-primary me-2"></i>Aplikasi Parkir
        </h4>
        <div class="px-3 mb-3 text-muted small">MENU {{ strtoupper(Auth::user()->role) }}</div>
        
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> Kelola User</a>
            <a href="{{ route('admin.tarif.index') }}" class="{{ request()->routeIs('admin.tarif.*') ? 'active' : '' }}"><i class="bi bi-tags me-2"></i> Tarif Parkir</a>
            <a href="{{ route('admin.area.index') }}" class="{{ request()->routeIs('admin.area.*') ? 'active' : '' }}"><i class="bi bi-map me-2"></i> Area Parkir</a>
            <a href="{{ route('admin.kendaraan.index') }}" class="{{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}"><i class="bi bi-car-front me-2"></i> Data Kendaraan</a>
            <a href="{{ route('admin.log.index') }}" class="{{ request()->routeIs('admin.log.*') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i> Log Aktifitas</a>
        @elseif(Auth::user()->role == 'petugas')
            <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="{{ route('petugas.transaksi.index') }}" class="{{ request()->routeIs('petugas.transaksi.*') ? 'active' : '' }}"><i class="bi bi-receipt me-2"></i> Transaksi Parkir</a>
        @elseif(Auth::user()->role == 'owner')
            <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="{{ route('owner.rekap.index') }}" class="{{ request()->routeIs('owner.rekap.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph me-2"></i> Rekap Transaksi</a>
        @endif

        <div class="mt-5 px-3">
            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content flex-grow-1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>@yield('title')</h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong> ({{ ucfirst(Auth::user()->role) }})</span>
            </div>
        </div>

        @yield('content')
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
