@extends('layouts.app')

@section('title', 'Rekap Transaksi')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5>Laporan dan Rekap Transaksi</h5>
        <p class="text-muted">Tampilkan laporan pendapatan dan histori transaksi parkir secara lengkap.</p>
        
        <form action="{{ route('owner.rekap.index') }}" method="GET" class="row g-3 mt-2 align-items-end mb-3">
            <div class="col-auto">
                <label class="form-label fw-semibold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" required>
            </div>
            <div class="col-auto">
                <label class="form-label fw-semibold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tampilkan</button>
                <a href="{{ route('owner.rekap.index') }}" class="btn btn-secondary">Bulan Ini</a>
            </div>
            <div class="col-auto ms-auto">
                <button type="button" class="btn btn-outline-success" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Laporan</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        @if(request('start_date') && request('end_date'))
            <h6 class="fw-bold text-secondary mb-3">
                <i class="bi bi-calendar3"></i> 
                Rekap: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
            </h6>
        @else
            <h6 class="fw-bold text-secondary mb-3">
                <i class="bi bi-calendar-check"></i> Rekap Bulan Ini ({{ now()->translatedFormat('F Y') }})
            </h6>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr class="table-dark">
                        <th>Plat Nomor</th>
                        <th>Area Parkir</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr>
                        <td><strong>{{ $t->kendaraan->plat_nomor ?? '-' }}</strong></td>
                        <td>{{ $t->areaParkir->nama_area ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->waktu_masuk)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->waktu_keluar)->format('d/m/Y H:i') }}</td>
                        <td class="text-end">Rp {{ number_format($t->biaya_total ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi parkir pada rentang waktu ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-success fw-bold">
                        <td colspan="4" class="text-end text-uppercase">Total Pendapatan:</td>
                        <td class="text-end text-success fs-5">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
