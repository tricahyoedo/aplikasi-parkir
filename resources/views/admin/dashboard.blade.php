@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-md-3">
        <a href="{{ route('admin.user.index') }}" class="text-decoration-none">
            <div class="card text-bg-primary mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalUser }}</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.area.index') }}" class="text-decoration-none">
            <div class="card text-bg-success mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Area Parkir</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalArea }}</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.kendaraan.index') }}" class="text-decoration-none">
            <div class="card text-bg-warning mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Kendaraan</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalKendaraan }}</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.log.index') }}" class="text-decoration-none">
            <div class="card text-bg-danger mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Log Aktifitas</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalLog }}</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <h5>Selamat Datang di Panel Admin</h5>
        <p class="text-muted">Di sini Anda memiliki hak akses penuh untuk mengelola master data aplikasi (CRUD User, Tarif, Area Parkir, Kendaraan) dan memantau Log Aktifitas sistem.</p>
    </div>
</div>
@endsection
