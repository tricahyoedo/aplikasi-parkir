@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
<div class="row g-2 mb-2">
    <div class="col-md-12">
        <a href="{{ route('owner.rekap.index') }}" class="text-decoration-none">
            <div class="card text-bg-dark" style="margin-bottom: 0; min-height: 90px;">
                <div class="card-body" style="padding: 12px;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p style="font-size: 0.75rem; margin: 0 0 5px 0; opacity: 0.9;">Total Pendapatan (Bulan Ini)</p>
                            <p style="font-size: 1.5rem; font-weight: bold; margin: 0;">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div style="opacity: 0.3; font-size: 2rem;">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card" style="margin-bottom: 0;">
    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 10px 15px;">
        <h5 style="font-size: 0.9rem; margin: 0;">
            <i class="bi bi-info-circle me-2"></i>Selamat Datang di Panel Owner
        </h5>
    </div>
    <div class="card-body" style="padding: 12px;">
        <p style="font-size: 0.8rem; color: #666; margin: 0 0 10px 0;">
            Lihat rekapan transaksi sesuai rentang waktu yang diminta.
        </p>
        
        <form action="{{ route('owner.rekap.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <label for="startDate" class="form-label" style="font-size: 0.75rem; margin-bottom: 3px;">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" id="startDate" style="font-size: 0.8rem; padding: 5px 8px;" required>
                </div>
                <div class="col-md-3">
                    <label for="endDate" class="form-label" style="font-size: 0.75rem; margin-bottom: 3px;">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" id="endDate" style="font-size: 0.8rem; padding: 5px 8px;" required>
                </div>
                <div class="col-md-3" style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary btn-sm w-100" style="font-size: 0.75rem; padding: 5px 8px;">
                        <i class="bi bi-search me-1"></i>Tampilkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
