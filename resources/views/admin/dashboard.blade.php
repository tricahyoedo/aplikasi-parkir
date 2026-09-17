@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row g-2 mb-2">
        <div class="col-md-3">
            <a href="{{ route('admin.user.index') }}" class="text-decoration-none">
                <div class="card text-bg-primary" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Total User</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalUser }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.area.index') }}" class="text-decoration-none">
                <div class="card text-bg-success" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Area Parkir</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalArea }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-map"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.kendaraan.index') }}" class="text-decoration-none">
                <div class="card text-bg-warning" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Total Kendaraan</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalKendaraan }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-car-front"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.log.index') }}" class="text-decoration-none">
                <div class="card text-bg-danger" style="margin-bottom: 0; min-height: 100px;">
                    <div class="card-body" style="padding: 15px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="card-title" style="margin-bottom: 8px; font-size: 0.8rem;">Log Aktifitas</p>
                                <p class="card-text" style="font-size: 1.8rem; font-weight: bold; margin: 0;">{{ $totalLog }}</p>
                            </div>
                            <div style="opacity: 0.3; font-size: 2rem;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div class="card-body" style="padding: 12px 15px;">
            <h6 style="font-size: 0.9rem; margin-bottom: 6px; font-weight: 600;">
                <i class="bi bi-info-circle me-2"></i>Selamat Datang di Panel Admin
            </h6>
            <p style="font-size: 0.8rem; color: #666; margin: 0;">
                Kelola data aplikasi: User, Tarif, Area Parkir, Kendaraan, dan pantau Log Aktifitas.
            </p>
        </div>
    </div>
@endsection