@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="row">
    <div class="col-md-6">
        <a href="{{ route('petugas.transaksi.index') }}" class="text-decoration-none">
            <div class="card text-bg-info text-white mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Kendaraan Masuk Hari Ini</h5>
                    <p class="card-text fs-2 fw-bold">{{ $kendaraanMasuk }}</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('petugas.transaksi.index') }}" class="text-decoration-none">
            <div class="card text-bg-primary mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Transaksi Selesai</h5>
                    <p class="card-text fs-2 fw-bold">{{ $transaksiSelesai }}</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <h5>Selamat Datang di Panel Petugas</h5>
        <p class="text-muted">Gunakan menu di samping untuk mencatat transaksi masuk/keluar kendaraan dan mencetak struk parkir.</p>
        <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-circle me-1"></i> Catat Kendaraan Masuk</a>
    </div>
</div>
@endsection
