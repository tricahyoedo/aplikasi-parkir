@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="row g-2 mb-2">
    <div class="col-md-6">
        <a href="{{ route('petugas.transaksi.index') }}" class="text-decoration-none">
            <div class="card text-bg-info" style="margin-bottom: 0; min-height: 90px;">
                <div class="card-body" style="padding: 12px;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p style="font-size: 0.75rem; margin: 0 0 5px 0; opacity: 0.9;">Kendaraan Masuk</p>
                            <p style="font-size: 1.6rem; font-weight: bold; margin: 0;">{{ $kendaraanMasuk }}</p>
                        </div>
                        <div style="opacity: 0.3; font-size: 1.8rem;">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('petugas.transaksi.index') }}" class="text-decoration-none">
            <div class="card text-bg-primary" style="margin-bottom: 0; min-height: 90px;">
                <div class="card-body" style="padding: 12px;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p style="font-size: 0.75rem; margin: 0 0 5px 0; opacity: 0.9;">Transaksi Selesai</p>
                            <p style="font-size: 1.6rem; font-weight: bold; margin: 0;">{{ $transaksiSelesai }}</p>
                        </div>
                        <div style="opacity: 0.3; font-size: 1.8rem;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card" style="margin-bottom: 0;">
    <div class="card-body" style="padding: 12px;">
        <h6 style="font-size: 0.85rem; margin-bottom: 6px; font-weight: 600;">
            <i class="bi bi-info-circle me-2"></i>Selamat Datang di Panel Petugas
        </h6>
        <p style="font-size: 0.8rem; color: #666; margin: 0 0 8px 0;">
            Gunakan menu untuk mencatat transaksi masuk/keluar kendaraan.
        </p>
        <a href="{{ route('petugas.transaksi.index') }}" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 5px 12px;">
            <i class="bi bi-plus-circle me-1"></i>Catat Kendaraan Masuk
        </a>
    </div>
</div>
@endsection
