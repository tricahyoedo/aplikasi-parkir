@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('owner.rekap.index') }}" class="text-decoration-none">
            <div class="card text-bg-dark mb-3 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan (Bulan Ini)</h5>
                    <p class="card-text fs-1 fw-bold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <h5>Selamat Datang di Panel Owner</h5>
        <p class="text-muted">Anda dapat melihat rekapan seluruh transaksi sesuai dengan rentang waktu yang Anda minta melalui menu Rekap Transaksi.</p>
        
        <form action="{{ route('owner.rekap.index') }}" method="GET" class="row g-3 mt-3 align-items-end">
            <div class="col-auto">
                <label for="startDate" class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" id="startDate" required>
            </div>
            <div class="col-auto">
                <label for="endDate" class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" id="endDate" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-0"><i class="bi bi-search"></i> Tampilkan Rekap</button>
            </div>
        </form>
    </div>
</div>
@endsection
